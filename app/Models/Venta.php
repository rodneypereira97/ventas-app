<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'user_id', 'total'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_ventas')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                    ->withTimestamps();
    }

    // Venta.php
    public function cobro()
    {
        return $this->hasOne(Cobro::class);
    }

}
