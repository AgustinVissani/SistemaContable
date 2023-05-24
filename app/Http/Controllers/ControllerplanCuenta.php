<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\planCuenta;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanCuentaExportEx;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;
use App\Models\Renglon;

class ControllerplanCuenta extends Controller
{

    public function __construct()
    {
        // Filtrar todos los métodos
        $this->middleware('auth');
        $this->middleware('rolAdminTabla');
    }


    public function viewplanCuenta()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $planCuentas = planCuenta::on('mysql4')->select('plancuentas.*')->get();
        return view('plancuenta/planCuentas')->with('planCuentas', $planCuentas);
    }


    public function verplanCuenta($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $planCuentas = planCuenta::on('mysql4')->find($id);
        return view('plancuenta/verplanCuenta')->with('planCuenta', $planCuentas);
    }

    public function altaplanCuenta()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $planCuentas = planCuenta::on('mysql4')->select('plancuentas.*')->where('imp', '=', 'No')->get();

        return view('plancuenta/altaplanCuenta')->with('planCuentas', $planCuentas);
    }

    private function validarRequest(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $this->validate($request, [
            'nombre' => 'required|unique:mysql4.plancuentas',
        ]);
    }


    private function validarEditRequest(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|unique:mysql4.plancuentas,nombre,' . $id,
        ]);
    }

    public function altaplanCuentaPost(Request $request)
    {
        self::validarRequest($request);

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $pref = $request->id_nivel;

        if ($request->id_nivel != '') {
            if (strlen($request->sufijo) == 2) {
                $suf = '.' . $request->sufijo;
            } else {
                $suf = '.0' . $request->sufijo;
            }
        } else {
            $pref = $request->sufijo;
            $suf = '';
        }

        $planCuentas = planCuenta::on('mysql4')->select('plancuentas.*')->where('prefijo', '=', $pref)->where('sufijo', '=', $suf)->get();

        if ($request->has('imp')) {
            $imput = 'Sí';
            $primerLetra = strtoupper($request->nombre[0]);
            $cadena = strtolower(substr($request->nombre, 1));
            $request->nombre = $primerLetra . $cadena;
        } else {
            $imput = 'No';
            $request->nombre = strtoupper($request->nombre);
        }

        $text = $pref . $suf;
        $nivel = substr_count($text, '.') + 1;

        if (count($planCuentas) != 0) {

            $planCuentas = planCuenta::on('mysql4')->select('plancuentas.*')->where('prefijo', '=', $pref)->where('sufijo', '<>', '')->orderBy('planCuentas.sufijo')->get();
            $nro = '.01';
            $count = 0;
            $u = 1;
            $d = 0;
            $aparece = true;
            while ($aparece && count($planCuentas) != $count) {
                if (strcmp($planCuentas[$count]->sufijo, $nro) !== 0) {
                    $aparece = false;
                } else {
                    $count++;
                    if ($u == 9) {
                        $u = 0;
                        $d = $d + 1;
                    } else {
                        $u = $u + 1;
                    }
                    $nro = '.' . $d . $u;
                }
            }
            return back()->with('mensajeError', 'Ya existe un registro en el plan de cuentas con el código "' . $pref . $suf . '" y nombre "' . $planCuentas[0]->nombre . '". Se sugiere agregar el número: ' . $nro);
        } else if ($pref == '' && $suf == '') {
            return back()->with('mensaje', 'El registro en el plan de cuentas debe poseer código');
        } else {
            try {
                $planCuentas = planCuenta::on('mysql4')->create(array(
                    'codigo' => $text,
                    'prefijo' => $pref,
                    'sufijo' => $suf,
                    'nombre' => $request->nombre,
                    'imp' => $imput,
                    'nivel' => $nivel,
                ));
            } catch (\Illuminate\Database\QueryException $ex) {
                return back()->with('mensajeError', 'Ya existe un registro en el plan de cuentas con el código "' . $pref . $suf . '"');
            }
            return redirect('altaplanCuenta')->with('success', 'Registro en Plan de cuentas agregado con éxito, su id asignado es: ' . $planCuentas->id . '" y nombre "' . $planCuentas->nombre . '"');
        }
    }

    public function editplanCuenta($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $planCuenta = planCuenta::on('mysql4')->find($id);
        return view('plancuenta/editplanCuenta')->with('planCuenta', $planCuenta);
    }


    public function editplanCuentaPost(Request $request, $id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        self::validarEditRequest($request, $id);

        try {
            $planCuenta = planCuenta::on('mysql4')->find($id);
            // $planCuenta->prefijo = $request->prefijo;
            // $planCuenta->sufijo = $request->sufijo;
            $planCuenta->nombre = $request->nombre;

            if ($request->has('imp')) {
                $imput = 'Sí';
                $primerLetra = strtoupper($request->nombre[0]);
                $cadena = strtolower(substr($request->nombre, 1));
                $request->nombre = $primerLetra . $cadena;
            } else {
                $imput = 'No';
                $request->nombre = strtoupper($request->nombre);
            }

            if (strcmp($planCuenta->imp, $imput) !== 0) {
                if (strcmp($planCuenta->imp, "No") === 0) {
                    $planCuentas = planCuenta::on('mysql4')->select('plancuentas.*')->where('prefijo', '=', $planCuenta->codigo)->where('id', '<>', $id)->get();
                    echo "cuenta codigo:" . $planCuenta->codigo . ' plancuenta:';
                    echo $planCuentas;
                    if (count($planCuentas) !== 0) {
                        $planCuenta->save();
                        return back()->with('mensajeError', 'No se puede editar el registro del plan de cuenta con código "' . $planCuenta->codigo . '" porque tiene registros asociados.');
                    } else {
                        $planCuenta->imp = $imput;
                    }
                } else {
                    $renglones = Renglon::on('mysql4')->select('renglones.*')->where('renglones.id_cuenta', '=', $planCuenta->id)->get();
                    if (count($renglones) !== 0) {
                        $planCuenta->save();
                        return back()->with('mensajeError', 'No se puede editar el registro del plan de cuenta con código "' . $planCuenta->codigo . '" porque tiene movimientos asociados.');
                    }
                }
            }
            $planCuenta->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensajeError', 'Ya existe un plan de cuenta con el código "' . $request->codigo . '"');
        }

        $planCuentas = planCuenta::on('mysql4')->select('planCuentas.*')
            ->get();
        return redirect('planCuentas')->with('planCuentas', $planCuentas)->with('success', 'Registro del plan de cuentas editado con éxito');
    }


    public function deleteplanCuentas($id)
    {

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);


        $planCuenta = planCuenta::on('mysql4')->find($id);
        $codigo = $planCuenta->prefijo . $planCuenta->sufijo;

        $planCuentas = planCuenta::on('mysql4')->select('plancuentas.*')->where('prefijo', '=', $codigo)->where('id', '<>', $id)->get();

        if (count($planCuentas) != 0) {
            return back()->with('mensajeError', 'No puede eliminarse del plan de cuentas el registro con código  "' . $codigo . '" porque tiene hijos asociados');
        } else {
            try {
                $planCuenta->delete();
                $planCuentas = planCuenta::on('mysql4')->get();
            } catch (\Illuminate\Database\QueryException $ex) {
                return back()->with('mensajeError', 'La cuenta con código "' . $codigo . '" tiene movimientos asociados');
            }
            return redirect('planCuentas')->with('planCuentas', $planCuentas)->with('success', 'El registro del plan de cuentas fue eliminado con éxito');
        }
    }


    public function exportPdf()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $planCuentas = planCuenta::on('mysql4')->select('planCuentas.id', 'planCuentas.codigo', 'planCuentas.nombre', 'planCuentas.imp', 'planCuentas.nivel')->where('id', '<>', 1)
            ->orderBy('planCuentas.codigo')
            ->get();
        $pdf = PDF::loadView('pdf.planCuentaspdf', compact('planCuentas'));
        return $pdf->stream('planCuentas-list.pdf');
    }


    public function exportxlsx()
    {
        return Excel::download(new PlanCuentaExportEx, 'planCuentas-list.xlsx');
    }


    public function verplanCuentas()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $planCuentas = planCuenta::on('mysql4')->select('planCuentas.*')->where('id', '<>', 1)
            ->orderBy('planCuentas.codigo')->get();
        return view('plancuenta/verplanCuentas')->with('planCuentas', $planCuentas)->with('esp', '');
    }
}
