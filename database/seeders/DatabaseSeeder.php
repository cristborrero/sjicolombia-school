<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\CourseSession;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Users ───────────────────────────────────────

        $admin = User::create([
            'name' => 'Admin SJI',
            'email' => 'admin@sjicolombia.com',
            'password' => Hash::make('password'),
            'document_type' => 'CC',
            'document_number' => '1234567890',
            'phone_whatsapp' => '+573001234567',
            'city' => 'Santa Marta',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $teacher = User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'profesor@sjicolombia.com',
            'password' => Hash::make('password'),
            'document_type' => 'CC',
            'document_number' => '9876543210',
            'phone_whatsapp' => '+573009876543',
            'city' => 'Santa Marta',
            'role' => 'teacher',
            'is_active' => true,
        ]);

        $student = User::create([
            'name' => 'María García',
            'email' => 'estudiante@sjicolombia.com',
            'password' => Hash::make('password'),
            'document_type' => 'CC',
            'document_number' => '5555555555',
            'phone_whatsapp' => '+573005555555',
            'city' => 'Bogotá',
            'role' => 'student',
            'is_active' => true,
        ]);

        $student2 = User::create([
            'name' => 'Carlos Rodríguez',
            'email' => 'carlos@ejemplo.com',
            'password' => Hash::make('password'),
            'document_type' => 'CC',
            'document_number' => '8888888888',
            'phone_whatsapp' => '+573008888888',
            'city' => 'Barranquilla',
            'role' => 'student',
            'is_active' => true,
        ]);

        $student3 = User::create([
            'name' => 'Ana López',
            'email' => 'ana@ejemplo.com',
            'password' => Hash::make('password'),
            'document_type' => 'CE',
            'document_number' => '7777777777',
            'phone_whatsapp' => '+573007777777',
            'city' => 'Medellín',
            'role' => 'student',
            'is_active' => true,
        ]);

        // ─── Course ──────────────────────────────────────

        $course = Course::create([
            'title' => 'Propiedad Horizontal: Régimen Legal y Administración',
            'slug' => 'propiedad-horizontal-regimen-legal',
            'short_description' => 'Curso integral sobre el régimen de propiedad horizontal en Colombia, dirigido a administradores, consejeros y copropietarios.',
            'syllabus' => "## Módulo 1: Fundamentos de la Ley 675 de 2001\n- Concepto y naturaleza jurídica\n- Órganos de dirección y administración\n\n## Módulo 2: Asambleas y Consejos\n- Convocatorias y quórum\n- Actas y decisiones\n\n## Módulo 3: Presupuesto y Obligaciones\n- Cuotas de administración\n- Fondo de imprevistos\n\n## Módulo 4: Solución de Conflictos\n- Mecanismos alternativos\n- Jurisprudencia relevante",
            'price_cop' => 350000.00,
            'hours_intensity' => 20,
            'max_capacity' => 50,
            'status' => 'published',
            'teacher_id' => $teacher->id,
            'starts_at' => now()->subDays(3),
        ]);

        // ─── Sessions (mix of past, today, upcoming) ─────

        $sessionData = [
            [
                'title' => 'Sesión 1: Fundamentos de la Ley 675 de 2001',
                'description' => 'Clase en vivo sobre concepto, naturaleza jurídica y ámbito de aplicación.',
                'scheduled_at' => now()->subDays(3)->setHour(19)->setMinute(0),
                'meet_url' => 'https://meet.google.com/abc-defg-hij',
            ],
            [
                'title' => 'Sesión 2: Órganos de Dirección y Administración',
                'description' => 'Asamblea general, consejo de administración y administrador.',
                'scheduled_at' => now()->subDay()->setHour(19)->setMinute(0),
                'meet_url' => 'https://meet.google.com/abc-defg-hij',
            ],
            [
                'title' => 'Sesión 3: Asambleas — Convocatorias y Quórum',
                'description' => 'Requisitos legales, quórum decisorio y actas.',
                'scheduled_at' => now()->setHour(19)->setMinute(0),
                'meet_url' => 'https://meet.google.com/klm-nopq-rst',
            ],
            [
                'title' => 'Sesión 4: Presupuesto y Cuotas de Administración',
                'description' => 'Formulación del presupuesto, fondo de imprevistos, cobro coactivo.',
                'scheduled_at' => now()->addDays(3)->setHour(19)->setMinute(0),
                'meet_url' => 'https://meet.google.com/uvw-xyz1-234',
            ],
            [
                'title' => 'Sesión 5: Solución de Conflictos en Propiedad Horizontal',
                'description' => 'Mecanismos alternativos y jurisprudencia relevante.',
                'scheduled_at' => now()->addDays(6)->setHour(19)->setMinute(0),
                'meet_url' => null,
            ],
        ];

        foreach ($sessionData as $index => $data) {
            CourseSession::create([
                'course_id' => $course->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'scheduled_at' => $data['scheduled_at'],
                'meet_url' => $data['meet_url'],
                'meet_source' => 'manual',
                'order_index' => $index,
            ]);
        }

        // ─── Enrollments (3 students with active enrollment) ─

        foreach ([$student, $student2, $student3] as $s) {
            $enrollment = Enrollment::create([
                'user_id' => $s->id,
                'course_id' => $course->id,
                'status' => 'active',
                'enrolled_at' => now()->subDays(5),
            ]);

            Payment::create([
                'enrollment_id' => $enrollment->id,
                'user_id' => $s->id,
                'gateway' => 'bold',
                'gateway_transaction_id' => 'SEED-' . strtoupper(substr(md5($s->email), 0, 8)),
                'gateway_reference' => 'REF-' . $enrollment->id,
                'amount_cop' => 350000.00,
                'payment_method' => 'PSE',
                'status' => 'APPROVED',
                'paid_at' => now()->subDays(5),
            ]);
        }

        // ─── Sample Course Materials ─────────────────────

        // Create a dummy PDF so the download route has something to serve
        Storage::disk('local')->makeDirectory("materials/{$course->id}");
        $dummyContent = '%PDF-1.4 dummy content for testing';
        Storage::disk('local')->put("materials/{$course->id}/guia-modulo-1.pdf", $dummyContent);
        Storage::disk('local')->put("materials/{$course->id}/ley-675-2001.pdf", $dummyContent);

        $sessions = $course->sessions;

        // General material (not tied to a session)
        CourseMaterial::create([
            'course_id' => $course->id,
            'course_session_id' => null,
            'title' => 'Ley 675 de 2001 — Texto Completo',
            'file_path' => "materials/{$course->id}/ley-675-2001.pdf",
            'file_type' => 'pdf',
            'file_size_bytes' => 245760,
        ]);

        // Session-level material
        CourseMaterial::create([
            'course_id' => $course->id,
            'course_session_id' => $sessions->first()?->id,
            'title' => 'Guía de Estudio — Módulo 1',
            'file_path' => "materials/{$course->id}/guia-modulo-1.pdf",
            'file_type' => 'pdf',
            'file_size_bytes' => 102400,
        ]);
    }
}
