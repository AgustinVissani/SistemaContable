<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;

class SeederUsuario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'name' => 'Agustín',
			'id_rol' => '1',
			'email' => 'vissani1997@gmail.com',
			'password' => bcrypt('39982025'),
        ));
        User::create(array(
            'name' => 'Supervisor',
			'id_rol' => '2',
			'email' => 'supervisor@gmail.com',
			'password' => bcrypt('supervisor'),
        ));
        User::create(array(
            'name' => 'Administrador de tablas',
			'id_rol' => '3',
			'email' => 'administrador@gmail.com',
			'password' => bcrypt('administrador'),
        ));
        User::create(array(
            'name' => 'Auditor',
			'id_rol' => '4',
			'email' => 'auditor@gmail.com',
			'password' => bcrypt('auditor'),
        ));


    }
}
