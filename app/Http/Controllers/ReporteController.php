<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Cobro;
use Carbon\Carbon;


class ReporteController extends Controller
{
    public function ventas(Request $request)
    {
        // Filtro por fechas (si se pasan)
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $ventas = Venta::query();

        if ($fechaInicio && $fechaFin) {
            $ventas->whereBetween('created_at', [
                Carbon::parse($fechaInicio)->startOfDay(),
                Carbon::parse($fechaFin)->endOfDay()
            ]);
        }

        $ventas = $ventas->orderBy('created_at', 'desc')->get();

        return view('reportes.ventas', compact('ventas', 'fechaInicio', 'fechaFin'));
    }

    public function cobros(Request $request)
    {
        // lógica para reporte de cobros
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $cobros = Cobro::query();

        if ($fechaInicio && $fechaFin) {
            $cobros->whereBetween('fecha_cobro',[
                Carbon::parse($fechaInicio)->startOfDay(),
                Carbon::parse($fechaFin)->endOfDay()
            ]);
        }

        $cobros = $cobros->orderBy('fecha_cobro', 'desc')->get();

        return view('reportes.cobros' , compact('cobros', 'fechaInicio', 'fechaFin'));
    }

    public function productos()
    {
        // lógica para reporte de productos
        return view('reportes.productos');
    }

    public function clientes()
    {
        // lógica para reporte de clientes
        return view('reportes.clientes');
    }
}
