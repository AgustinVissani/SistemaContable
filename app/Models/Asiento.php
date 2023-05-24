<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class Asiento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table='asientos';

    protected $fillable = [
        'id',
        'fecha' ,
        'tipo_asiento',
        'proximo_id_renglon',
        'ok_carga' ,
        'registrado' ,
    ];

}
