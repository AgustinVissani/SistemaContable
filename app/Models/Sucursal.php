<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Sucursal extends Model implements Auditable

{
    use \OwenIt\Auditing\Auditable;
    protected $table='sucursales';

    protected $fillable = [
        'denominacion',
        'id_provincia',
        'cp',
        'id_localidad',
        'calle',
        'numero',
        'piso',
    ];

}
