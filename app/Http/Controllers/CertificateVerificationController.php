<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateVerificationController extends Controller
{
    /**
     * Show the certificate verification form.
     */
    public function showForm()
    {
        return view('certificates.verify');
    }

    /**
     * Verify a certificate by its code.
     */
    public function verify(string $code)
    {
        $certificate = Certificate::with(['user', 'course'])
            ->where('certificate_code', strtoupper($code))
            ->first();

        return view('certificates.verify', compact('certificate', 'code'));
    }
}
