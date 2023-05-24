<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conexion extends Model
{
    use HasFactory;

    protected $table='conexion';
    protected $connection='mysqlempresas';

    protected $fillable = [
        'nombre',
    ];
}
