@extends('layouts.app')

@section('title', 'Verificación de Certificado — SJI Escuela Jurídica')
@section('meta_description', 'Portal público de verificación de autenticidad de certificados emitidos por SJI Escuela Jurídica.')

@section('content')

    {{-- ═══════════════════════════════════════════════════════════
         PUBLIC CERTIFICATE VERIFICATION PAGE
         Accessible without login — scanned from QR on certificate
         ═══════════════════════════════════════════════════════════ --}}

    <section class="min-h-screen bg-ivory py-16 px-4">
        <div class="max-w-2xl mx-auto">

            @if ($certificate)
                {{-- ── Valid Certificate ──────────────────────────────── --}}

                {{-- Authenticity Badge --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-2.5 rounded-full text-sm font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Certificado Oficial Verificado
                    </div>
                </div>

                {{-- Institution Header --}}
                <div class="text-center mb-8">
                    <h1 class="font-display text-2xl md:text-3xl text-navy font-bold tracking-wide">
                        SJI Escuela Jurídica
                    </h1>
                    <p class="text-sm text-gold font-semibold tracking-widest uppercase mt-1">
                        Verificación de Autenticidad
                    </p>
                </div>

                {{-- Certificate Details Card --}}
                <div class="bg-white border border-gold/20 rounded-card shadow-sm overflow-hidden">

                    {{-- Card Header --}}
                    <div class="bg-navy px-6 py-4">
                        <p class="text-xs text-gold/80 tracking-widest uppercase font-semibold">Certificado de Participación y Aprobación</p>
                        <p class="text-white font-display text-lg mt-1 font-semibold">{{ $certificate->course->title }}</p>
                    </div>

                    {{-- Card Body --}}
                    <div class="px-6 py-6 space-y-4">

                        {{-- Student Name --}}
                        <div class="border-b border-ivory-200 pb-3">
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Otorgado a</p>
                            <p class="text-lg text-navy font-bold mt-0.5">{{ $certificate->user->name }}</p>
                        </div>

                        {{-- Grid: Document, Hours, Date, Code --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Identificación</p>
                                <p class="text-sm text-ink font-medium mt-0.5">{{ $maskedDocument }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Intensidad Horaria</p>
                                <p class="text-sm text-ink font-medium mt-0.5">{{ $certificate->course->hours_intensity }} horas</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Fecha de Expedición</p>
                                <p class="text-sm text-ink font-medium mt-0.5">{{ $certificate->issued_at->translatedFormat('d \\d\\e F \\d\\e Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Código de Verificación</p>
                                <p class="text-sm text-navy font-bold font-mono mt-0.5">{{ $certificate->certificate_code }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Download Action --}}
                    @if ($certificate->pdf_path)
                        <div class="px-6 pb-6">
                            <a href="{{ route('certificate.public.pdf', $certificate->certificate_code) }}"
                               class="block w-full text-center bg-navy text-white text-sm font-bold py-3 rounded-subtle hover:bg-navy-50 transition-colors tracking-wider uppercase">
                                Descargar Certificado Oficial (PDF)
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Institutional Seal --}}
                <div class="text-center mt-8">
                    <div class="inline-flex items-center gap-1.5 text-xs text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Documento verificado por el sistema institucional de SJI Colombia
                    </div>
                </div>

            @elseif ($code)
                {{-- ── Invalid Code ──────────────────────────────────── --}}

                <div class="text-center">
                    <div class="inline-flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-5 py-2.5 rounded-full text-sm font-semibold mb-6">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Certificado No Encontrado
                    </div>

                    <h1 class="font-display text-2xl text-navy font-bold mb-3">
                        Código de verificación no registrado
                    </h1>

                    <div class="bg-white border border-gray-200 rounded-card p-6 max-w-lg mx-auto shadow-sm mb-8">
                        <p class="text-sm text-gray-600 leading-relaxed mb-6">
                            El código <strong class="font-mono text-navy bg-gray-100 px-2 py-0.5 rounded">{{ $code }}</strong>
                            no corresponde a ningún certificado emitido por SJI Escuela Jurídica o ha sido revocado.
                        </p>

                        {{-- Search Again Form --}}
                        <form action="{{ route('certificates.verify.post') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text"
                                       name="code"
                                       placeholder="Ej: SJI-2026-AC626"
                                       required
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-subtle font-mono text-sm focus:outline-none focus:border-gold uppercase">
                                <button type="submit"
                                        class="bg-navy text-white text-xs font-bold px-6 py-3 rounded-subtle uppercase tracking-wider hover:bg-navy-50 transition-colors whitespace-nowrap">
                                    Verificar
                                </button>
                            </div>
                        </form>

                        <p class="text-xs text-gray-400 mt-4">
                            Si cree que esto es un error, por favor contacte a
                            <a href="mailto:info@sjicolombia.com" class="text-gold hover:underline">info@sjicolombia.com</a>.
                        </p>
                    </div>

                    <a href="{{ url('/') }}" class="inline-block text-sm text-gold font-semibold hover:text-gold-600 transition-colors">
                        ← Volver al inicio
                    </a>
                </div>

            @else
                {{-- ── Portal Home: Search Form ───────────────────────── --}}

                <div class="text-center mb-8">
                    <div class="w-14 h-14 bg-gold/10 text-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h1 class="font-display text-2xl md:text-3xl text-navy font-bold tracking-wide">
                        Verificación de Certificados
                    </h1>
                    <p class="text-sm text-gold font-semibold tracking-widest uppercase mt-1">
                        SJI Escuela Jurídica
                    </p>
                    <p class="text-sm text-gray-500 max-w-md mx-auto mt-3">
                        Consulte la autenticidad y vigencia de los certificados académicos emitidos por nuestra institución.
                    </p>
                </div>

                <div class="bg-white border border-gold/20 rounded-card p-8 max-w-lg mx-auto shadow-sm">
                    <form action="{{ route('certificates.verify.post') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="code" class="block text-xs font-bold text-navy uppercase tracking-wider mb-2 text-left">
                                Código de Certificación
                            </label>
                            <input type="text"
                                   id="code"
                                   name="code"
                                   placeholder="Ej: SJI-2026-AC626"
                                   required
                                   autofocus
                                   class="w-full px-4 py-3.5 border border-gray-300 rounded-subtle font-mono text-base focus:outline-none focus:border-gold uppercase">
                            <p class="text-[11px] text-gray-400 text-left mt-1.5">
                                Ingrese el código alfanumérico que aparece debajo del código QR en el certificado.
                            </p>
                        </div>

                        <button type="submit"
                                class="w-full bg-navy text-white text-xs font-bold py-3.5 rounded-subtle uppercase tracking-widest hover:bg-navy-50 transition-colors">
                            Validar Certificado
                        </button>
                    </form>
                </div>

                <div class="text-center mt-8">
                    <a href="{{ url('/') }}" class="text-sm text-gold font-semibold hover:text-gold-600 transition-colors">
                        ← Volver al inicio
                    </a>
                </div>
            @endif

        </div>
    </section>

@endsection
