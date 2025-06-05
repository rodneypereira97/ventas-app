<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar formulario de creación de venta
    public function create()
    {
        $productos = Producto::all();
        $clientes = Cliente::all();
        return view('ventas.create', compact('productos', 'clientes'));
    }

    // Almacenar venta y detalle de productos
    
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'productos' => 'required|array',
            'cantidades' => 'required|array',
            'total' => 'required|numeric|min:0',
        ]);
    
        // Validar que cada producto tenga suficiente stock
        foreach ($request->productos as $index => $producto_id) {
            $producto = Producto::find($producto_id);
            $cantidad = $request->cantidades[$index];
    
            if (!$producto || $producto->stock < $cantidad) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No hay suficiente stock para el producto: ' . ($producto->nombre ?? 'desconocido'));
            }
        }
    
        // Si todo está bien, registramos la venta
        DB::beginTransaction();
    
        try {
            $venta = new Venta();
    
            $venta->cliente_id = $request->cliente_id != 0 ? $request->cliente_id : null;
            $venta->user_id = Auth::id();
            $venta->total = $request->total;
            $venta->save();
    
            foreach ($request->productos as $index => $producto_id) {
                $producto = Producto::find($producto_id);
                $cantidad = $request->cantidades[$index];
    
                $venta->productos()->attach($producto, [
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $producto->precio * $cantidad,
                ]);
    
                // Descontar el stock
                $producto->decrement('stock', $cantidad);
            }
    
            DB::commit();
    
            return redirect()->route('ventas.index')->with('success', 'Venta registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar la venta: ' . $e->getMessage());
        }
    }
    

    // Mostrar listado de ventas (opcional)
    public function index()
    {
        $ventas = Venta::with('cliente', 'productos', 'cobro')->get();
        $ventas = Venta::orderBy('created_at', 'desc')->paginate(10);
        return view('ventas.index', compact('ventas'));
    }
    public function show($id)
    {
                // Buscar la venta con el ID proporcionado y cargar los productos relacionados
                $venta = Venta::with('cliente', 'productos')->findOrFail($id);
                
                // Retornar la vista con la venta cargada
                return view('ventas.show', compact('venta'));
    }
    public function anular(Venta $venta)
    {
        // Cambiar el estado de la venta a 'anulada'
        $venta->estado = 'anulada';
        $venta->save();
    
        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta anulada exitosamente.');
    }
    



}
