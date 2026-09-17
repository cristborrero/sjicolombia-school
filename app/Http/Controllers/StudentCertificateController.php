<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentCertificateController extends Controller
{
    /**
     * Authenticated download of a student's own certificate.
     */
    public function download(string $courseSlug)
    {
        $user = Auth::user();

        $certificate = Certificate::whereHas('course', fn ($q) => $q->where('slug', $courseSlug))
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (! $certificate->pdf_path || ! Storage::disk('public')->exists($certificate->pdf_path)) {
            app(\App\Services\CertificateService::class)->generatePdf($certificate);
            $certificate->refresh();
        }

        return Storage::disk('public')->download(
            $certificate->pdf_path,
            "Certificado-{$certificate->certificate_code}.pdf"
        );
    }
}
