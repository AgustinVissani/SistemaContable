<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provincia;
use App\Models\Conexion;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProvinciaExport;
use App\Helpers\DatabaseConnection;

class ControllerProvincia extends Controller
{

    public function __construct()
    {
        // Filtrar todos los métodos
        $this->middleware('auth');
        $this->middleware('rolAdminTabla');
    }

    public function viewProvicias()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();
        return view('provincias/provincias')->with('provincias', $provincias);
    }


    public function altaProvincia()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();
        return view('provincias/altaProvincia')->with('provincias', $provincias);
    }



    private function validarRequest(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required',
        ]);
    }


    public function altaProvinciaPost(Request $request)
    {

        self::validarRequest($request);
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        try {

            $provincia = Provincia::on('mysql4')->create(array(
                'descripcion' => $request->descripcion,
            ));
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensaje', 'Ya existe una provincia con esa descripción "' . $request->descripcion . '"');
        }

        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();
        return redirect('altaProvincia')->with('success', 'Provincia agregada con éxito, su id asignado es: ' . $provincia->id .'" y nombre "' . $provincia->descripcion . '"');
    }


    private function validarEditRequest(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required',
        ]);
    }

    public function editProvincia($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $provincia = Provincia::on('mysql4')->find($id);
        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();
        return view('provincias/editProvincia')->with('provincia', $provincia);
    }


    public function editProvinciaPost(Request $request, $id)
    {
        self::validarEditRequest($request);

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        try {
            $provincia = Provincia::on('mysql4')->find($id);
            $provincia->descripcion = $request->descripcion;
            $provincia->save();

            $provincias = Provincia::on('mysql4')->select('provincias.id', 'provincias.descripcion')
                ->get();
            return redirect('provincias')->with('provincias', $provincias)->with('success', 'Provincia editada con éxito');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensaje', 'Ya existe una provincia con ese nombre "' . $request->descripcion . '"');
        }
    }

    public function deleteProvincia($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        try {
            $provincia = Provincia::on('mysql4')->find($id);
            $provincia->delete();
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensajeError', 'No se puede eliminar la provincia ' . $provincia->descripcion . ', tiene clientes asociados');
        }

        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();
        return redirect('provincias')->with('provincias', $provincias)->with('success', 'Provincia eliminada con éxito');
    }


    public function exportPdf()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $provincias = Provincia::on('mysql4')->select('provincias.id', 'provincias.descripcion')
            ->orderBy('provincias.id')
            ->get();
        $pdf = PDF::loadView('pdf.provinciaspdf', compact('provincias'));
        return $pdf->stream('provincia-list.pdf');
    }




    public function exportxlsx()
    {
        return Excel::download(new ProvinciaExport, 'provincia-list.xlsx');
    }

    public function verProvincias()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $provincias = Provincia::on('mysql4')->select('provincias.id', 'provincias.descripcion')
            ->orderBy('provincias.id')->get();
        return view('provincias/verProvincias')->with('provincias', $provincias);
    }
}
