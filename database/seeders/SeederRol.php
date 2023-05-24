<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;

class SeederRol extends Seeder
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

        Rol::on('mysql2')->create(array(
            'descripcion' => 'Admin del Sistema',
        ));
        Rol::on('mysql2')->create(array(
            'descripcion' => 'Supervisor de usuarios',
        ));
        Rol::on('mysql2')->create(array(
            'descripcion' => 'Administrador de tablas',
        ));
        Rol::on('mysql2')->create(array(
            'descripcion' => 'Auditor',
        ));
    }
}
