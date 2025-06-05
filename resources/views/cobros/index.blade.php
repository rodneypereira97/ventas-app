@extends('layouts.app')

@section('title', 'Cobros')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Listado de Cobros</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Venta ID</th>
                        <th>Cliente</th>
                        <th>Monto Pagado</th>
                        <th>Método de Pago</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cobros as $cobro)
                        <tr>
                            <td>{{ $cobro->venta_id }}</td>
                            <td>{{ $cobro->venta->cliente->nombre ?? 'Ocasional' }}</td>
                            <td>${{ number_format($cobro->monto_pagado, 2) }}</td>
                            <td>{{ $cobro->metodo_pago }}</td>
                            <td>{{ $cobro->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver a Ventas</a>
            </div>
        </div>
    </div>
</div>
@endsection
