@extends('layouts.app')

@section('title', 'Pago Exitoso')

@section('content')
<section class="bg-ivory min-h-[60vh] flex items-center justify-center py-16">
    <div class="w-full max-w-lg px-6">
        <div class="card-editorial p-10 text-center">
            <div class="w-16 h-16 bg-gold/10 border border-gold/30 rounded-subtle flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="font-display text-2xl text-ink mb-3">¡Pago Exitoso!</h1>
            <p class="text-gray-400 text-sm mb-8 max-w-sm mx-auto">Tu inscripción ha sido confirmada. Ya puedes acceder al contenido del curso.</p>
            <a href="{{ url('/mis-cursos') }}" class="btn-navy">
                Ir a Mis Cursos
            </a>
        </div>
    </div>
</section>
@endsection
