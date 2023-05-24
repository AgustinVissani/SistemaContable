<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Conexion;
use App\Models\Empresa;
use App\Helpers\DatabaseConnection;

class RestoreDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore {--f|filename= : Restore a specific backup file name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore your Mysql database from a file';

    protected $filename;

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

        $filename = $this->option('filename');
        $this->filename = $filename;

        $filename=str_replace('/', '\\', $filename);

        $filename='E:\DesarrolloWEB\mi-proyecto-laravel2\storage\app\\'.$filename;

        $comando= sprintf('E:\xampp\mysql\bin\mysql -u root %s < %s',$conexion->nombre, $filename);

        exec($comando);
    }
}
