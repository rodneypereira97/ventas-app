@extends('layouts.app')

@section('title', 'Reporte de Ventas')

@section('content')
<div class="container">
    <h1 class="mb-4">Reporte de Ventas</h1>

    {{-- Filtro por rango de fechas --}}
    <form method="GET" action="{{ route('reportes.ventas') }}" class="row g-3 mb-4">
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
            <a href="{{ route('reportes.ventas') }}" class="btn btn-secondary">Limpiar</a>
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
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ optional($venta->cliente)->nombre ?? 'Ocasional' }}</td>
                            <td>${{ number_format($venta->total, 2) }}</td>
                            <td>
                                @if ($venta->estado === 'pagado')
                                    <span class="badge bg-success">Pagado</span>
                                @elseif ($venta->estado === 'pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @else
                                    <span class="badge bg-danger">Anulada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No se encontraron ventas en el rango de fechas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
