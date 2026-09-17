<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Matrícula Confirmada</title>
</head>
<body style="margin:0;padding:0;background-color:#F5F2EA;font-family:'Montserrat','Helvetica Neue',Arial,sans-serif;color:#111111;">

    {{-- Header --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#0B1726;">
        <tr>
            <td align="center" style="padding:28px 24px;">
                <span style="font-family:Georgia,serif;font-size:22px;font-weight:700;color:#FFFFFF;letter-spacing:0.02em;">
                    SJI Escuela Jurídica
                </span>
            </td>
        </tr>
        <tr>
            <td style="height:2px;background-color:#B99A5B;"></td>
        </tr>
    </table>

    {{-- Body --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding:40px 16px;">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background:#FFFFFF;border:1px solid #e8e5dd;border-radius:6px;max-width:600px;width:100%;">
                    <tr>
                        <td style="padding:40px 32px;">
                            {{-- Greeting --}}
                            <p style="font-size:16px;margin:0 0 24px;color:#111;">
                                Hola <strong>{{ $enrollment->user->name }}</strong>,
                            </p>

                            <p style="font-size:15px;margin:0 0 24px;color:#333;line-height:1.6;">
                                Tu matrícula al curso <strong style="color:#0B1726;">{{ $enrollment->course->title }}</strong> ha sido confirmada exitosamente. Ya puedes acceder a tu Aula Virtual.
                            </p>

                            {{-- Course Details Card --}}
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#F5F2EA;border:1px solid rgba(185,154,91,0.2);border-radius:4px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="font-size:11px;font-weight:700;color:#B99A5B;text-transform:uppercase;letter-spacing:0.15em;margin:0 0 8px;">
                                            Datos del curso
                                        </p>
                                        <p style="font-size:15px;font-weight:600;color:#0B1726;margin:0 0 4px;">
                                            {{ $enrollment->course->title }}
                                        </p>
                                        @if($enrollment->course->teacher)
                                            <p style="font-size:13px;color:#666;margin:0 0 4px;">
                                                Docente: {{ $enrollment->course->teacher->name }}
                                            </p>
                                        @endif
                                        <p style="font-size:13px;color:#666;margin:0 0 4px;">
                                            Intensidad: {{ $enrollment->course->hours_intensity }} horas
                                        </p>
                                        @if($enrollment->course->starts_at)
                                            <p style="font-size:13px;color:#666;margin:0;">
                                                Inicia: {{ $enrollment->course->starts_at->translatedFormat('d \d\e F, Y') }}
                                            </p>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            {{-- CTA Button --}}
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/cursos/' . $enrollment->course->slug . '/aula') }}"
                                           style="display:inline-block;background-color:#0B1726;color:#FFFFFF;font-family:'Montserrat',sans-serif;font-weight:600;font-size:14px;letter-spacing:0.03em;padding:14px 36px;border-radius:4px;text-decoration:none;">
                                            Entrar al Aula Virtual
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:13px;color:#888;line-height:1.6;margin:0;">
                                Si tienes alguna pregunta, contáctanos por
                                <a href="https://wa.me/573001234567" style="color:#25D366;text-decoration:none;font-weight:600;">WhatsApp</a>.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Footer --}}
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding:16px 24px 32px;">
                <p style="font-size:11px;color:#999;margin:0;">
                    &copy; {{ date('Y') }} SJI Colombia. Todos los derechos reservados.
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
