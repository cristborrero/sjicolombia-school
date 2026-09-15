<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SJI Escuela Jurídica') — Formación Jurídica de Alto Nivel</title>
    <meta name="description" content="@yield('meta_description', 'Formación continua en derecho inmobiliario y propiedad horizontal. Cursos en vivo con certificación digital verificable.')">

    {{-- Favicon Oficial --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Tipografías del Design System --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Playfair Display', 'Georgia', 'serif'],
                        sans: ['Montserrat', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            DEFAULT: '#0B1726',
                            50: '#1a2d45',
                            100: '#152438',
                            200: '#0f1c2e',
                            300: '#0B1726',
                            400: '#08101b',
                            500: '#050b12',
                        },
                        gold: {
                            DEFAULT: '#B99A5B',
                            50: '#f7f1e4',
                            100: '#ede0c4',
                            200: '#dcc89e',
                            300: '#ccb17a',
                            400: '#B99A5B',
                            500: '#a6884c',
                            600: '#8d733f',
                            700: '#735e33',
                        },
                        ivory: {
                            DEFAULT: '#F5F2EA',
                            50: '#faf9f5',
                            100: '#F5F2EA',
                            200: '#ece7d9',
                            300: '#e0d9c8',
                        },
                        ink: '#111111',
                    },
                    spacing: {
                        '18': '4.5rem',
                        '22': '5.5rem',
                        '30': '7.5rem',
                    },
                    maxWidth: {
                        'editorial': '1280px',
                    },
                    borderRadius: {
                        'subtle': '4px',
                        'card': '6px',
                    },
                },
            },
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }

        /* ── Design Tokens: CSS Custom Properties ── */
        :root {
            --navy: #0B1726;
            --gold: #B99A5B;
            --ivory: #F5F2EA;
            --ink: #111111;
            --white: #FFFFFF;

            --transition-fast: 180ms ease;
            --transition-base: 250ms ease;
            --transition-slow: 400ms ease;
        }

        /* ── Typography Overrides ── */
        .font-display { font-family: 'Playfair Display', Georgia, serif; }

        /* ── Button System ── */
        .btn-navy {
            background-color: var(--navy);
            color: var(--white);
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 0.875rem;
            letter-spacing: 0.03em;
            padding: 0.75rem 2rem;
            border-radius: 4px;
            transition: background-color var(--transition-fast), transform var(--transition-fast);
        }
        .btn-navy:hover {
            background-color: #152438;
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--navy);
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 0.875rem;
            letter-spacing: 0.03em;
            padding: 0.75rem 2rem;
            border: 1.5px solid var(--navy);
            border-radius: 4px;
            transition: all var(--transition-fast);
        }
        .btn-outline:hover {
            background-color: var(--navy);
            color: var(--white);
        }

        .btn-gold {
            background-color: var(--gold);
            color: var(--white);
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 0.875rem;
            letter-spacing: 0.03em;
            padding: 0.75rem 2rem;
            border-radius: 4px;
            transition: background-color var(--transition-fast), transform var(--transition-fast);
        }
        .btn-gold:hover {
            background-color: #a6884c;
            transform: translateY(-1px);
        }

        /* ── Gold Accent Line ── */
        .gold-line {
            width: 48px;
            height: 2px;
            background-color: var(--gold);
        }

        /* ── Card System ── */
        .card-editorial {
            background: var(--white);
            border: 1px solid #e8e5dd;
            border-radius: 6px;
            transition: border-color var(--transition-base), transform var(--transition-base);
        }
        .card-editorial:hover {
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        /* ── WhatsApp Button ── */
        .whatsapp-float {
            animation: wa-pulse 2.5s infinite;
        }
        @keyframes wa-pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(37, 211, 102, 0); }
        }

        /* ── Subtle reveal animation ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up {
            animation: fadeUp 0.5s var(--transition-base) both;
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-ivory text-ink">

    {{-- ═══════════════════════════════════════════════
         HEADER — Institutional, clean, editorial
    ═══════════════════════════════════════════════ --}}
    <header class="bg-white border-b border-gray-200/60 sticky top-0 z-40" x-data="{ mobileOpen: false }">
        <div class="max-w-editorial mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-[80px]">

                {{-- Logo / Brand --}}
                <a href="{{ url('/') }}" class="flex items-center group py-2">
                    <img src="{{ asset('images/logos/logo-sji-school-dark.svg') }}" alt="SJI Escuela Jurídica" class="h-12 md:h-[52px] w-auto transition-transform duration-200 group-hover:opacity-95">
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ url('/cursos') }}" class="text-[13px] font-semibold text-gray-600 hover:text-ink tracking-wide uppercase px-4 py-2 transition-colors duration-200">
                        Cursos
                    </a>
                    <a href="{{ url('/verificar') }}" class="text-[13px] font-semibold text-gray-600 hover:text-ink tracking-wide uppercase px-4 py-2 transition-colors duration-200">
                        Verificar Certificado
                    </a>
                    @auth
                        <a href="{{ url('/mis-cursos') }}" class="text-[13px] font-semibold text-gray-600 hover:text-ink tracking-wide uppercase px-4 py-2 transition-colors duration-200">
                            Mis Cursos
                        </a>
                    @endauth
                </nav>

                {{-- Right side: Auth + CTA --}}
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <span class="text-[13px] text-gray-500 font-medium">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-[13px] text-gray-400 hover:text-ink font-medium transition-colors">
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-[13px] font-semibold text-gray-600 hover:text-ink tracking-wide uppercase transition-colors">
                            Ingresar
                        </a>
                        <a href="{{ route('register') }}" class="btn-navy text-xs !py-2.5 !px-5">
                            Inscribirme
                        </a>
                    @endauth
                </div>

                {{-- Mobile menu button --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-gray-500 hover:text-ink" aria-label="Menú">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation Panel --}}
        <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden bg-white border-t border-gray-100 px-6 py-6 space-y-4">
            <a href="{{ url('/cursos') }}" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">Cursos</a>
            <a href="{{ url('/verificar') }}" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">Verificar Certificado</a>
            @auth
                <a href="{{ url('/mis-cursos') }}" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">Mis Cursos</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block text-sm text-gray-400 font-medium">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">Ingresar</a>
                <a href="{{ route('register') }}" class="btn-navy inline-block text-center w-full !text-sm">Inscribirme</a>
            @endauth
        </div>
    </header>

    {{-- ═══════════════════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════════════════ --}}
    <main>
        @yield('content')
    </main>

    {{-- ═══════════════════════════════════════════════
         FOOTER — Navy background, Gold accents
    ═══════════════════════════════════════════════ --}}
    <footer class="bg-navy text-gray-400 mt-0">
        {{-- Gold accent line at top --}}
        <div class="h-[2px] bg-gold"></div>

        <div class="max-w-editorial mx-auto px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                {{-- Brand column --}}
                <div>
                    <div class="mb-6">
                        <a href="{{ url('/') }}" class="inline-block">
                            <img src="{{ asset('images/logos/logo-sji-school-light.svg') }}" alt="SJI Escuela Jurídica" class="h-16 md:h-[72px] w-auto transition-transform duration-200 hover:opacity-95">
                        </a>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-500 max-w-xs">
                        Soluciones Jurídicas e Inmobiliarias de Colombia S.A.S. Formación continua en derecho inmobiliario y propiedad horizontal.
                    </p>
                </div>

                {{-- Platform links --}}
                <div>
                    <h4 class="text-[11px] font-bold text-gold/80 mb-5 uppercase tracking-[0.15em]">Plataforma</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ url('/cursos') }}" class="text-gray-400 hover:text-white transition-colors duration-200">Catálogo de Cursos</a></li>
                        <li><a href="{{ url('/verificar') }}" class="text-gray-400 hover:text-white transition-colors duration-200">Verificar Certificado</a></li>
                        @auth
                            <li><a href="{{ url('/mis-cursos') }}" class="text-gray-400 hover:text-white transition-colors duration-200">Mis Cursos</a></li>
                        @endauth
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-[11px] font-bold text-gold/80 mb-5 uppercase tracking-[0.15em]">Contacto</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="text-gray-500">Santa Marta, Colombia</li>
                        <li>
                            <a href="https://wa.me/573001234567" target="_blank" class="text-gray-400 hover:text-green-400 transition-colors duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                                WhatsApp: +57 300 123 4567
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-600">&copy; {{ date('Y') }} SJI Colombia. Todos los derechos reservados.</p>
                <p class="text-xs text-gray-600">Formación jurídica para la práctica real.</p>
            </div>
        </div>
    </footer>

    {{-- ═══════════════════════════════════════════════
         WhatsApp Floating Button
    ═══════════════════════════════════════════════ --}}
    <a href="https://wa.me/573001234567?text=Hola%2C%20quiero%20información%20sobre%20los%20cursos%20de%20SJI%20Colombia"
       target="_blank"
       class="whatsapp-float fixed bottom-6 right-6 z-50 w-14 h-14 bg-[#25D366] hover:bg-[#1fb855] rounded-full flex items-center justify-center shadow-lg transition-colors duration-200"
       aria-label="Contactar por WhatsApp">
        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>

    @stack('scripts')
</body>
</html>
