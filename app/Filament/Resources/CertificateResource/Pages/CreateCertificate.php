<?php

namespace App\Filament\Resources\CertificateResource\Pages;

use App\Filament\Resources\CertificateResource;
use App\Services\CertificateService;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificate extends CreateRecord
{
    protected static string $resource = CertificateResource::class;

    protected function afterCreate(): void
    {
        try {
            app(CertificateService::class)->generatePdf($this->record);
        } catch (\Throwable $e) {
            // Log or ignore if PDF generation fails in background
        }
    }
}
