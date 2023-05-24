<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;

class CreateClientesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        Schema::connection('mysql2')->create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',40);
            $table->string('apellido',40);
            $table->integer('dni')->unique();
            $table->string('mail')->unique();
            $table->string('direccion',80);
            $table->string('telefono',14);
            $table->integer('sexo');
            $table->integer('id_provincia');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        Schema::connection('mysql2')->dropIfExists('clientes');
    }
}
