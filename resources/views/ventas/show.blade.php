@extends('layouts.app')

@section('title', 'Venta - Recibo')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Contenedor del ticket -->
                        <div style="text-align: center; border: 1px solid #ddd; padding: 20px; font-family: 'Courier New', Courier, monospace; width: 100%; max-width: 600px; margin: auto;">
                            <h3>Recibo de Venta</h3>
                            <p><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? 'Ocasional' }}</p>
                            <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>

                            <hr>

                            <h5>Detalles de los productos:</h5>
                            <table class="table table-bordered" style="font-size: 12px; margin-bottom: 10px;">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($venta->productos as $producto)
                                        <tr>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->pivot->cantidad }}</td>
                                            <td>${{ number_format($producto->precio, 2) }}</td>
                                            <td>${{ number_format($producto->pivot->cantidad * $producto->precio, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <hr>

                            <p><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>

                            <hr>

                            <p style="font-size: 12px;">¡Gracias por tu compra!</p>
                        </div>

                        <!-- Botones de navegación -->
                        <div class="text-center mt-4">
                            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Volver al listado de ventas</a>
                            <button class="btn btn-primary" onclick="window.print()">Imprimir Recibo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos para la impresión -->
    <style>
        @media print {
            /* Ocultar los botones de la página durante la impresión */
            .btn-primary, .btn-secondary {
                display: none;
            }
        }
    </style>
@endsection
