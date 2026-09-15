@extends('layouts.app')

@section('title', 'Formación Jurídica de Alto Nivel')
@section('meta_description', 'Formación continua en derecho inmobiliario y propiedad horizontal con certificación digital verificable. Cursos en vivo desde Santa Marta, Colombia.')

@section('content')

    {{-- ═══════════════════════════════════════════════
         HERO — Editorial, typographic, institutional
    ═══════════════════════════════════════════════ --}}
    <section class="bg-navy relative overflow-hidden">
        {{-- Subtle decorative element --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white/[0.02] rounded-full -translate-y-1/2 translate-x-1/3"></div>

        <div class="relative max-w-editorial mx-auto px-6 lg:px-8 py-24 lg:py-36">
            <div class="max-w-3xl">
                {{-- Eyebrow --}}
                <div class="flex items-center gap-3 mb-8">
                    <div class="gold-line"></div>
                    <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase">Inscripciones Abiertas</span>
                </div>

                {{-- Display Heading --}}
                <h1 class="font-display text-4xl sm:text-5xl lg:text-[64px] text-white leading-[1.1] mb-8 tracking-tight">
                    Formación Jurídica<br>
                    para la <em class="text-gold not-italic">Práctica Real</em>
                </h1>

                {{-- Subhead --}}
                <p class="text-lg lg:text-xl text-gray-400 leading-relaxed mb-10 max-w-2xl font-light">
                    Cursos especializados en derecho inmobiliario y propiedad horizontal.
                    Clases en vivo, material descargable y certificados digitales verificables.
                </p>

                {{-- CTAs --}}
                <div class="flex flex-wrap gap-4">
                    <a href="{{ url('/cursos') }}" class="btn-gold">
                        Ver Cursos Disponibles
                    </a>
                    <a href="{{ url('/verificar') }}" class="btn-outline !border-white/30 !text-white hover:!bg-white/10 hover:!border-white/50">
                        Verificar Certificado
                    </a>
                </div>
            </div>

            {{-- Value propositions --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mt-20 pt-12 border-t border-white/10">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 border border-gold/30 rounded-subtle flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-white text-sm font-semibold mb-1">Certificados Verificables</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Diplomas con código QR y verificación pública.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 border border-gold/30 rounded-subtle flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-white text-sm font-semibold mb-1">Clases en Vivo</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Formación en directo por Google Meet con docentes especializados.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 border border-gold/30 rounded-subtle flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h3 class="text-white text-sm font-semibold mb-1">Material Descargable</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Lecturas y presentaciones organizadas por sesión.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         COURSES — Editorial cards on Ivory surface
    ═══════════════════════════════════════════════ --}}
    <section class="bg-ivory py-24">
        <div class="max-w-editorial mx-auto px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="mb-16">
                <div class="flex items-center gap-3 mb-4">
                    <div class="gold-line"></div>
                    <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase">Programas Académicos</span>
                </div>
                <h2 class="font-display text-3xl lg:text-[42px] text-ink leading-tight tracking-tight">
                    Cursos Disponibles
                </h2>
            </div>

            {{-- Course Grid --}}
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
                            {{-- Status --}}
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
                            {{-- Meta row --}}
                            <div class="flex items-center gap-3 text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-3">
                                <span>{{ $course->hours_intensity }}h intensidad</span>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span>{{ $course->sessions->count() }} sesiones</span>
                            </div>

                            {{-- Title --}}
                            <h3 class="font-display text-lg text-ink leading-snug mb-3 group-hover:text-navy transition-colors">
                                {{ $course->title }}
                            </h3>

                            {{-- Description --}}
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 mb-5">{{ $course->short_description }}</p>

                            {{-- Teacher --}}
                            @if ($course->teacher)
                                <p class="text-[12px] text-gray-400 font-medium mb-5">
                                    Prof. {{ $course->teacher->name }}
                                </p>
                            @endif

                            {{-- Footer: Price + Link --}}
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

            {{-- View all CTA --}}
            @if ($courses->count() >= 6)
                <div class="text-center mt-12">
                    <a href="{{ url('/cursos') }}" class="btn-outline">Ver Todos los Cursos</a>
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         CTA — Asesoría, editorial composition
    ═══════════════════════════════════════════════ --}}
    <section class="bg-white py-24">
        <div class="max-w-editorial mx-auto px-6 lg:px-8">
            <div class="bg-navy rounded-card p-12 lg:p-20 relative overflow-hidden">
                {{-- Decorative gold line --}}
                <div class="absolute top-0 left-0 right-0 h-[2px] bg-gold"></div>

                <div class="max-w-2xl mx-auto text-center relative">
                    <span class="text-gold text-[11px] font-bold tracking-[0.2em] uppercase mb-6 block">Asesoría Jurídica</span>
                    <h2 class="font-display text-3xl lg:text-4xl text-white leading-tight mb-6">
                        ¿Necesitas orientación<br>personalizada?
                    </h2>
                    <p class="text-gray-400 leading-relaxed mb-10">
                        Nuestro equipo de abogados especializados puede ayudarte con consultas en propiedad horizontal, derecho inmobiliario y más.
                    </p>
                    <a href="https://wa.me/573001234567?text=Hola%2C%20necesito%20asesoría%20jurídica" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#1fb855] text-white font-semibold text-sm px-8 py-3 rounded-subtle transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        Hablar con un Abogado
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
