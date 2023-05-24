<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;
// use Maatwebsite\Excel\Concerns\ToModel;

Class ClienteExport implements FromCollection,WithHeadings
{
// Class ClienteExport implements ToModel

    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Apellido',
            'DNI',
            'E-mail',
            'Dirección',
            'Teléfono',
            'ID Sexo',
            'Sexo',
            'ID Provincia',
            'Provincia',


        ];
    }




    public function collection()
    {


        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);


        return Cliente::on('mysql4')->select( 'clientes.id','clientes.nombre','clientes.apellido','clientes.dni','clientes.mail','clientes.direccion','clientes.telefono','clientes.sexo AS id_sexo', 'sexos.tipo As sexo', 'clientes.id_provincia', 'provincias.descripcion As provincia',  )
        ->join('provincias', 'provincias.id', '=', 'clientes.id_provincia')
        ->join('sexos', 'sexos.id', '=', 'clientes.sexo')
        ->orderBy('clientes.id')->get();

    }


}
