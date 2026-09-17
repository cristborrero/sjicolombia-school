<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateService
{
    /**
     * Issue a certificate for an enrollment (idempotent).
     */
    public function issueForEnrollment(Enrollment $enrollment): Certificate
    {
        $existing = Certificate::where('enrollment_id', $enrollment->id)->first();

        if ($existing) {
            return $existing;
        }

        $certificate = Certificate::create([
            'enrollment_id' => $enrollment->id,
            'user_id' => $enrollment->user_id,
            'course_id' => $enrollment->course_id,
            'certificate_code' => Certificate::generateCode(),
            'issued_at' => now(),
        ]);

        $this->generatePdf($certificate);

        return $certificate;
    }

    /**
     * Generate (or regenerate) the PDF for a certificate.
     */
    public function generatePdf(Certificate $certificate): string
    {
        $certificate->loadMissing(['user', 'course', 'enrollment']);

        // Generate QR code as base64 SVG for embedding in the PDF
        $verificationUrl = $certificate->getVerificationUrl();
        $qrSvg = QrCode::format('svg')
            ->size(150)
            ->errorCorrection('H')
            ->generate($verificationUrl);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        // Render the certificate PDF (A4 landscape)
        $pdf = Pdf::loadView('certificates.template', [
            'certificate' => $certificate,
            'user' => $certificate->user,
            'course' => $certificate->course,
            'qrBase64' => $qrBase64,
            'verificationUrl' => $verificationUrl,
            'maskedDocument' => self::maskDocument(
                $certificate->user->document_type ?? 'CC',
                $certificate->user->document_number ?? ''
            ),
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isPhpEnabled', true);

        $filename = "certificates/{$certificate->certificate_code}.pdf";

        Storage::disk('public')->put($filename, $pdf->output());

        $certificate->update(['pdf_path' => $filename]);

        return $filename;
    }

    /**
     * Mask a document number for public display (Habeas Data Ley 1581 de 2012).
     *
     * Example: CC 1234567890 → CC ***.***.***.890
     */
    public static function maskDocument(string $type, string $number): string
    {
        $clean = preg_replace('/[^0-9]/', '', $number);

        if (strlen($clean) <= 3) {
            return strtoupper($type) . ' ***';
        }

        $lastThree = substr($clean, -3);
        $maskLength = strlen($clean) - 3;
        $masked = str_repeat('*', $maskLength);

        // Group right-to-left in chunks of 3 (e.g. 10 digits -> *.***.***.890)
        $reversed = strrev($masked);
        $chunks = str_split($reversed, 3);
        $formattedMask = strrev(implode('.', $chunks));

        return strtoupper($type) . ' ' . $formattedMask . '.' . $lastThree;
    }
}
