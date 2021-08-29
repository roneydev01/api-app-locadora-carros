<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];

    public function marca()
    {
        //UM modelo PERTENCE a UMA marca
        return $this->belongsTo(Marca::class, 'marca_id', 'id');
    }
}
