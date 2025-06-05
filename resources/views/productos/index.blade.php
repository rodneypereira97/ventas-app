@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <h1 class="h3">Listado de productos</h1>
            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo producto
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <div class="card">
            <div class="card-body table-responsive p-0">
                <table id="tabla-productos" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>{{ $producto->precio }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>
                                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                       <!-- Botón para abrir el modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $producto->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                       

                                    </form>
                                         
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalEliminar{{ $producto->id }}" tabindex="-1" aria-labelledby="modalEliminarLabel{{ $producto->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="modalEliminarLabel{{ $producto->id }}">Confirmar Eliminación</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas eliminar el producto <strong>{{ $producto->nombre }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No hay productos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                 

                </table>

        </div>
     </div>
</div>
<div class="d-flex justify-content-center"> 
    {{ $productos->links('pagination::bootstrap-5') }}
</div>


@endsection
