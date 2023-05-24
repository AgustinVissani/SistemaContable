<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent;
use App\Models\Inicio;
use GuzzleHttp\Promise\Create;

class Empresa extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table='empresa';
    protected $connection='mysqlempresas';

    protected $fillable = [
        'nombre',
        'nombrepila'
    ];

}
