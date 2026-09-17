<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Support\Facades\Storage;

class CertificateVerificationController extends Controller
{
    /**
     * Public verification page — no auth required.
     * Reached by scanning the QR code on the certificate or direct code lookup.
     */
    public function verify(?string $code = null)
    {
        $code = $code ?: request('code') ?: request('codigo');

        if (! $code) {
            return view('certificates.verify', [
                'certificate' => null,
                'maskedDocument' => null,
                'code' => null,
            ]);
        }

        $code = trim($code);
        $certificate = Certificate::with(['user', 'course', 'enrollment'])
            ->where('certificate_code', strtoupper($code))
            ->first();

        $maskedDocument = null;
        if ($certificate) {
            $maskedDocument = CertificateService::maskDocument(
                $certificate->user->document_type ?? 'CC',
                $certificate->user->document_number ?? ''
            );
        }

        return view('certificates.verify', [
            'certificate' => $certificate,
            'maskedDocument' => $maskedDocument,
            'code' => $code,
        ]);
    }

    /**
     * Public PDF download — accessible from the verification page.
     */
    public function downloadPublicPdf(string $code)
    {
        $certificate = Certificate::where('certificate_code', strtoupper($code))->firstOrFail();

        if (! $certificate->pdf_path || ! Storage::disk('public')->exists($certificate->pdf_path)) {
            app(CertificateService::class)->generatePdf($certificate);
            $certificate->refresh();
        }

        return Storage::disk('public')->download(
            $certificate->pdf_path,
            "Certificado-{$certificate->certificate_code}.pdf"
        );
    }
}
