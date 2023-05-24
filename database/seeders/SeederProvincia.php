<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provincia;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;

class SeederProvincia extends Seeder
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

        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Ciudad Autónoma de Buenos Aires',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Buenos Aires',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Catamarca',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Córdoba',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Corrientes',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Entre Ríos',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Jujuy',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Mendoza',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'La Rioja',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Salta',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'San Juan',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'San Luis',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Santa Fe',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Santiago del Estero',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Tucumán',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Chaco',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Chubut',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Formosa',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Misiones',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Neuquén',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'La Pampa',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Río Negro',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Santa Cruz',
        ));
        Provincia::on('mysql2')->create(array(
            'descripcion' => 'Tierra del Fuego',
        ));


    }
}
