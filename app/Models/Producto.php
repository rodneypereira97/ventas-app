<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    // Permitir asignación masiva en estos campos
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'user_id'
    ];

}
