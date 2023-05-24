<?php

namespace App\Exports;

use App\Models\Provincia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;
// use Maatwebsite\Excel\Concerns\ToModel;

Class ProvinciaExport implements FromCollection,WithHeadings
// Class ProvinciaExport implements ToModel
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre de la Provincia',
        ];
    }

    public function collection()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        return Provincia::on('mysql4')->select( 'provincias.id','provincias.descripcion')
        ->orderBy('provincias.id')->get();
    }


}
