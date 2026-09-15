@extends('layouts.app')

@section('title', 'Catálogo de Cursos')
@section('meta_description', 'Explora nuestros cursos especializados en derecho inmobiliario y propiedad horizontal. Clases en vivo, certificación digital, desde Colombia.')

@section('content')

    {{-- Page Header --}}
    <section class="bg-white border-b border-gray-200/60">
        <div class="max-w-editorial mx-auto px-6 lg:px-8 py-16">
            <div class="flex items-center gap-3 mb-4">
                <div class="gold-line"></div>
                <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase">Programas Académicos</span>
            </div>
            <h1 class="font-display text-3xl lg:text-[42px] text-ink leading-tight tracking-tight mb-3">Catálogo de Cursos</h1>
            <p class="text-gray-400 text-base max-w-xl">Formación jurídica especializada con certificación digital verificable.</p>
        </div>
    </section>

    {{-- Course Grid --}}
    <section class="bg-ivory py-16">
        <div class="max-w-editorial mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($courses as $course)
                    <a href="{{ route('courses.show', $course->slug) }}" class="card-editorial group block overflow-hidden">
                        {{-- Cover --}}
                        <div class="h-48 bg-navy relative overflow-hidden">
                            @if ($course->cover_image_path)
                                <img src="{{ Storage::url($course->cover_image_path) }}" alt="{{ $course->title }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                @if ($course->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 bg-white/95 text-ink text-[11px] font-bold px-3 py-1 rounded-subtle uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        Disponible
                                    </span>
                                @elseif ($course->status === 'in_progress')
                                    <span class="inline-flex items-center gap-1.5 bg-gold text-white text-[11px] font-bold px-3 py-1 rounded-subtle uppercase tracking-wider">
                                        En Curso
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-6">
                            <div class="flex items-center gap-3 text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-3">
                                <span>{{ $course->hours_intensity }}h intensidad</span>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span>{{ $course->sessions->count() }} sesiones</span>
                            </div>

                            <h3 class="font-display text-lg text-ink leading-snug mb-3 group-hover:text-navy transition-colors">
                                {{ $course->title }}
                            </h3>
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 mb-5">{{ $course->short_description }}</p>

                            @if ($course->teacher)
                                <p class="text-[12px] text-gray-400 font-medium mb-5">
                                    Prof. {{ $course->teacher->name }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between pt-5 border-t border-gray-200/80">
                                <div>
                                    <span class="text-xl font-bold text-ink">${{ number_format($course->price_cop, 0, ',', '.') }}</span>
                                    <span class="text-[11px] text-gray-400 ml-1 font-medium">COP</span>
                                </div>
                                <span class="text-[12px] font-bold text-gold uppercase tracking-wider group-hover:text-gold-600 transition-colors flex items-center gap-1">
                                    Ver programa
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="gold-line mx-auto mb-6"></div>
                        <h3 class="font-display text-2xl text-ink mb-2">Próximamente</h3>
                        <p class="text-gray-400 text-sm">Estamos preparando nuevos programas académicos.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection
