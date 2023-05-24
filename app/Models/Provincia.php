<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Http\Controllers;
use App\Models\Empresa;
use Illuminate\Http\Request;


class Provincia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'provincias';

    protected $fillable = [
        'descripcion',

    ];
}
