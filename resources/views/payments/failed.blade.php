@extends('layouts.app')

@section('title', 'Pago No Procesado')

@section('content')
<section class="bg-ivory min-h-[60vh] flex items-center justify-center py-16">
    <div class="w-full max-w-lg px-6">
        <div class="card-editorial p-10 text-center">
            <div class="w-16 h-16 bg-red-50 border border-red-200 rounded-subtle flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <h1 class="font-display text-2xl text-ink mb-3">Pago No Procesado</h1>
            <p class="text-gray-400 text-sm mb-8 max-w-sm mx-auto">Hubo un problema con el pago. Puedes intentar nuevamente o contactarnos por WhatsApp para asistencia.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ url('/cursos') }}" class="btn-navy">
                    Intentar de Nuevo
                </a>
                <a href="https://wa.me/573001234567?text=Hola%2C%20tuve%20un%20problema%20con%20mi%20pago" target="_blank"
                   class="inline-flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#1fb855] text-white font-semibold text-sm px-6 py-3 rounded-subtle transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                    Contactar por WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
