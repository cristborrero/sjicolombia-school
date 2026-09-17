@extends('layouts.app')

@section('title', 'Mis Cursos')

@section('content')

    {{-- Page Header --}}
    <section class="bg-white border-b border-gray-200/60">
        <div class="max-w-editorial mx-auto px-6 lg:px-8 py-16">
            <div class="flex items-center gap-3 mb-4">
                <div class="gold-line"></div>
                <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase">Mi Panel</span>
            </div>
            <h1 class="font-display text-3xl lg:text-[42px] text-ink leading-tight tracking-tight">Mis Cursos</h1>
        </div>
    </section>

    {{-- Content --}}
    <section class="bg-ivory py-16">
        <div class="max-w-editorial mx-auto px-6 lg:px-8">
            @php
                $enrollments = auth()->user()->enrollments()->with(['course.sessions', 'certificate'])->whereIn('status', ['active', 'completed'])->get();
            @endphp

            @if ($enrollments->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($enrollments as $enrollment)
                        <div class="card-editorial overflow-hidden">
                            {{-- Cover --}}
                            <div class="h-36 bg-navy flex items-center justify-center relative">
                                @if ($enrollment->course->cover_image_path)
                                    <img src="{{ Storage::url($enrollment->course->cover_image_path) }}" alt="{{ $enrollment->course->title }}" class="w-full h-full object-cover opacity-60">
                                @else
                                    <svg class="w-10 h-10 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                @endif
                                {{-- Status badge --}}
                                <div class="absolute top-4 left-4 flex items-center gap-2">
                                    @if ($enrollment->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 bg-white/95 text-ink text-[11px] font-bold px-3 py-1 rounded-subtle uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                            Activo
                                        </span>
                                    @elseif ($enrollment->status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 bg-gold text-white text-[11px] font-bold px-3 py-1 rounded-subtle uppercase tracking-wider">
                                            Completado
                                        </span>
                                    @endif

                                    @if ($enrollment->certificate)
                                        <span class="inline-flex items-center gap-1 bg-navy text-gold text-[10px] font-bold px-2.5 py-1 rounded-subtle uppercase tracking-wider">
                                            🎓 Certificado
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="font-display text-lg text-ink leading-snug mb-4">{{ $enrollment->course->title }}</h3>

                                @php
                                    $nextSession = $enrollment->course->sessions->filter(fn($s) => $s->scheduled_at && $s->scheduled_at->isFuture())->first();
                                @endphp

                                @if ($nextSession)
                                    <div class="bg-ivory border border-gold/20 rounded-subtle p-4 mb-5">
                                        <p class="text-[11px] text-gold font-bold uppercase tracking-wider mb-1">Próxima sesión</p>
                                        <p class="text-sm font-semibold text-ink mb-0.5">{{ $nextSession->title }}</p>
                                        <p class="text-xs text-gray-400 font-medium">{{ $nextSession->scheduled_at->translatedFormat('l, d \\d\\e F — h:i A') }}</p>
                                        @if ($nextSession->hasMeetLink())
                                            <a href="{{ $nextSession->meet_url }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-[12px] font-bold text-[#25D366] hover:text-[#1fb855] uppercase tracking-wider transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                Unirse a la clase
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex items-center gap-4 flex-wrap">
                                    <a href="{{ route('classroom.show', $enrollment->course->slug) }}" class="text-[12px] font-bold text-gold uppercase tracking-wider hover:text-gold-600 transition-colors flex items-center gap-1">
                                        Entrar al Aula
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                    @if ($enrollment->certificate)
                                        <a href="{{ route('student.certificate.download', $enrollment->course->slug) }}" class="text-[12px] font-bold text-navy hover:text-gold transition-colors flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            Certificado
                                        </a>
                                    @endif
                                    @if (auth()->user()->isTeacher() || auth()->user()->isAdmin())
                                        <a href="{{ route('teacher.roster', $enrollment->course->slug) }}" class="text-[12px] font-bold text-navy/60 uppercase tracking-wider hover:text-navy transition-colors">
                                            Asistencia
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <div class="gold-line mx-auto mb-6"></div>
                    <h3 class="font-display text-2xl text-ink mb-2">Aún no tienes cursos</h3>
                    <p class="text-gray-400 text-sm mb-8">Explora nuestro catálogo y empieza tu formación jurídica.</p>
                    <a href="{{ url('/cursos') }}" class="btn-navy">Ver Cursos Disponibles</a>
                </div>
            @endif
        </div>
    </section>

@endsection
