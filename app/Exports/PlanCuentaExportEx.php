<?php

namespace App\Exports;

use App\User;
use DB;
use App\Models\planCuenta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;

class PlanCuentaExportEx implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Nro. Cuenta',
            'Código',
            'Nombre Cta.',
            'Imp.',
            'Nivel',
        ];
    }
    public function collection()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        return planCuenta::on('mysql4')->select('planCuentas.id','planCuentas.codigo', 'planCuentas.nombre', 'planCuentas.imp', 'planCuentas.nivel')
        ->where('id', '<>', 1)->orderBy('planCuentas.codigo')->get();

    }
}
