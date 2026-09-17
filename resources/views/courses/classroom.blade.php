@extends('layouts.app')

@section('title', $course->title . ' — Aula Virtual')

@section('content')

    {{-- ═══════════════════════════════════════════════
         Classroom Header — Navy, editorial
    ═══════════════════════════════════════════════ --}}
    <section class="bg-navy">
        <div class="max-w-editorial mx-auto px-6 lg:px-8 py-12 lg:py-16">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-[12px] text-gray-500 mb-8 font-medium">
                <a href="{{ url('/mis-cursos') }}" class="hover:text-gold transition-colors uppercase tracking-wider">Mis Cursos</a>
                <span class="text-gray-600">/</span>
                <span class="text-gray-400">{{ $course->title }}</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="gold-line"></div>
                        <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase">Aula Virtual</span>
                    </div>
                    <h1 class="font-display text-3xl lg:text-[40px] text-white leading-tight tracking-tight">{{ $course->title }}</h1>

                    @if ($course->teacher)
                        <div class="flex items-center gap-3 mt-5">
                            <div class="w-9 h-9 border border-gold/30 rounded-subtle flex items-center justify-center">
                                <span class="text-gold font-semibold text-sm">{{ substr($course->teacher->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">{{ $course->teacher->name }}</p>
                                <p class="text-gray-500 text-xs font-medium">Docente</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Quick stats --}}
                <div class="flex items-center gap-6 text-sm text-gray-400">
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-white">{{ $sessions->count() }}</span>
                        <span class="text-[11px] uppercase tracking-wider font-semibold">Sesiones</span>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-white">{{ $course->hours_intensity }}</span>
                        <span class="text-[11px] uppercase tracking-wider font-semibold">Horas</span>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div class="text-center">
                        @php
                            $statusLabel = $enrollment->status === 'completed' ? 'Completado' : 'Activo';
                            $statusColor = $enrollment->status === 'completed' ? 'text-gold' : 'text-green-400';
                        @endphp
                        <span class="block text-2xl font-bold {{ $statusColor }}">●</span>
                        <span class="text-[11px] uppercase tracking-wider font-semibold">{{ $statusLabel }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         Session Timeline
    ═══════════════════════════════════════════════ --}}
    <section class="bg-ivory py-14">
        <div class="max-w-editorial mx-auto px-6 lg:px-8">

            {{-- Flash messages --}}
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-subtle p-4 mb-8 text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Certificate Download Banner --}}
            @if ($enrollment->certificate)
                <div class="bg-white border border-gold/30 rounded-card p-5 mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gold/10 rounded-full flex items-center justify-center shrink-0">
                            <span class="text-xl">🎓</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-navy">Certificado Oficial Disponible</p>
                            <p class="text-xs text-gray-500">Código: <span class="font-mono font-semibold text-navy">{{ $enrollment->certificate->certificate_code }}</span></p>
                        </div>
                    </div>
                    <a href="{{ route('student.certificate.download', $course->slug) }}"
                       class="bg-navy text-white text-[11px] font-bold px-5 py-2.5 rounded-subtle tracking-wider uppercase hover:bg-navy-50 transition-colors whitespace-nowrap">
                        Descargar Certificado (PDF)
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Left column: Sessions --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="gold-line"></div>
                        <h2 class="text-[11px] text-gold font-bold tracking-[0.2em] uppercase">Cronograma de Sesiones</h2>
                    </div>

                    @forelse ($sessions as $index => $session)
                        @php
                            $isUpcoming = $session->isUpcoming();
                            $isPast     = $session->scheduled_at && $session->scheduled_at->isPast();
                            $isToday    = $session->scheduled_at && $session->scheduled_at->isToday();
                        @endphp

                        <div class="card-editorial p-6 {{ $isToday ? 'ring-2 ring-gold/40' : '' }}">
                            <div class="flex items-start justify-between gap-4">
                                {{-- Session number + title --}}
                                <div class="flex items-start gap-4">
                                    <div class="shrink-0 w-10 h-10 bg-navy rounded-subtle flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">{{ $index + 1 }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-display text-lg text-ink leading-snug">{{ $session->title }}</h3>

                                        @if ($session->scheduled_at)
                                            <p class="text-sm text-gray-400 font-medium mt-1">
                                                <svg class="w-3.5 h-3.5 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                {{ $session->scheduled_at->translatedFormat('l, d \d\e F — h:i A') }}
                                            </p>
                                        @endif

                                        @if ($session->description)
                                            <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ $session->description }}</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Status badge --}}
                                <div class="shrink-0">
                                    @if ($isToday)
                                        <span class="inline-flex items-center gap-1.5 bg-gold/10 text-gold text-[11px] font-bold px-3 py-1.5 rounded-subtle uppercase tracking-wider">
                                            <span class="w-1.5 h-1.5 bg-gold rounded-full animate-pulse"></span>
                                            Hoy
                                        </span>
                                    @elseif ($isUpcoming)
                                        <span class="inline-flex items-center gap-1.5 bg-navy/5 text-navy text-[11px] font-bold px-3 py-1.5 rounded-subtle uppercase tracking-wider">
                                            Próxima
                                        </span>
                                    @elseif ($isPast)
                                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-400 text-[11px] font-bold px-3 py-1.5 rounded-subtle uppercase tracking-wider">
                                            Finalizada
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Actions row: Meet link + Session materials --}}
                            <div class="mt-5 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-4">
                                @if ($session->hasMeetLink() && ($isUpcoming || $isToday))
                                    <a href="{{ $session->meet_url }}" target="_blank"
                                       class="inline-flex items-center gap-2 bg-navy text-white text-[12px] font-bold px-5 py-2.5 rounded-subtle uppercase tracking-wider hover:bg-navy-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        Unirse a la Clase
                                    </a>
                                @elseif ($session->hasMeetLink() && $isPast)
                                    <span class="inline-flex items-center gap-2 text-gray-400 text-[12px] font-bold uppercase tracking-wider">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Sesión finalizada
                                    </span>
                                @endif

                                {{-- Session-level materials --}}
                                @foreach ($session->materials as $material)
                                    <a href="{{ route('classroom.download', $material) }}"
                                       class="inline-flex items-center gap-1.5 text-[12px] font-bold text-gold uppercase tracking-wider hover:text-gold-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        {{ $material->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="card-editorial p-8 text-center">
                            <p class="text-gray-400 text-sm">El cronograma de sesiones será publicado próximamente.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Right column: General Materials --}}
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="gold-line"></div>
                        <h2 class="text-[11px] text-gold font-bold tracking-[0.2em] uppercase">Material de Estudio</h2>
                    </div>

                    @if ($generalMaterials->count())
                        <div class="space-y-3">
                            @foreach ($generalMaterials as $material)
                                <a href="{{ route('classroom.download', $material) }}"
                                   class="card-editorial flex items-center gap-4 p-4 group">
                                    {{-- File type icon --}}
                                    <div class="shrink-0 w-10 h-10 bg-ivory rounded-subtle flex items-center justify-center border border-gray-200/60">
                                        @php
                                            $icon = match(strtolower($material->file_type)) {
                                                'pdf'  => 'PDF',
                                                'doc', 'docx' => 'DOC',
                                                'ppt', 'pptx' => 'PPT',
                                                'xls', 'xlsx' => 'XLS',
                                                default => 'FILE',
                                            };
                                        @endphp
                                        <span class="text-[10px] font-black text-navy uppercase tracking-wider">{{ $icon }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-ink truncate group-hover:text-gold transition-colors">{{ $material->title }}</p>
                                        @if ($material->file_size_bytes)
                                            <p class="text-xs text-gray-400">{{ number_format($material->file_size_bytes / 1024, 0) }} KB</p>
                                        @endif
                                    </div>
                                    <svg class="w-4 h-4 text-gray-300 group-hover:text-gold transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="card-editorial p-6 text-center">
                            <p class="text-gray-400 text-sm">Aún no hay materiales disponibles.</p>
                        </div>
                    @endif

                    {{-- Course info summary --}}
                    <div class="mt-8 card-editorial p-6">
                        <h3 class="text-[11px] font-bold text-gold uppercase tracking-[0.15em] mb-4">Información</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-400">Modalidad</dt>
                                <dd class="font-semibold text-ink">En vivo</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-400">Sesiones</dt>
                                <dd class="font-semibold text-ink">{{ $sessions->count() }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-400">Intensidad</dt>
                                <dd class="font-semibold text-ink">{{ $course->hours_intensity }}h</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-400">Estado</dt>
                                <dd class="font-semibold {{ $enrollment->status === 'completed' ? 'text-gold' : 'text-green-600' }}">{{ ucfirst($statusLabel) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
