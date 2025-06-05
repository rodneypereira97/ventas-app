<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cobro;
use Illuminate\Http\Request;

class CobroController extends Controller
{
    public function create(Venta $venta)
    {
        return view('cobros.create', compact('venta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'metodo_pago' => 'required|string|max:50',
            'monto_pagado' => 'required|numeric|min:0',
        ]);
        $venta = Venta::findOrFail($request->venta_id);

        if ($request->monto_pagado < $venta->total) {
            return back()->with('error', 'El monto pagado es menor al total de la venta.')->withInput();
        }

        // Registrar el cobro
        Cobro::create([
            'venta_id' => $venta->id,
            'monto_pagado' => $request->monto_pagado,
            'metodo_pago' => $request->metodo_pago,
        ]);

        // Actualizar el estado de la venta
        $venta->estado = 'pagado';
        $venta->save();

         // Calcular el vuelto
        $vuelto = $request->monto_pagado - $venta->total;

        return redirect()
        ->route('ventas.index')
        ->with([
            'success' => 'Venta cobrada exitosamente.',
            'vuelto' => $vuelto
        ]);
    }

        public function index()
    {
        // Obtener todos los cobros, puedes personalizar esto según tus necesidades (filtrar, paginar, etc.)
        $cobros = Cobro::with('venta.cliente')->latest()->get();

        return view('cobros.index', compact('cobros'));
    }

}

