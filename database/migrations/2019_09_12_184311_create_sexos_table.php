<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Conexion;
use Illuminate\Support\Facades\Schema;
use App\Helpers\DatabaseConnection;


class CreateSexosTable extends Migration
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

        Schema::connection('mysql2')->create('sexos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo',40)->unique();
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

        Schema::connection('mysql2')->dropIfExists('sexos');
    }
}
