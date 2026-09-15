@extends('layouts.app')

@section('title', $course->title)
@section('meta_description', $course->short_description)

@section('content')

    {{-- ═══════════════════════════════════════════════
         Course Header — Navy background, editorial
    ═══════════════════════════════════════════════ --}}
    <section class="bg-navy">
        <div class="max-w-editorial mx-auto px-6 lg:px-8 py-16 lg:py-20">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-[12px] text-gray-500 mb-8 font-medium">
                <a href="{{ url('/cursos') }}" class="hover:text-gold transition-colors uppercase tracking-wider">Cursos</a>
                <span class="text-gray-600">/</span>
                <span class="text-gray-400">{{ $course->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Left: Course info --}}
                <div class="lg:col-span-2">
                    {{-- Status + Meta --}}
                    <div class="flex items-center gap-4 mb-6">
                        @if ($course->status === 'published')
                            <span class="inline-flex items-center gap-1.5 bg-white/10 text-white text-[11px] font-bold px-3 py-1.5 rounded-subtle uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                                Inscripciones Abiertas
                            </span>
                        @endif
                        <span class="text-gray-500 text-sm font-medium">{{ $course->hours_intensity }} horas</span>
                    </div>

                    {{-- Title --}}
                    <h1 class="font-display text-3xl lg:text-[44px] text-white leading-[1.15] tracking-tight mb-6">{{ $course->title }}</h1>

                    {{-- Description --}}
                    <p class="text-lg text-gray-400 leading-relaxed mb-8 max-w-2xl font-light">{{ $course->short_description }}</p>

                    {{-- Teacher --}}
                    @if ($course->teacher)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 border border-gold/30 rounded-subtle flex items-center justify-center">
                                <span class="text-gold font-semibold text-sm">{{ substr($course->teacher->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">{{ $course->teacher->name }}</p>
                                <p class="text-gray-500 text-xs font-medium">Docente</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right: Enrollment Card --}}
                <div class="bg-white rounded-card p-8 self-start">
                    {{-- Price --}}
                    <div class="mb-6 pb-6 border-b border-gray-200/80">
                        <span class="text-3xl font-bold text-ink">${{ number_format($course->price_cop, 0, ',', '.') }}</span>
                        <span class="text-gray-400 text-sm ml-1 font-medium">COP</span>
                    </div>

                    {{-- Course features --}}
                    <div class="space-y-4 mb-8 text-sm text-gray-600">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $course->hours_intensity }} horas de intensidad</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span>{{ $course->sessions->count() }} sesiones en vivo (Google Meet)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            <span>Certificado digital verificable</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Material de estudio descargable</span>
                        </div>
                        @if ($course->starts_at)
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Inicia {{ $course->starts_at->translatedFormat('d \\d\\e F, Y') }}</span>
                            </div>
                        @endif
                        @if ($course->max_capacity)
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $course->activeEnrollmentsCount() }} / {{ $course->max_capacity }} cupos</span>
                            </div>
                        @endif
                    </div>

                    {{-- CTA --}}
                    @auth
                        @if ($isEnrolled)
                            <div class="bg-ivory border border-gold/30 rounded-subtle p-4 text-center">
                                <p class="text-ink font-semibold text-sm">✓ Ya estás inscrito en este curso</p>
                            </div>
                        @elseif (!$course->hasCapacity())
                            <div class="bg-ivory border border-gray-300 rounded-subtle p-4 text-center">
                                <p class="text-gray-500 font-semibold text-sm">Cupos agotados</p>
                            </div>
                        @else
                            <form action="{{ route('checkout.initiate', $course) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-navy w-full text-center !py-3.5 !text-base">
                                    Inscribirme Ahora
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('register', ['course' => $course->slug]) }}" class="btn-navy block w-full text-center !py-3.5 !text-base">
                            Registrarme e Inscribirme
                        </a>
                        <p class="text-xs text-gray-400 text-center mt-4 font-medium">
                            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-gold hover:underline">Ingresar</a>
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         Course Content — Syllabus + Sessions + Sidebar
    ═══════════════════════════════════════════════ --}}
    <section class="bg-ivory py-16">
        <div class="max-w-editorial mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Left: Content --}}
                <div class="lg:col-span-2 space-y-12">

                    {{-- Syllabus --}}
                    @if ($course->syllabus)
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="gold-line"></div>
                                <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase">Plan de Estudios</span>
                            </div>
                            <h2 class="font-display text-2xl text-ink mb-6">Contenido del Curso</h2>
                            <div class="prose prose-sm max-w-none text-gray-600 prose-headings:font-sans prose-headings:text-ink prose-a:text-gold">
                                {!! Str::markdown($course->syllabus) !!}
                            </div>
                        </div>
                    @endif

                    {{-- Sessions Schedule --}}
                    @if ($course->sessions->count())
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="gold-line"></div>
                                <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase">Cronograma</span>
                            </div>
                            <h2 class="font-display text-2xl text-ink mb-6">Calendario de Sesiones</h2>
                            <div class="space-y-3">
                                @foreach ($course->sessions as $session)
                                    <div class="card-editorial p-5 flex items-start gap-5">
                                        {{-- Date block --}}
                                        <div class="bg-navy rounded-subtle p-3 text-center min-w-[60px]">
                                            @if ($session->scheduled_at)
                                                <p class="text-[10px] text-gold font-bold uppercase tracking-wider">{{ $session->scheduled_at->translatedFormat('M') }}</p>
                                                <p class="text-xl font-bold text-white leading-none mt-0.5">{{ $session->scheduled_at->format('d') }}</p>
                                            @else
                                                <p class="text-[11px] text-gray-400 font-medium">TBD</p>
                                            @endif
                                        </div>
                                        {{-- Session info --}}
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-ink text-sm mb-1">{{ $session->title }}</h4>
                                            @if ($session->description)
                                                <p class="text-xs text-gray-500 leading-relaxed">{{ $session->description }}</p>
                                            @endif
                                            @if ($session->scheduled_at)
                                                <p class="text-[11px] text-gray-400 mt-2 font-medium">
                                                    {{ $session->scheduled_at->translatedFormat('l, d \\d\\e F — h:i A') }} (Hora Colombia)
                                                </p>
                                            @endif
                                        </div>
                                        @if ($session->isUpcoming())
                                            <span class="bg-ivory border border-gold/30 text-gold text-[11px] font-bold px-3 py-1 rounded-subtle uppercase tracking-wider shrink-0">Próxima</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right: Sidebar --}}
                <div class="space-y-8">
                    {{-- Teacher card --}}
                    @if ($course->teacher)
                        <div class="card-editorial p-6">
                            <h3 class="text-[11px] font-bold text-gold/80 mb-5 uppercase tracking-[0.15em]">Docente</h3>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-navy rounded-subtle flex items-center justify-center">
                                    <span class="text-gold font-bold text-lg">{{ substr($course->teacher->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-ink text-sm">{{ $course->teacher->name }}</p>
                                    <p class="text-xs text-gray-400 font-medium">{{ $course->teacher->city ?? 'Colombia' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Payment methods --}}
                    <div class="card-editorial p-6">
                        <h3 class="text-[11px] font-bold text-gold/80 mb-5 uppercase tracking-[0.15em]">Medios de Pago</h3>
                        <div class="space-y-3 text-sm text-gray-500">
                            <p class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
                                PSE (Débito bancario)
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
                                Nequi
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
                                Tarjeta de Crédito/Débito
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-gold rounded-full"></span>
                                Bancolombia
                            </p>
                        </div>
                    </div>

                    {{-- WhatsApp help --}}
                    <div class="card-editorial p-6 text-center">
                        <p class="text-sm text-gray-500 mb-4">¿Tienes dudas sobre este curso?</p>
                        <a href="https://wa.me/573001234567?text=Hola%2C%20quiero%20información%20sobre%20el%20curso%20{{ urlencode($course->title) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-[#25D366] hover:text-[#1fb855] transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                            Consultar por WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
