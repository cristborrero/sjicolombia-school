<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Services\CertificateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CertificateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    private function createCourse(array $attributes = []): Course
    {
        static $counter = 1;
        $title = $attributes['title'] ?? 'Curso Jurídico ' . $counter++;

        return Course::create(array_merge([
            'title' => $title,
            'slug' => $attributes['slug'] ?? \Illuminate\Support\Str::slug($title),
            'short_description' => 'Descripción breve del curso.',
            'price_cop' => 250000.00,
            'hours_intensity' => 20,
            'max_capacity' => 30,
            'status' => 'published',
            'starts_at' => now()->subDays(5),
        ], $attributes));
    }

    public function test_certificate_code_is_unique_and_follows_format(): void
    {
        $code1 = Certificate::generateCode();
        $code2 = Certificate::generateCode();

        $year = now()->year;
        $this->assertMatchesRegularExpression("/^SJI-{$year}-[A-Z0-9]{5}$/", $code1);
        $this->assertMatchesRegularExpression("/^SJI-{$year}-[A-Z0-9]{5}$/", $code2);
        $this->assertNotEquals($code1, $code2);
    }

    public function test_mask_document_protects_habeas_data(): void
    {
        $masked1 = CertificateService::maskDocument('CC', '1234567890');
        $this->assertEquals('CC *.***.***.890', $masked1);

        $masked2 = CertificateService::maskDocument('CE', '123');
        $this->assertEquals('CE ***', $masked2);

        $masked3 = CertificateService::maskDocument('CC', '1098765432');
        $this->assertStringEndsWith('432', $masked3);
        $this->assertStringContainsString('***', $masked3);
    }

    public function test_certificate_service_issues_certificate_and_generates_pdf(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create([
            'role' => 'student',
            'document_type' => 'CC',
            'document_number' => '1020304050',
        ]);

        $course = $this->createCourse([
            'teacher_id' => $teacher->id,
            'title' => 'Curso de Prueba Derecho Inmobiliario',
            'slug' => 'derecho-inmobiliario',
            'hours_intensity' => 30,
        ]);

        $enrollment = Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'completed',
            'enrolled_at' => now(),
        ]);

        $service = app(CertificateService::class);
        $certificate = $service->issueForEnrollment($enrollment);

        $this->assertInstanceOf(Certificate::class, $certificate);
        $this->assertEquals($student->id, $certificate->user_id);
        $this->assertEquals($course->id, $certificate->course_id);
        $this->assertNotNull($certificate->certificate_code);
        $this->assertNotNull($certificate->pdf_path);

        Storage::disk('public')->assertExists($certificate->pdf_path);

        // Test idempotency
        $second = $service->issueForEnrollment($enrollment);
        $this->assertEquals($certificate->id, $second->id);
        $this->assertEquals(1, Certificate::where('enrollment_id', $enrollment->id)->count());
    }

    public function test_public_verification_page_displays_valid_certificate(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher', 'name' => 'Profesor Experto']);
        $student = User::factory()->create([
            'role' => 'student',
            'name' => 'Carlos Estudiante',
            'document_type' => 'CC',
            'document_number' => '1234567890',
        ]);

        $course = $this->createCourse([
            'teacher_id' => $teacher->id,
            'title' => 'Régimen de Propiedad Horizontal',
            'hours_intensity' => 40,
        ]);

        $enrollment = Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'completed',
            'enrolled_at' => now(),
        ]);

        $service = app(CertificateService::class);
        $certificate = $service->issueForEnrollment($enrollment);

        $response = $this->get("/verificar/{$certificate->certificate_code}");

        $response->assertStatus(200);
        $response->assertSee('Certificado Oficial Verificado');
        $response->assertSee('Carlos Estudiante');
        $response->assertSee('Régimen de Propiedad Horizontal');
        $response->assertSee('40 horas');
        $response->assertSee($certificate->certificate_code);
    }

    public function test_public_can_access_verification_index_page(): void
    {
        $response = $this->get('/verificar');

        $response->assertStatus(200);
        $response->assertSee('Verificación de Certificados');
        $response->assertSee('Validar Certificado');
    }

    public function test_public_can_submit_code_search_form(): void
    {
        $response = $this->post('/verificar', ['code' => 'sji-2026-test1']);

        $response->assertRedirect('/verificar/SJI-2026-TEST1');
    }

    public function test_public_verification_page_shows_invalid_state_for_unknown_code(): void
    {
        $response = $this->get('/verificar/SJI-9999-FAKE0');

        $response->assertStatus(200);
        $response->assertSee('Certificado No Encontrado');
        $response->assertSee('Código de verificación no registrado');
        $response->assertSee('SJI-9999-FAKE0');
    }

    public function test_public_can_download_verified_pdf(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = $this->createCourse();
        $enrollment = Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'completed',
        ]);

        $service = app(CertificateService::class);
        $certificate = $service->issueForEnrollment($enrollment);

        $response = $this->get("/verificar/{$certificate->certificate_code}/pdf");

        $response->assertStatus(200);
        $response->assertHeader('content-disposition');
    }

    public function test_authenticated_student_can_download_their_certificate(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = $this->createCourse(['slug' => 'curso-activo']);
        $enrollment = Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'completed',
        ]);

        $service = app(CertificateService::class);
        $certificate = $service->issueForEnrollment($enrollment);

        $response = $this->actingAs($student)->get("/mis-cursos/{$course->slug}/certificado");

        $response->assertStatus(200);
        $response->assertHeader('content-disposition');
    }

    public function test_unauthenticated_user_cannot_access_student_certificate_route(): void
    {
        $response = $this->get('/mis-cursos/algun-curso/certificado');

        $response->assertRedirect('/ingresar');
    }
}
