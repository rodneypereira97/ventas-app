<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Cambiar el tipo de la columna 'estado' de enum a string
            $table->string('estado')->default('pendiente')->change();
        });
    }
    
    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Revertir a enum con los valores originales
            $table->enum('estado', ['pendiente', 'pagado'])->default('pendiente')->change();
        });
    }
     
};
