<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CobroController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');  // Redirige a la ruta de login
});
Route::get('/cobros/{venta}/create', [CobroController::class, 'create'])->name('cobros.create');
Route::post('cobros', [CobroController::class, 'store'])->name('cobros.store');
Route::get('cobros', [CobroController::class, 'index'])->name('cobros.index');






Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});
Route::middleware(['auth'])->group(function () {
    Route::resource('productos', \App\Http\Controllers\ProductoController::class);
    Route::resource('clientes', \App\Http\Controllers\ClienteController::class);
    Route::resource('ventas', \App\Http\Controllers\VentaController::class);
    
    
});



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
Route::get('/dashboard/export/excel', [DashboardController::class, 'exportExcel'])->name('dashboard.export.excel');
Route::get('/dashboard/export/pdf', [DashboardController::class, 'exportPDF'])->name('dashboard.export.pdf');
    


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('reportes')->middleware(['auth'])->group(function () {
    Route::get('/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
    Route::get('/cobros', [ReporteController::class, 'cobros'])->name('reportes.cobros');
    Route::get('/productos', [ReporteController::class, 'productos'])->name('reportes.productos');
    Route::get('/clientes', [ReporteController::class, 'clientes'])->name('reportes.clientes');
});


require __DIR__.'/auth.php';
