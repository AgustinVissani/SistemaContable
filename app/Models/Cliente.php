<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class Cliente extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table='clientes';


    public function provincia(){
        return $this->belongsTo('App\Provincia','id_provincia');
    }

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'mail',
        'direccion',
        'telefono',
        'sexo',
        'id_provincia',
    ];

}

