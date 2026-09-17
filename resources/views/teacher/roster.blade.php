@extends('layouts.app')

@section('title', 'Lista de Asistencia — ' . $course->title)

@section('content')

    {{-- ═══════════════════════════════════════════════
         Header — Navy
    ═══════════════════════════════════════════════ --}}
    <section class="bg-navy">
        <div class="max-w-editorial mx-auto px-6 lg:px-8 py-12 lg:py-16">
            <nav class="flex items-center gap-2 text-[12px] text-gray-500 mb-8 font-medium">
                <a href="{{ url('/mis-cursos') }}" class="hover:text-gold transition-colors uppercase tracking-wider">Mis Cursos</a>
                <span class="text-gray-600">/</span>
                <span class="text-gray-400">Control de Sala</span>
            </nav>

            <div class="flex items-center gap-3 mb-4">
                <div class="gold-line"></div>
                <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase">Panel Docente</span>
            </div>
            <h1 class="font-display text-3xl lg:text-[40px] text-white leading-tight tracking-tight">{{ $course->title }}</h1>
            <p class="text-gray-400 text-sm mt-3 font-medium">
                {{ $enrolledStudents->count() }} {{ $enrolledStudents->count() === 1 ? 'alumno matriculado' : 'alumnos matriculados' }}
            </p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         Student Roster Table
    ═══════════════════════════════════════════════ --}}
    <section class="bg-ivory py-14">
        <div class="max-w-editorial mx-auto px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-subtle p-4 mb-8 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Main: Roster --}}
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="gold-line"></div>
                        <h2 class="text-[11px] text-gold font-bold tracking-[0.2em] uppercase">Verificación de Asistentes</h2>
                    </div>

                    @if ($enrolledStudents->count())
                        {{-- Search filter (Alpine) --}}
                        <div x-data="{ search: '' }" class="mb-6">
                            <div class="relative">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input
                                    x-model="search"
                                    type="text"
                                    placeholder="Buscar por nombre o documento..."
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200/60 rounded-subtle text-sm text-ink placeholder-gray-400 focus:outline-none focus:border-gold/60 focus:ring-1 focus:ring-gold/30 transition-colors"
                                >
                            </div>

                            {{-- Table --}}
                            <div class="mt-4 card-editorial overflow-hidden">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="bg-navy text-white">
                                            <th class="px-5 py-3.5 text-[11px] font-bold uppercase tracking-wider">#</th>
                                            <th class="px-5 py-3.5 text-[11px] font-bold uppercase tracking-wider">Nombre</th>
                                            <th class="px-5 py-3.5 text-[11px] font-bold uppercase tracking-wider">Documento</th>
                                            <th class="px-5 py-3.5 text-[11px] font-bold uppercase tracking-wider hidden sm:table-cell">Correo</th>
                                            <th class="px-5 py-3.5 text-[11px] font-bold uppercase tracking-wider hidden md:table-cell">Celular</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($enrolledStudents as $index => $student)
                                            <tr
                                                x-show="search === '' || '{{ strtolower($student->name . ' ' . $student->document_number) }}'.includes(search.toLowerCase())"
                                                class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-ivory-50' }} border-b border-gray-100 last:border-0"
                                            >
                                                <td class="px-5 py-3.5 text-sm text-gray-400 font-medium">{{ $index + 1 }}</td>
                                                <td class="px-5 py-3.5">
                                                    <p class="text-sm font-semibold text-ink">{{ $student->name }}</p>
                                                </td>
                                                <td class="px-5 py-3.5">
                                                    <div>
                                                        <span class="text-[10px] font-bold text-gold uppercase tracking-wider">{{ $student->document_type ?? 'C.C.' }}</span>
                                                        <p class="text-sm font-semibold text-ink tabular-nums">{{ $student->document_number ?? '—' }}</p>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-3.5 text-sm text-gray-500 hidden sm:table-cell">{{ $student->email }}</td>
                                                <td class="px-5 py-3.5 text-sm text-gray-500 hidden md:table-cell">{{ $student->phone_whatsapp ?? '—' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="card-editorial p-8 text-center">
                            <p class="text-gray-400 text-sm">Aún no hay alumnos matriculados en este curso.</p>
                        </div>
                    @endif
                </div>

                {{-- Right: Upload Material + Sessions --}}
                <div>
                    {{-- Upload Material --}}
                    <div class="flex items-center gap-3 mb-6">
                        <div class="gold-line"></div>
                        <h2 class="text-[11px] text-gold font-bold tracking-[0.2em] uppercase">Subir Material</h2>
                    </div>

                    <div class="card-editorial p-6 mb-8">
                        <form action="{{ route('teacher.upload-material', $course->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label for="title" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Título del archivo</label>
                                <input type="text" name="title" id="title" required
                                       class="w-full px-4 py-2.5 bg-ivory border border-gray-200/60 rounded-subtle text-sm text-ink placeholder-gray-400 focus:outline-none focus:border-gold/60 focus:ring-1 focus:ring-gold/30 transition-colors"
                                       placeholder="Ej: Guía de estudio Módulo 1">
                            </div>
                            <div>
                                <label for="course_session_id" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Sesión (opcional)</label>
                                <select name="course_session_id" id="course_session_id"
                                        class="w-full px-4 py-2.5 bg-ivory border border-gray-200/60 rounded-subtle text-sm text-ink focus:outline-none focus:border-gold/60 focus:ring-1 focus:ring-gold/30 transition-colors">
                                    <option value="">General (todo el curso)</option>
                                    @foreach ($course->sessions as $session)
                                        <option value="{{ $session->id }}">{{ $session->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="file" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Archivo</label>
                                <input type="file" name="file" id="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-subtle file:border-0 file:text-[12px] file:font-bold file:uppercase file:tracking-wider file:bg-navy file:text-white hover:file:bg-navy-50 file:cursor-pointer file:transition-colors">
                                <p class="text-[11px] text-gray-400 mt-1.5">PDF, DOC, PPT, XLS o ZIP. Máx 20 MB.</p>
                            </div>

                            @if ($errors->any())
                                <div class="bg-red-50 border border-red-200 text-red-700 rounded-subtle p-3 text-xs">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <button type="submit" class="btn-navy w-full text-center">
                                Subir Material
                            </button>
                        </form>
                    </div>

                    {{-- Upcoming sessions --}}
                    <div class="flex items-center gap-3 mb-4">
                        <div class="gold-line"></div>
                        <h2 class="text-[11px] text-gold font-bold tracking-[0.2em] uppercase">Próximas Sesiones</h2>
                    </div>

                    @php
                        $upcomingSessions = $course->sessions->filter(fn($s) => $s->isUpcoming())->take(3);
                    @endphp

                    @if ($upcomingSessions->count())
                        <div class="space-y-3">
                            @foreach ($upcomingSessions as $session)
                                <div class="card-editorial p-4">
                                    <p class="text-sm font-semibold text-ink">{{ $session->title }}</p>
                                    @if ($session->scheduled_at)
                                        <p class="text-xs text-gray-400 mt-1">{{ $session->scheduled_at->translatedFormat('l, d \d\e F — h:i A') }}</p>
                                    @endif
                                    @if ($session->hasMeetLink())
                                        <a href="{{ $session->meet_url }}" target="_blank" class="inline-flex items-center gap-1.5 mt-2 text-[11px] font-bold text-gold uppercase tracking-wider hover:text-gold-600 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            Abrir Sala
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="card-editorial p-4 text-center">
                            <p class="text-gray-400 text-xs">No hay sesiones próximas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
