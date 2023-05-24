<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;

class SeederCliente extends Seeder
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

        Cliente::on('mysql2')->create(array(
            'nombre' => 'Agustin',
			'apellido' => 'Vissani',
			'dni' => '39982025',
			'mail' => 'vissani1997@gmail.com',
			'direccion' => 'Bahía Blanca',
			'telefono' => '2923698697',
			'sexo' => '1',
            'id_provincia' => '2',
        ));

        Cliente::on('mysql2')->create(array(
            'nombre' => 'Nombre1',
			'apellido' => 'Apellido1',
			'dni' => '11111111',
			'mail' => 'email1@gmail.com',
			'direccion' => 'Direccion 1',
			'telefono' => '111111111',
			'sexo' => '2',
            'id_provincia' => '7',
        ));
        // Cliente::create(array(
        //     'nombre' => 'Nombre2',
		// 	'apellido' => 'Apellido2',
		// 	'dni' => '22222222',
		// 	'mail' => 'email2@gmail.com',
		// 	'direccion' => 'Direccion 2',
		// 	'telefono' => '22222222',
		// 	'sexo' => '1',
        //     'id_provincia' => '15',
        // ));
        // Cliente::create(array(
        //     'nombre' => 'Nombre3',
		// 	'apellido' => 'Apellido3',
		// 	'dni' => '33333333',
		// 	'mail' => 'email3@gmail.com',
		// 	'direccion' => 'Direccion 2',
		// 	'telefono' => '33333333',
		// 	'sexo' => '3',
        //     'id_provincia' => '6',
        // ));
        // Cliente::create(array(
        //     'nombre' => 'Nombre4',
		// 	'apellido' => 'Apellido4',
		// 	'dni' => '44444444',
		// 	'mail' => 'email4@gmail.com',
		// 	'direccion' => 'Direccion 4',
		// 	'telefono' => '444444444',
		// 	'sexo' => '3',
        //     'id_provincia' => '8',
        // ));

    }
}
