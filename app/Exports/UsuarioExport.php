<?php

namespace App\Exports;
use DB;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;

Class UsuarioExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'ID Rol',
            'Descripcion del Rol',
            'E-mail',
        ];
    }

    public function collection()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        return User::on('mysql4')->select( 'users.id','users.name','users.id_rol','roles.descripcion','users.email')
        ->join('roles', 'roles.id', '=', 'users.id_rol') ->orderBy('users.id')->get();
    }


}
