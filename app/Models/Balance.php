<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Balance extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table='balances';

    protected $fillable = [
        'id_cuenta',
        'codigo',
        'prefijo',
        'sufijo',
        'nombre',
        'nivel',
        'debitos',
        'creditos',
        'saldo_inicial',
        'saldo_acumulado',
        'saldo_cierre',
    ];

}
