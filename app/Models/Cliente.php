<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','email','telefono','direccion']; // tipo es "registrado" o "ocasional"

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
