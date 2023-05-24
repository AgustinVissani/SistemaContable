<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sexo;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;

class SeederSexo extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        Sexo::on('mysql2')->create(array(
            'tipo' => 'Masculino',
        ));
        Sexo::on('mysql2')->create(array(
            'tipo' => 'Femenino',
        ));
        Sexo::on('mysql2')->create(array(
            'tipo' => 'Prefiero no decirlo',
        ));
    }
}
