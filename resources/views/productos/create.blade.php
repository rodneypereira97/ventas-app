@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="container px-4 mx-auto" style="max-width: 1000px;">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Crear nuevo producto</h3>
        </div>

        <form method="POST" action="{{ route('productos.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" step="0.01" class="form-control" name="precio" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" name="stock" required>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
