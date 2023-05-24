<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class planCuenta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table='planCuentas';




    protected $fillable = [
        'codigo',
        'prefijo',
        'sufijo',
        'nombre',
        'imp',
        'nivel',
    ];

}
