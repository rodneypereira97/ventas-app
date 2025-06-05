@extends('layouts.app')

@section('title', 'Cobrar Venta')

@section('content')
<div class="container px-4 mx-auto" style="max-width: 1000px;">
    <h1 class="h3 mb-4">Cobrar Venta</h1>
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('cobros.store', $venta) }}" method="POST">
                @csrf
                <input type="hidden" name="venta_id" value="{{ $venta->id }}">
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <input type="text" class="form-control" value="{{ $venta->cliente->nombre ?? 'Ocasional' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Total a Pagar</label>
                    <input type="text" id="monto_total" class="form-control" value="${{ number_format($venta->total, 2) }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="monto_pagado" class="form-label">Monto Pagado</label>
                    <input type="number" step="0.01" name="monto_pagado" id="monto_pagado" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="vuelto">Vuelto</label>
                    <input type="text" id="vuelto" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="metodo_pago" class="form-label">Método de Pago</label>
                    <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Confirmar Cobro</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const total = parseFloat({{ $venta->total }});
        const inputPagado = document.getElementById('monto_pagado');
        const inputVuelto = document.getElementById('vuelto');

        inputPagado.addEventListener('input', function () {
            const pagado = parseFloat(this.value);
            if (!isNaN(pagado)) {
                const vuelto = pagado - total;
                inputVuelto.value = vuelto >= 0 ? `$${vuelto.toFixed(2)}` : 'Monto insuficiente';
            } else {
                inputVuelto.value = '';
            }
        });
    });
</script>
@endpush