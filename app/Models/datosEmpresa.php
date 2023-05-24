<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class datosEmpresa extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table='datosempresa';



    protected $fillable = [
        'nombrepila',
        'id_provincia',
        'cp',
        'calle',
        'numero',
        'piso',
        'tipo_responsable',
        'cuit',
        'fecha_emision_diario',
        'fecha_apertura',
        'fecha_cierre',
    ];

}
