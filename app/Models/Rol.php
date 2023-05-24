<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use \OwenIt\Auditing\Auditable;

class Rol extends Model{
// Model implements Auditable

    // use \OwenIt\Auditing\Auditable;
    protected $table='roles';

    protected $fillable = [
        'descripcion',
    ];

}
