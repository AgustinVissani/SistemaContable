<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class RenglonDIARIO_MAYOR extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table='renglonesDIARIO_MAYOR';



    protected $fillable = [
        'id',
        'id_asiento' ,
        'id_cuenta' ,
        'fecha_vencimiento' ,
        'fecha_oper' ,
        'comprobante' ,
        'id_sucursal' ,
        'id_seccion' ,
        'debe_haber' ,
        'importe' ,
        'leyenda' ,

    ];

}
