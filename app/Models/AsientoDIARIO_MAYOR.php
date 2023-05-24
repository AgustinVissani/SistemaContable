<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class AsientoDIARIO_MAYOR extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table='asientosDIARIO_MAYOR';

    protected $fillable = [
        'id',
        'fecha' ,
        'tipo_asiento',
        'ok_carga' ,
        'registrado' ,
    ];

}
