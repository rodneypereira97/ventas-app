@extends('layouts.app')

@section('title', 'Reporte de Cobros')

@section('content')
<div class="container">
    <h1 class="mb-4">Reporte de Cobros</h1>

    {{-- Filtro por rango de fechas --}}
    <form method="GET" action="{{ route('reportes.cobros') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="fecha_inicio" class="form-label">Desde:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="fecha_fin" class="form-label">Hasta:</label>
            <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filtrar</button>
            <a href="{{ route('reportes.cobros') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    {{-- Tabla de ventas --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead class="text-center">
                <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Monto Pagado</th>
                        <th>Método de Pago</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($cobros as $cobro)
                        <tr>
                            <td>{{ $cobro->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $cobro->venta->cliente->nombre ?? 'Ocasional' }}</td>
                            <td>${{ number_format($cobro->monto_pagado, 2) }}</td>
                            <td>{{ $cobro->metodo_pago }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
