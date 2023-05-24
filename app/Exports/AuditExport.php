<?php

namespace App\Exports;

use App\Models\Audits;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;
// use Maatwebsite\Excel\Concerns\ToModel;

Class AuditExport implements FromCollection,WithHeadings
{
// Class ClienteExport implements ToModel

    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'ID',
            'ID Usuario',
            'Nombre Usuario',
            'Acción',
            'Tabla',
            'URL',
            'Dirección',
            'Fecha/Horario',

        ];
    }

    public function collection()
    {
        $conexion = Conexion::find(1);

        return Audits::select('audits.id','audits.user_id','users.name As nombre Usuario','audits.event','audits.auditable_type',
        'audits.url','audits.ip_address','audits.created_at')
        ->where('audits.empresa','=',$conexion->nombre)
        ->join('users', 'users.id', '=', 'audits.user_id')
        ->orderBy('audits.id')->get();
    }


}
