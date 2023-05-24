<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Conexion;
use App\Models\Empresa;
use App\Helpers\DatabaseConnection;


class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $empresa=Empresa::select('nombrepila')->where('nombre','=',$conexion->nombre)->get();

        $basedatos=$empresa[0]->nombrepila;

        $basedatos = str_replace(' ', '_', $basedatos);
        $basedatos = str_replace('.', '', $basedatos);

        $ruta=storage_path('app\backups');
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $ruta=$ruta.'\\'. date('Y-m-d-H-i-s', time()) .'_backup_empresa_'. $basedatos .'.sql';


        $comando= sprintf('E:\xampp\mysql\bin\mysqldump -u root %s > %s',$conexion->nombre, $ruta);

        exec($comando);

    }
}
