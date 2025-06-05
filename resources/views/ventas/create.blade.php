@extends('layouts.app')

@section('title', 'Nueva Venta')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Registrar Nueva Venta</h1>
        {{-- Mensajes de alerta de stock --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

    <form id="ventaForm" action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-body">
                <!-- Cliente -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select name="cliente_id" id="cliente_id" class="form-control" required>
                            <option value="0">Cliente Ocasional</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Productos -->
                <div id="productos-container">
                    <div class="row mb-3 producto-item">
                        <div class="col-md-4">
                            <label class="form-label">Producto</label>
                            <select name="productos[]" class="form-control producto-select" required>
                                <option value="">Seleccione un producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}" data-stock="{{ $producto->stock }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Cantidad</label>
                            <input type="number" name="cantidades[]" class="form-control cantidad" placeholder="Cantidad" min="1" required>
                            <small class="text-danger error-stock" style="display: none;"></small>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Stock</label>
                            <input type="text" class="form-control stock-disponible" disabled>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Precio</label>
                            <input type="text" name="precios[]" class="form-control precio" readonly placeholder="Precio">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm btn-remove w-100"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary btn-sm mb-3" id="btn-add-producto">
                    <i class="fas fa-plus"></i> Agregar Producto
                </button>

                <!-- Total -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Total</label>
                    <input type="text" name="total" id="total" class="form-control" readonly value="0">
                </div>

                <button type="submit" class="btn btn-primary">Guardar Venta</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function calcularTotal() {
    let total = 0;
    document.querySelectorAll('#productos-container .producto-item').forEach(item => {
        const precio = parseFloat(item.querySelector('.precio').value) || 0;
        const cantidad = parseInt(item.querySelector('.cantidad').value) || 0;
        total += precio * cantidad;
    });
    document.getElementById('total').value = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function () {
    function actualizarEventos(item) {
        const select = item.querySelector('.producto-select');
        const cantidadInput = item.querySelector('.cantidad');
        const precioInput = item.querySelector('.precio');
        const stockField = item.querySelector('.stock-disponible');
        const errorLabel = item.querySelector('.error-stock');

        select.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const precio = selectedOption.dataset.precio || 0;
            const stock = selectedOption.dataset.stock || '';
            precioInput.value = precio;
            stockField.value = stock;
            cantidadInput.dataset.stock = stock;
            calcularTotal();
        });

        cantidadInput.addEventListener('input', function () {
            const stock = parseInt(this.dataset.stock || 0);
            const cantidad = parseInt(this.value);
            if (cantidad > stock) {
                errorLabel.textContent = `No hay suficiente stock. Máximo: ${stock}`;
                errorLabel.style.display = 'block';
                this.classList.add('is-invalid');
            } else {
                errorLabel.textContent = '';
                errorLabel.style.display = 'none';
                this.classList.remove('is-invalid');
            }
            calcularTotal();
        });
    }

    document.querySelectorAll('.producto-item').forEach(actualizarEventos);

    document.getElementById('btn-add-producto').addEventListener('click', function () {
        const container = document.getElementById('productos-container');
        const newItem = container.querySelector('.producto-item').cloneNode(true);

        newItem.querySelectorAll('input').forEach(input => input.value = '');
        newItem.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
        newItem.querySelector('.stock-disponible').value = '';
        newItem.querySelector('.error-stock').style.display = 'none';
        newItem.querySelector('.cantidad').classList.remove('is-invalid');

        container.appendChild(newItem);
        actualizarEventos(newItem);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove') || e.target.closest('.btn-remove')) {
            const items = document.querySelectorAll('.producto-item');
            if (items.length > 1) {
                e.target.closest('.producto-item').remove();
                calcularTotal();
            }
        }
    });
});
$(document).on('click', '.btn-remove', function () {
    if ($('#productos-container .producto-item').length > 1) {
        $(this).closest('.producto-item').remove();
        calcularTotal();
    }
});

</script>
@endpush
