@extends('layouts.app')

@section('title', 'Verificar Certificado')
@section('meta_description', 'Verifica la autenticidad de un certificado emitido por SJI Colombia introduciendo el código único.')

@section('content')

    {{-- Page Header --}}
    <section class="bg-white border-b border-gray-200/60">
        <div class="max-w-editorial mx-auto px-6 lg:px-8 py-16">
            <div class="flex items-center gap-3 mb-4">
                <div class="gold-line"></div>
                <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase">Validación</span>
            </div>
            <h1 class="font-display text-3xl lg:text-[42px] text-ink leading-tight tracking-tight mb-3">Verificar Certificado</h1>
            <p class="text-gray-400 text-base max-w-xl">Introduce el código del certificado para validar su autenticidad.</p>
        </div>
    </section>

    <section class="bg-ivory py-16">
        <div class="max-w-lg mx-auto px-6">
            <div class="card-editorial p-8">
                {{-- Search form --}}
                <form action="{{ url('/verificar') }}" method="GET" class="flex gap-3 mb-8">
                    <input type="text" name="code" value="{{ $code ?? '' }}" placeholder="Ej: SJI-2026-A8K9Z" required
                        class="flex-1 px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all uppercase tracking-wider font-mono bg-white">
                    <button type="submit" class="btn-navy shrink-0 !px-6">
                        Verificar
                    </button>
                </form>

                @isset($code)
                    @if ($certificate ?? null)
                        <div class="bg-ivory border border-gold/30 rounded-subtle p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 bg-gold/10 border border-gold/30 rounded-subtle flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-ink text-sm">Certificado Válido</p>
                                    <p class="text-[11px] text-gold font-bold uppercase tracking-wider">Emitido por SJI Colombia</p>
                                </div>
                            </div>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200/50">
                                    <span class="text-gray-500 font-medium">Nombre</span>
                                    <span class="font-semibold text-ink">{{ $certificate->user->name }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200/50">
                                    <span class="text-gray-500 font-medium">Curso</span>
                                    <span class="font-semibold text-ink">{{ $certificate->course->title }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200/50">
                                    <span class="text-gray-500 font-medium">Código</span>
                                    <span class="font-mono font-semibold text-ink">{{ $certificate->certificate_code }}</span>
                                </div>
                                @if ($certificate->issued_at)
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-500 font-medium">Fecha de emisión</span>
                                        <span class="font-semibold text-ink">{{ $certificate->issued_at->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-subtle p-6 text-center">
                            <div class="w-10 h-10 bg-red-100 rounded-subtle flex items-center justify-center mx-auto mb-3">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <p class="font-semibold text-red-800 text-sm">Certificado no encontrado</p>
                            <p class="text-xs text-red-600 mt-1">El código "{{ $code }}" no corresponde a ningún certificado registrado.</p>
                        </div>
                    @endif
                @endisset
            </div>
        </div>
    </section>

@endsection
