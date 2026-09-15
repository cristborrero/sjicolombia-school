@extends('layouts.app')

@section('title', 'Ingresar')

@section('content')
<section class="bg-ivory min-h-[70vh] flex items-center justify-center py-16">
    <div class="w-full max-w-md px-6">
        <div class="card-editorial p-8 lg:p-10">
            {{-- Brand --}}
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-block mb-5">
                    <img src="{{ asset('images/logos/logo-sji-school-dark.svg') }}" alt="SJI Escuela Jurídica" class="h-14 w-auto mx-auto">
                </a>
                <h1 class="font-display text-2xl text-ink mb-1">Bienvenido de vuelta</h1>
                <p class="text-gray-400 text-sm">Ingresa a tu cuenta para acceder a tus cursos</p>
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

            @if (session('status'))
                <div class="bg-ivory border border-gold/30 rounded-subtle p-4 mb-6">
                    <p class="text-sm text-ink">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Correo Electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                </div>

                <div>
                    <label for="password" class="block text-[12px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-subtle text-sm focus:border-gold focus:ring-1 focus:ring-gold/30 outline-none transition-all bg-white">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-500">
                        <input type="checkbox" name="remember" class="rounded-sm border-gray-300 text-gold focus:ring-gold/50">
                        Recordarme
                    </label>
                </div>

                <button type="submit" class="btn-navy w-full text-center !py-3.5 !text-base">
                    Ingresar
                </button>

                <p class="text-sm text-gray-400 text-center mt-4">
                    ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-gold hover:underline font-semibold">Registrarse</a>
                </p>
            </form>
        </div>
    </div>
</section>
@endsection
