<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        /* ═══════════════════════════════════════════════════════════════
           SJI ESCUELA JURÍDICA — Official Certificate Template
           A4 Landscape (297mm × 210mm) — Optimized for DomPDF
           ═══════════════════════════════════════════════════════════════ */

        @page {
            size: A4 landscape;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            color: #111111;
            background: #FFFFFF;
            width: 297mm;
            height: 210mm;
        }

        .certificate-page {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
            background: #FFFFFF;
        }

        /* ── Ornamental Border Frame ──────────────────────────────── */
        .outer-border {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 2px solid #0B1726;
        }

        .inner-border {
            position: absolute;
            top: 12mm;
            left: 12mm;
            right: 12mm;
            bottom: 12mm;
            border: 1px solid #B99A5B;
        }

        /* ── Gold Corner Accents ──────────────────────────────────── */
        .corner {
            position: absolute;
            width: 25mm;
            height: 25mm;
            border-color: #B99A5B;
        }
        .corner-tl { top: 14mm; left: 14mm; border-top: 3px solid #B99A5B; border-left: 3px solid #B99A5B; }
        .corner-tr { top: 14mm; right: 14mm; border-top: 3px solid #B99A5B; border-right: 3px solid #B99A5B; }
        .corner-bl { bottom: 14mm; left: 14mm; border-bottom: 3px solid #B99A5B; border-left: 3px solid #B99A5B; }
        .corner-br { bottom: 14mm; right: 14mm; border-bottom: 3px solid #B99A5B; border-right: 3px solid #B99A5B; }

        /* ── Content Area ─────────────────────────────────────────── */
        .content {
            position: absolute;
            top: 20mm;
            left: 22mm;
            right: 22mm;
            text-align: center;
        }

        /* ── Header / Institution ─────────────────────────────────── */
        .institution-name {
            font-size: 11pt;
            font-weight: bold;
            letter-spacing: 4pt;
            text-transform: uppercase;
            color: #0B1726;
            margin-top: 5mm;
        }

        .institution-subtitle {
            font-size: 8pt;
            letter-spacing: 2pt;
            text-transform: uppercase;
            color: #B99A5B;
            margin-top: 2mm;
        }

        .gold-divider {
            width: 60mm;
            height: 1px;
            background: #B99A5B;
            margin: 5mm auto;
        }

        /* ── Certificate Title ────────────────────────────────────── */
        .certificate-title {
            font-size: 22pt;
            font-weight: bold;
            letter-spacing: 6pt;
            text-transform: uppercase;
            color: #0B1726;
            margin-top: 2mm;
        }

        .certificate-subtitle {
            font-size: 9pt;
            color: #666666;
            letter-spacing: 1pt;
            margin-top: 2mm;
        }

        /* ── Recipient ────────────────────────────────────────────── */
        .conferido-a {
            font-size: 9pt;
            color: #666666;
            letter-spacing: 2pt;
            text-transform: uppercase;
            margin-top: 6mm;
        }

        .student-name {
            font-size: 20pt;
            font-weight: bold;
            color: #0B1726;
            margin-top: 3mm;
            padding-bottom: 2mm;
            border-bottom: 1px solid #B99A5B;
            display: inline-block;
            min-width: 120mm;
        }

        .student-document {
            font-size: 8pt;
            color: #888888;
            margin-top: 2mm;
        }

        /* ── Course Details ────────────────────────────────────────── */
        .course-description {
            font-size: 10pt;
            color: #333333;
            line-height: 1.6;
            margin-top: 5mm;
            margin-left: auto;
            margin-right: auto;
            max-width: 200mm;
        }

        .course-name {
            font-weight: bold;
            color: #0B1726;
        }

        .course-hours {
            font-size: 9pt;
            color: #B99A5B;
            font-weight: bold;
        }

        /* ── Footer: Signatures, QR and Code ──────────────────────── */
        .footer-table {
            position: absolute;
            bottom: 20mm;
            left: 22mm;
            right: 22mm;
            width: calc(100% - 44mm);
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: bottom;
            text-align: center;
        }

        .signature-block {
            text-align: center;
        }

        .signature-line {
            width: 60mm;
            height: 1px;
            background: #0B1726;
            margin: 0 auto 2mm auto;
        }

        .signature-name {
            font-size: 8pt;
            font-weight: bold;
            color: #0B1726;
        }

        .signature-title {
            font-size: 7pt;
            color: #666666;
        }

        /* ── QR + Verification Block ──────────────────────────────── */
        .qr-block {
            text-align: center;
            width: 55mm;
        }

        .qr-image {
            width: 28mm;
            height: 28mm;
        }

        .verification-code {
            font-size: 7pt;
            font-weight: bold;
            letter-spacing: 1pt;
            color: #0B1726;
            margin-top: 1mm;
        }

        .verification-label {
            font-size: 6pt;
            color: #888888;
            margin-top: 1mm;
        }

        /* ── Issue Date ───────────────────────────────────────────── */
        .issue-date {
            font-size: 8pt;
            color: #666666;
            margin-top: 5mm;
        }

        .issue-city {
            font-size: 7pt;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="certificate-page">
        {{-- Ornamental Borders --}}
        <div class="outer-border"></div>
        <div class="inner-border"></div>

        {{-- Gold Corner Accents --}}
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>

        {{-- Main Content --}}
        <div class="content">
            <div class="institution-name">SJI Soluciones Jurídicas & Inmobiliarias</div>
            <div class="institution-subtitle">Escuela Jurídica — Educación Continua</div>

            <div class="gold-divider"></div>

            <div class="certificate-title">Certificado</div>
            <div class="certificate-subtitle">de Participación y Aprobación</div>

            <div class="conferido-a">Se confiere a</div>

            <div class="student-name">{{ $user->name }}</div>
            <div class="student-document">{{ $maskedDocument }}</div>

            <div class="course-description">
                Por haber completado satisfactoriamente el programa de formación continua<br>
                <span class="course-name">« {{ $course->title }} »</span><br>
                con una intensidad horaria de
                <span class="course-hours">{{ $course->hours_intensity }} horas</span>.
            </div>

            <div class="issue-date">
                Expedido el {{ $certificate->issued_at->translatedFormat('d \\d\\e F \\d\\e Y') }}
            </div>
            <div class="issue-city">Bogotá D.C., Colombia</div>
        </div>

        {{-- Footer: Signatures + QR --}}
        <table class="footer-table">
            <tr>
                {{-- Director Signature --}}
                <td style="width: 35%;">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-name">Dirección Académica</div>
                        <div class="signature-title">SJI Escuela Jurídica</div>
                    </div>
                </td>

                {{-- QR Verification --}}
                <td style="width: 30%;">
                    <div class="qr-block">
                        <img src="{{ $qrBase64 }}" class="qr-image" alt="QR Verificación">
                        <div class="verification-code">{{ $certificate->certificate_code }}</div>
                        <div class="verification-label">Escanee para verificar autenticidad</div>
                    </div>
                </td>

                {{-- Teacher Signature --}}
                <td style="width: 35%;">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-name">{{ $course->teacher?->name ?? 'Docente Titular' }}</div>
                        <div class="signature-title">Docente del Programa</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
