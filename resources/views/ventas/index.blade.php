@extends('layouts.app')

@section('title', 'Ventas Registradas')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Ventas Registradas</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <h2 class="h4">Listado de ventas</h2>
        <a href="{{ route('ventas.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nueva venta
        </a>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                        <tr>
                            <td>{{ optional($venta->cliente)->nombre ?? 'Ocasional' }}</td>
                            <td>${{ number_format($venta->total, 2) }}</td>
                            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($venta->estado === 'anulada')
                                    <span class="badge bg-danger">Anulada</span>
                                @elseif(!$venta->cobro)
                                    {{-- Si no tiene cobro y no está anulada, mostrar COBRAR --}}
                                    <a href="{{ route('cobros.create', $venta->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-dollar-sign"></i> Cobrar
                                    </a>

                                    {{-- Botón para anular --}}
                                    <button class="btn btn-danger btn-sm btn-anular" data-id="{{ $venta->id }}">
                                        <i class="fas fa-times"></i> Anular
                                    </button>
                                @else
                                    {{-- Si tiene cobro, mostrar RECIBO --}}
                                    <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver Recibo
                                    </a>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<!-- Paginación -->
<div class="d-flex justify-content-center"> 
{{ $ventas->links('pagination::bootstrap-5') }}
</div>
<form id="anularForm" method="POST" style="display: none;">
    @csrf
    @method('PUT')
</form>


@endsection
@push('scripts')
    @if(session('vuelto') !== null)
    <script>
        Swal.fire({
            title: 'Cobro exitoso',
            text: 'Vuelto: ${{ number_format(session('vuelto'), 2) }}',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
     @endif
    <script>
        document.querySelectorAll('.btn-anular').forEach(button => {
            button.addEventListener('click', function () {
                const ventaId = this.getAttribute('data-id');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción anulará la venta. No podrás revertirlo.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, anular',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('anularForm');
                        form.setAttribute('action', `/ventas/${ventaId}/anular`);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
