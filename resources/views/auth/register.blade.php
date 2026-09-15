@extends('layouts.app')

@section('title', 'Crear Cuenta')

@section('content')
<section class="bg-ivory min-h-[70vh] flex items-center justify-center py-16">
    <div class="w-full max-w-lg px-6">
        <div class="card-editorial p-8 lg:p-10">
            {{-- Brand --}}
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-block mb-5">
                    <img src="{{ asset('images/logos/logo-sji-school-dark.svg') }}" alt="SJI Escuela Jurídica" class="h-14 w-auto mx-auto">
                </a>
                <h1 class="font-display text-2xl text-ink mb-1">Crear Cuenta</h1>
                <p class="text-gray-400 text-sm">Regístrate para acceder a nuestros cursos jurídicos</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-subtle p-4 mb-6">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                @if (request('course'))
                    <input type="hidden" name="course" value="{{ request('course') }}">
                @endif

                <div>
                    <label for="name" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nombre Completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                </div>

                <div>
                    <label for="email" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Correo Electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="document_type" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Tipo de Documento</label>
                        <select id="document_type" name="document_type" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                            <option value="">Seleccionar</option>
                            <option value="CC" {{ old('document_type') === 'CC' ? 'selected' : '' }}>C.C.</option>
                            <option value="CE" {{ old('document_type') === 'CE' ? 'selected' : '' }}>C.E.</option>
                            <option value="PASAPORTE" {{ old('document_type') === 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="NIT" {{ old('document_type') === 'NIT' ? 'selected' : '' }}>NIT</option>
                        </select>
                    </div>
                    <div>
                        <label for="document_number" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nº Documento</label>
                        <input id="document_number" type="text" name="document_number" value="{{ old('document_number') }}" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                    </div>
                </div>

                <div>
                    <label for="phone_whatsapp" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">WhatsApp</label>
                    <input id="phone_whatsapp" type="tel" name="phone_whatsapp" value="{{ old('phone_whatsapp') }}" placeholder="+57 300 123 4567" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                </div>

                <div>
                    <label for="city" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Ciudad</label>
                    <input id="city" type="text" name="city" value="{{ old('city') }}" placeholder="Ej: Bogotá, Santa Marta..." required
                        class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                </div>

                <div>
                    <label for="password" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                </div>

                <button type="submit" class="btn-navy w-full text-center !py-3.5 !text-base mt-2">
                    Crear Cuenta
                </button>

                <p class="text-sm text-gray-400 text-center mt-4">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-gold hover:underline font-semibold">Ingresar</a>
                </p>
            </form>
        </div>
    </div>
</section>
@endsection
