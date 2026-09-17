<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CertificateVerificationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentCertificateController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\WebhookController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage (catalog landing)
Route::get('/', function () {
    $courses = Course::with(['teacher', 'sessions'])
        ->whereIn('status', ['published', 'in_progress'])
        ->latest('starts_at')
        ->take(6)
        ->get();

    return view('welcome', compact('courses'));
});

// Course catalog & detail
Route::get('/cursos', [CourseController::class, 'index'])->name('courses.index');
Route::get('/cursos/{slug}', [CourseController::class, 'show'])->name('courses.show');

// Certificate verification (public — QR destination or manual code search)
Route::get('/verificar/{code?}', [CertificateVerificationController::class, 'verify'])->name('certificates.verify');
Route::post('/verificar', function (\Illuminate\Http\Request $request) {
    $code = trim($request->input('code') ?? $request->input('codigo') ?? '');
    if (empty($code)) {
        return redirect()->route('certificates.verify');
    }
    return redirect()->route('certificates.verify', ['code' => strtoupper($code)]);
})->name('certificates.verify.post');
Route::get('/verificar/{code}/pdf', [CertificateVerificationController::class, 'downloadPublicPdf'])->name('certificate.public.pdf');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/registro', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/registro', [RegisterController::class, 'register']);
    Route::get('/ingresar', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/ingresar', [LoginController::class, 'login']);
});

Route::post('/salir', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Checkout
    Route::post('/checkout/{course}', [CheckoutController::class, 'initiate'])->name('checkout.initiate');

    // My Courses
    Route::get('/mis-cursos', function () {
        return view('courses.my-courses');
    })->name('my-courses');

    // Virtual Classroom (enrolled students only)
    Route::get('/cursos/{slug}/aula', [ClassroomController::class, 'show'])->name('classroom.show');
    Route::get('/materiales/{material}/descargar', [ClassroomController::class, 'downloadMaterial'])->name('classroom.download');

    // Student Certificate Download
    Route::get('/mis-cursos/{courseSlug}/certificado', [StudentCertificateController::class, 'download'])->name('student.certificate.download');

    // Teacher Dashboard (teacher + admin only)
    Route::get('/docente/{slug}/asistencia', [TeacherDashboardController::class, 'roster'])->name('teacher.roster');
    Route::post('/docente/{slug}/materiales', [TeacherDashboardController::class, 'uploadMaterial'])->name('teacher.upload-material');
});

/*
|--------------------------------------------------------------------------
| Payment Result Pages
|--------------------------------------------------------------------------
*/

Route::get('/pago/exitoso', fn() => view('payments.success'))->name('payments.success');
Route::get('/pago/fallido', fn() => view('payments.failed'))->name('payments.failed');

/*
|--------------------------------------------------------------------------
| Webhooks (no CSRF, external gateway callbacks)
|--------------------------------------------------------------------------
*/

Route::withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->group(function () {
    Route::post('/webhooks/bold', [WebhookController::class, 'boldWebhook'])->name('payments.bold.webhook');
    Route::post('/webhooks/epayco', [WebhookController::class, 'epaycoWebhook'])->name('payments.epayco.webhook');
    Route::get('/webhooks/epayco/response', [WebhookController::class, 'epaycoResponse'])->name('payments.epayco.response');
});
