<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Sucursal;
use App\Models\Asiento;
use App\Models\Renglon;
use App\Models\AsientoDIARIO_MAYOR;
use App\Models\RenglonDIARIO_MAYOR;
use App\Models\datosEmpresa;
use App\Models\Empresa;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;
use App\Models\planCuenta;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Com\Tecnick\Pdf\Font\Import;
use Mockery\Undefined;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;


class ControllerAsiento extends Controller
{
    public function __construct()
    {
        // Filtrar todos los métodos
        $this->middleware('auth');
        $this->middleware('rolAdminTabla');
    }


    public function viewAsiento()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $empresa = Empresa::where('nombre', '=', $conexion->nombre)->get();
        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();

        $asientos = Asiento::on('mysql4')->select('asientos.*')->where('asientos.registrado', '=', 0)->get();

        return view('asientos/asientos')->with('empresa', $empresa[0]->nombrepila)->with('datosempresa', $datosempresa[0])->with('asientos', $asientos);
    }


    private function validarRequest(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $this->validate($request, [
            'tipo_asiento' => 'required',
        ]);
    }

    public function altaAsientosPost(Request $request)
    {

        self::validarRequest($request);

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $asientos = Asiento::on('mysql4')->select('asientos.*')->orderBy('asientos.id')->get();
        $id_aux = 1;
        $count = 0;
        $aparece = true;
        while ($aparece && count($asientos) != $count) {
            if ($asientos[$count]->id == $id_aux) {
                $id_aux += 1;
                $count++;
            } else {
                $aparece = false;
            }
        }

        $empresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();

        if ($request->fecha_asiento > $empresa[0]->fecha_emision_diario && $request->fecha_asiento <= $empresa[0]->fecha_cierre) {
            if ($request->tipo_asiento == 1) {
                if (date("d", strtotime($request->fecha_asiento)) != 1) {
                    return back()->with('mensajeError', 'La fecha debe ser el primer día del mes al seleccionar de apertura');
                }
            } else if ($request->tipo_asiento == 9) {
                if (date("d", strtotime($request->fecha_asiento)) !=  date("t", strtotime($request->fecha_asiento))) {
                    return back()->with('mensajeError', 'La fecha debe ser el último día del mes al seleccionar de cierre');
                }
            }


            $asiento = Asiento::on('mysql4')->create(array(
                'id' => $id_aux,
                'fecha' => $request->fecha_asiento,
                'tipo_asiento' => $request->tipo_asiento,
                'proximo_id_renglon' => 1,
                'ok_carga' => 0,
                'registrado' => 0,
            ));
        } else {
            return back()->with('mensajeError', 'La fecha debe ser mayor a la fecha de la última emisión del diario"' .  $empresa[0]->fecha_emision_diario . '" y menor o igual a la fecha de cierre  "' . $empresa[0]->fecha_cierre . '"');
        }

        $ruta = 'renglones/' . $id_aux;
        return redirect($ruta);
    }



    public function altaAsientoOkPost(Request $request)
    {

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $renglones = Renglon::on('mysql4')->select()->where('renglones.id_asiento', '=', $request->id_asiento)->get();
        $asiento = Asiento::on('mysql4')->find($request->id_asiento);

        if (count($renglones) < 2) {
            $asiento->ok_carga = 0;
            $asiento->save();
            return back()->with('mensajeError', 'En el asiento no coincide el debe con el haber');
        } else {
            $sumaDebe = 0;
            $sumaHaber = 0;
            $count = 0;
            while (count($renglones) != $count) {
                if ($renglones[$count]->debe_haber == 0) {
                    $sumaDebe += $renglones[$count]->importe;
                } else {
                    $sumaHaber += $renglones[$count]->importe;
                }
                $count++;
            }
            if ($sumaHaber != $sumaDebe) {
                $asiento->ok_carga = 0;
                $asiento->save();
                return back()->with('mensajeError', 'En el asiento no coincide el debe con el haber ');
            }
        }
        $asiento->ok_carga = 1;
        $asiento->save();
        return redirect('asientos')->with('success', 'Asiento agregado con éxito, su id asignado es: ' . $request->id_asiento);
    }

    public function registrarAsiento($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);
        $asiento = Asiento::on('mysql4')->find($id);
        if ($asiento->ok_carga == 1) {
            $asiento->registrado = 1;
            $asiento->save();
            $AsientoDIARIO_MAYOR = AsientoDIARIO_MAYOR::on('mysql4')->create(array(
                'id' => $asiento->id,
                'fecha' => $asiento->fecha,
                'tipo_asiento' => $asiento->tipo_asiento,
                'ok_carga' => 1,
                'registrado' => 1,
            ));
            $renglones  = Renglon::on('mysql4')->where('renglones.id_asiento', '=', $id)->get();
            $count = 0;
            while (count($renglones) != $count) {

                $RenglonDIARIO_MAYOR = RenglonDIARIO_MAYOR::on('mysql4')->create(array(
                    'id'  => $renglones[$count]->id,
                    'id_asiento'  => $renglones[$count]->id_asiento,
                    'id_cuenta'  => $renglones[$count]->id_cuenta,
                    'fecha_vencimiento'  => $renglones[$count]->fecha_vencimiento,
                    'fecha_oper'  => $renglones[$count]->fecha_oper,
                    'comprobante'  => $renglones[$count]->comprobante,
                    'id_sucursal'  => $renglones[$count]->id_sucursal,
                    'id_seccion'  => $renglones[$count]->id_seccion,
                    'debe_haber'  => $renglones[$count]->debe_haber,
                    'importe'  => $renglones[$count]->importe,
                    'leyenda'  => $renglones[$count]->leyenda,
                ));
                $count++;
            }
        } else {
            return back()->with('mensajeError', 'El asiento no está cargado correctamente ');
        }
        return redirect('asientos')->with('success', 'Asiento registrado con éxito, su id asignado es: ' . $id);
    }

    public function registrarDH(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);
        $asientos = Asiento::on('mysql4')->select('asientos.*')
            ->where('asientos.fecha', '>=', $request->fecha_desde)
            ->where('asientos.fecha', '<=', $request->fecha_hasta)
            ->where('asientos.ok_carga', '=', 1)
            ->where('asientos.registrado', '=', 0)
            ->get();

        foreach ($asientos as $asiento) {
            $asiento->registrado = 1;
            $asiento->save();
            $AsientoDIARIO_MAYOR = AsientoDIARIO_MAYOR::on('mysql4')->create(array(
                'id' => $asiento->id,
                'fecha' => $asiento->fecha,
                'tipo_asiento' => $asiento->tipo_asiento,
                'ok_carga' => 1,
                'registrado' => 1,
            ));
            $renglones  = Renglon::on('mysql4')->where('renglones.id_asiento', '=', $asiento->id)->get();
            $count = 0;
            while (count($renglones) != $count) {

                $RenglonDIARIO_MAYOR = RenglonDIARIO_MAYOR::on('mysql4')->create(array(
                    'id'  => $renglones[$count]->id,
                    'id_asiento'  => $renglones[$count]->id_asiento,
                    'id_cuenta'  => $renglones[$count]->id_cuenta,
                    'fecha_vencimiento'  => $renglones[$count]->fecha_vencimiento,
                    'fecha_oper'  => $renglones[$count]->fecha_oper,
                    'comprobante'  => $renglones[$count]->comprobante,
                    'id_sucursal'  => $renglones[$count]->id_sucursal,
                    'id_seccion'  => $renglones[$count]->id_seccion,
                    'debe_haber'  => $renglones[$count]->debe_haber,
                    'importe'  => $renglones[$count]->importe,
                    'leyenda'  => $renglones[$count]->leyenda,
                ));
                $count++;
            }
        }
        return redirect('asientos')->with('success', 'Se han registrado ' . count($asientos) . 'asientos con éxito, desde: ' . $request->fecha_desde . ' hasta: ' . $request->fecha_hasta);
    }

    public function altaAsientoOkRegistradoPost(Request $request)
    {

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $renglones = Renglon::on('mysql4')->select()->where('renglones.id_asiento', '=', $request->id_asiento)->get();
        $asiento = Asiento::on('mysql4')->find($request->id_asiento);

        if (count($renglones) < 2) {
            $asiento->ok_carga = 0;
            $asiento->save();
            return back()->with('mensajeError', 'En el asiento no coincide el debe con el haber');
        } else {
            $sumaDebe = 0;
            $sumaHaber = 0;
            $count = 0;
            while (count($renglones) != $count) {
                if ($renglones[$count]->debe_haber == 0) {
                    $sumaDebe += $renglones[$count]->importe;
                } else {
                    $sumaHaber += $renglones[$count]->importe;
                }
                $count++;
            }
            if ($sumaHaber != $sumaDebe) {
                $asiento->ok_carga = 0;
                $asiento->save();
                return back()->with('mensajeError', 'En el asiento no coincide el debe con el haber ');
            }
        }
        $asiento->ok_carga = 1;
        $asiento->registrado = 1;
        $asiento->save();
        $AsientoDIARIO_MAYOR = AsientoDIARIO_MAYOR::on('mysql4')->create(array(
            'id' => $asiento->id,
            'fecha' => $asiento->fecha,
            'tipo_asiento' => $asiento->tipo_asiento,
            'ok_carga' => 1,
            'registrado' => 1,
        ));
        $renglones  = Renglon::on('mysql4')->where('renglones.id_asiento', '=',  $asiento->id)->get();
        $count = 0;
        while (count($renglones) != $count) {

            $RenglonDIARIO_MAYOR = RenglonDIARIO_MAYOR::on('mysql4')->create(array(
                'id'  => $renglones[$count]->id,
                'id_asiento'  => $renglones[$count]->id_asiento,
                'id_cuenta'  => $renglones[$count]->id_cuenta,
                'fecha_vencimiento'  => $renglones[$count]->fecha_vencimiento,
                'fecha_oper'  => $renglones[$count]->fecha_oper,
                'comprobante'  => $renglones[$count]->comprobante,
                'id_sucursal'  => $renglones[$count]->id_sucursal,
                'id_seccion'  => $renglones[$count]->id_seccion,
                'debe_haber'  => $renglones[$count]->debe_haber,
                'importe'  => $renglones[$count]->importe,
                'leyenda'  => $renglones[$count]->leyenda,
            ));
            $count++;
        }

        return redirect('asientos')->with('success', 'Asiento agregado con éxito, su id asignado es: ' . $request->id_asiento);
    }



    public function cancelarAsiento(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);


        Renglon::on('mysql4')->where('renglones.id_asiento', '=', $request->id_asiento)->delete();
        $asiento = Asiento::on('mysql4')->find($request->id_asiento);
        $asiento->delete();
        return redirect('asientos')->with('success', 'Asiento abandonado');;
    }

    public function deleteAsiento($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        Renglon::on('mysql4')->where('renglones.id_asiento', '=', $id)->delete();
        $asiento = Asiento::on('mysql4')->find($id);
        $asiento->delete();
        return redirect('asientos')->with('success', 'Asiento eliminado con éxito');
    }




    //RENGLONES


    public function viewRenglones($id)
    {

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $asiento = Asiento::on('mysql4')->find($id);
        $sucursales = Sucursal::on('mysql4')->select('sucursales.*')->get();
        $secciones = Seccion::on('mysql4')->select('secciones.*')->get();


        $cuentas = planCuenta::on('mysql4')->select('plancuentas.*')->orderby('plancuentas.codigo')->where('imp', '=', 'Sí')->get();
        $renglones = Renglon::on('mysql4')->select('renglones.*', 'plancuentas.nombre As NombreCuenta', 'plancuentas.codigo As CodigoCuenta')->where('renglones.id_asiento', '=', $id)
            ->join('plancuentas', 'plancuentas.id', '=', 'renglones.id_cuenta')
            ->get();

        $empresa = Empresa::where('nombre', '=', $conexion->nombre)->get();
        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();
        $ultimoIDRenglon = $asiento->proximo_id_renglon - 1;

        if ($ultimoIDRenglon == 0 || count($renglones) == 0) {
            $ultimoRenglon =  '';
        } else {
            $ultimoRenglon = Renglon::on('mysql4')->select('renglones.*')->where('id', '=', $ultimoIDRenglon)->where('id_asiento', '=', $id)->get();
            while (count($ultimoRenglon) == 0) {
                $ultimoIDRenglon--;
                $ultimoRenglon = Renglon::on('mysql4')->select('renglones.*')->where('id', '=', $ultimoIDRenglon)->where('id_asiento', '=', $id)->get();
            }
            $ultimoRenglon = $ultimoRenglon[0];
        }
        return view('asientos/renglones')->with('asiento', $asiento)->with('renglones', $renglones)->with('sucursales', $sucursales)->with('secciones', $secciones)->with('cuentas', $cuentas)->with('empresa', $empresa[0]->nombrepila)->with('datosempresa', $datosempresa[0])->with('ultimoRenglon', $ultimoRenglon);
    }

    public function altaRenglonesPostTabla()
    {
        $input = filter_input_array(INPUT_POST);
        echo $input;
    }

    public function deleteRenglon(Request $request, $id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        Renglon::on('mysql4')->where('renglones.id_asiento', '=', $request->id_asiento)->where('renglones.id', '=', $id)->delete();
        Asiento::on('mysql4')->where('asientos.id', '=', $request->id_asiento)->update([
            'proximo_id_renglon' => $id
        ]);
        return back()->with('success', 'Renglon eliminado con éxito');
    }


    public function editRenglonesPost(Request $request)
    {
        if ($request->ajax()) {
            $conexion = Conexion::find(1);
            DatabaseConnection::setConnection($conexion->nombre);

            $idrenglon = substr($request->pk, 0, strpos($request->pk, "-"));
            $idasiento = substr($request->pk, strpos($request->pk, "-") + 1);
            try {
                $renglon = Renglon::on('mysql4')->select('renglones.*')->where('renglones.id', '=', $idrenglon)->where('renglones.id_asiento', '=', $idasiento)->update([
                    $request->name => $request->value
                ]);
                return response()->json(['success' => true]);
            } catch (\Illuminate\Database\QueryException $ex) {
                return response()->json(['success' => false]);
                //   return back()->with('mensajeError', 'Incorrecta modificación del campo "' . $request->name . '"');
            }
        }
    }


    private function validarRequestRenglon(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $this->validate($request, [
            'id_codigo' => 'required',
            'fecha_vencimiento' => 'required',
            'fecha_oper' => 'required',
            'comprobante' => 'required',
            'id_sucursal' => 'required',
            'id_seccion' => 'required',
            'debe_haber' => 'required',
            'importe' => 'required',
            'leyenda' => 'required',

        ]);
    }

    public function altaRenglonesPost(Request $request)
    {

        self::validarRequestRenglon($request);

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);
        $asiento = Asiento::on('mysql4')->find($request->id_asiento);
        $asiento->proximo_id_renglon = $asiento->proximo_id_renglon + 1;
        $asiento->save();

        // echo date('Y-m-d', strtotime($request->fecha_vencimiento));
        $renglon = Renglon::on('mysql4')->create(array(
            'id' => $request->id,
            'id_asiento' => $request->id_asiento,
            'id_cuenta' => $request->id_codigo,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'fecha_oper' => $request->fecha_oper,
            'comprobante' => $request->comprobante,
            'id_sucursal' => $request->id_sucursal,
            'id_seccion' => $request->id_seccion,
            'debe_haber' => $request->debe_haber,
            'importe' => $request->importe,
            'leyenda' => $request->leyenda,
        ));



        $ruta = 'renglones/' . $request->id_asiento;
        return redirect($ruta);
    }

    // public function exportPdf()
    // {
    //     $conexion = Conexion::find(1);
    //     DatabaseConnection::setConnection($conexion->nombre);
    //     $sucursales = Sucursal::on('mysql4')->select('sucursales.*')->get();
    //     $secciones = Seccion::on('mysql4')->select('secciones.*')->get();
    //     $asientos = Asiento::on('mysql4')->select('asientos.id', 'asientos.fecha', 'asientos.tipo_asiento', 'asientos.ok_carga', 'asientos.registrado')
    //         ->orderBy('asientos.id')
    //         ->get();
    //      $cuentas = planCuenta::on('mysql4')->select('plancuentas.*')->where('imp', '=', 'Sí')->get();
    //     $renglones = Renglon::on('mysql4')->select('renglones.*','plancuentas.nombre As NombreCuenta', 'plancuentas.codigo As CodigoCuenta','sucursales.denominacion As sucursal','secciones.denominacion As seccion')
    //          ->join('plancuentas', 'plancuentas.id', '=', 'renglones.id_cuenta')
    //         ->join('sucursales', 'sucursales.id', '=', 'renglones.id_sucursal')
    //          ->join('secciones', 'secciones.id', '=', 'renglones.id_seccion')
    //         ->orderBy('renglones.id')->get();

    //     $empresa = Empresa::where('nombre', '=', $conexion->nombre)->get();
    //     $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();
    //     $pdf =  PDF::loadView('pdf.asientospdf', compact('asientos', 'sucursales','secciones', 'cuentas', 'renglones', 'empresa', 'datosempresa'));
    //     return $pdf->stream('asientos-list.pdf');
    // }

    public function exportPdfHorizontal()
    {

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);
        $sucursales = Sucursal::on('mysql4')->select('sucursales.*')->get();
        $secciones = Seccion::on('mysql4')->select('secciones.*')->get();
        $asientos = Asiento::on('mysql4')->select('asientos.id', 'asientos.fecha', 'asientos.tipo_asiento', 'asientos.ok_carga', 'asientos.registrado')
            ->orderBy('asientos.id')->orderBy('asientos.fecha')->orderBy('asientos.tipo_asiento')
            ->get();
        $cuentas = planCuenta::on('mysql4')->select('plancuentas.*')->where('imp', '=', 'Sí')->get();
        $renglones = Renglon::on('mysql4')->select('renglones.*', 'plancuentas.nombre As NombreCuenta', 'plancuentas.codigo As CodigoCuenta', 'sucursales.denominacion As sucursal', 'secciones.denominacion As seccion')
            ->join('plancuentas', 'plancuentas.id', '=', 'renglones.id_cuenta')
            ->join('sucursales', 'sucursales.id', '=', 'renglones.id_sucursal')
            ->join('secciones', 'secciones.id', '=', 'renglones.id_seccion')
            ->orderBy('renglones.id')
            ->orderBy('renglones.debe_haber')->get();

        $empresa = Empresa::where('nombre', '=', $conexion->nombre)->get();
        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();
        $pdf =  PDF::loadView('pdf.asientospdf', compact('asientos', 'sucursales', 'secciones', 'cuentas', 'renglones', 'empresa', 'datosempresa'));
        return $pdf->setPaper('a4', 'landscape')->stream('asientosH-list.pdf');
    }

    public function exportPdfDH(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $fechadesde = $request->fecha_desde;
        $fechahasta = $request->fecha_hasta;
        $asientos = Asiento::on('mysql4')->select('asientos.id', 'asientos.fecha', 'asientos.tipo_asiento', 'asientos.ok_carga', 'asientos.registrado')
            ->where('asientos.fecha', '>=', $request->fecha_desde)
            ->where('asientos.fecha', '<=', $request->fecha_hasta)
            ->orderBy('asientos.id')
            ->get();
        $cuentas = planCuenta::on('mysql4')->select('plancuentas.*')->where('imp', '=', 'Sí')->get();
        $renglones = Renglon::on('mysql4')->select('renglones.*', 'plancuentas.nombre As NombreCuenta', 'plancuentas.codigo As CodigoCuenta', 'sucursales.denominacion As sucursal', 'secciones.denominacion As seccion')
            ->join('plancuentas', 'plancuentas.id', '=', 'renglones.id_cuenta')
            ->join('sucursales', 'sucursales.id', '=', 'renglones.id_sucursal')
            ->join('secciones', 'secciones.id', '=', 'renglones.id_seccion')
            ->orderBy('renglones.id')->get();

        $empresa = Empresa::where('nombre', '=', $conexion->nombre)->get();
        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();
        $pdf =  PDF::loadView('pdf.asientospdfdh', compact('asientos',  'cuentas', 'renglones', 'empresa', 'datosempresa', 'fechadesde', 'fechahasta'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('asientosH-list.pdf');
    }




    public function verAsientos()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $asientos = Asiento::on('mysql4')->select('asientos.id', 'asientos.fecha', 'asientos.tipo_asiento', 'asientos.ok_carga', 'asientos.registrado')
            ->orderBy('asientos.id')->orderBy('asientos.fecha')->orderBy('asientos.tipo_asiento')
            ->get();
        return view('asientos/verAsientos')->with('asientos', $asientos);
    }

    //DIARIO MAYOR

    public function viewDiarioMayor()
    {


        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $asientosDiario_Mayor = AsientoDIARIO_MAYOR::on('mysql4')->select('asientosDiario_Mayor.*')
        ->orderBy('asientosDiario_Mayor.id')
        ->orderBy('asientosDiario_Mayor.fecha')
        ->orderBy('asientosDiario_Mayor.tipo_asiento')
        ->get();

        $RenglonesDiario_Mayor = RenglonDIARIO_MAYOR::on('mysql4')->select('renglonesDiario_Mayor.*', 'plancuentas.nombre As NombreCuenta', 'plancuentas.codigo As CodigoCuenta', 'sucursales.denominacion As sucursal', 'secciones.denominacion As seccion')
            ->join('plancuentas', 'plancuentas.id', '=', 'renglonesDiario_Mayor.id_cuenta')
            ->join('sucursales', 'sucursales.id', '=', 'renglonesDiario_Mayor.id_sucursal')
            ->join('secciones', 'secciones.id', '=', 'renglonesDiario_Mayor.id_seccion')
            ->orderBy('renglonesDiario_Mayor.id')
            ->orderBy('renglonesDiario_Mayor.debe_haber')
            ->get();


        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();

        return view('asientos/diariomayor')->with('asientosDiario_Mayor', $asientosDiario_Mayor)->with('RenglonesDiario_Mayor', $RenglonesDiario_Mayor)->with('datosempresa', $datosempresa[0]);
    }

    //LIBRO DIARIOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
    public function exportPdfHdiariomayor()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $asientosDiario_Mayor = AsientoDIARIO_MAYOR::on('mysql4')->select('asientosDiario_Mayor.*')
        ->orderBy('asientosDiario_Mayor.fecha')
        ->orderBy('asientosDiario_Mayor.tipo_asiento')
        ->orderBy('asientosDiario_Mayor.id')
        ->get();

        $RenglonesDiario_Mayor = RenglonDIARIO_MAYOR::on('mysql4')->select('renglonesDiario_Mayor.*', 'plancuentas.nombre As NombreCuenta', 'plancuentas.codigo As CodigoCuenta', 'sucursales.denominacion As sucursal', 'secciones.denominacion As seccion')
            ->join('plancuentas', 'plancuentas.id', '=', 'renglonesDiario_Mayor.id_cuenta')
            ->join('sucursales', 'sucursales.id', '=', 'renglonesDiario_Mayor.id_sucursal')
            ->join('secciones', 'secciones.id', '=', 'renglonesDiario_Mayor.id_seccion')
            ->orderBy('renglonesDiario_Mayor.id')
            ->orderBy('renglonesDiario_Mayor.debe_haber')
            ->get();


        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();


        $pdf =  PDF::loadView('pdf.diariomayorpdf', compact('asientosDiario_Mayor', 'RenglonesDiario_Mayor', 'datosempresa'));

        return $pdf->setPaper('a4', 'landscape')->stream('diariomayorH-list.pdf');
    }

    //LIBRO DIARIOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO DDDDDDDDDDHHHHHHHHHHH
    public function exportPdfHdiariomayorDH(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $asientosDiario_Mayor = AsientoDIARIO_MAYOR::on('mysql4')->select('asientosDiario_Mayor.*')
            ->where('asientosDiario_Mayor.fecha', '<=', $request->fecha_hasta2)
            ->orderBy('asientosDiario_Mayor.fecha')
            ->orderBy('asientosDiario_Mayor.tipo_asiento')
            ->orderBy('asientosDiario_Mayor.id')
            ->get();

        $RenglonesDiario_Mayor = RenglonDIARIO_MAYOR::on('mysql4')->select('renglonesDiario_Mayor.*', 'plancuentas.nombre As NombreCuenta', 'plancuentas.codigo As CodigoCuenta', 'sucursales.denominacion As sucursal', 'secciones.denominacion As seccion')
            ->join('plancuentas', 'plancuentas.id', '=', 'renglonesDiario_Mayor.id_cuenta')
            ->join('sucursales', 'sucursales.id', '=', 'renglonesDiario_Mayor.id_sucursal')
            ->join('secciones', 'secciones.id', '=', 'renglonesDiario_Mayor.id_seccion')
            ->orderBy('renglonesDiario_Mayor.id')
            ->orderBy('renglonesDiario_Mayor.debe_haber')
            // ->orderBy('plancuentas.codigo')
            ->get();


        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();
        $datosempresa[0]->fecha_emision_diario = $request->fecha_hasta2;
        $datosempresa[0]->save();

        if (isset($asientosDiario_Mayor)) {
            $asientosDiario_Mayor->id = 0;
            $RenglonesDiario_Mayor->id = 0;
        }

        $pdf =  PDF::loadView('pdf.diariomayorpdf', compact('asientosDiario_Mayor', 'RenglonesDiario_Mayor', 'datosempresa'));

        return $pdf->setPaper('a4', 'landscape')->stream('diariomayorH-list.pdf');
    }


    public function exportPdfmayoresdecuentas()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $cuentas = RenglonDIARIO_MAYOR::on('mysql4')->select('plancuentas.id As IdCuenta', 'plancuentas.nombre As NombreCuenta', 'plancuentas.codigo As CodigoCuenta')
            ->join('plancuentas', 'plancuentas.id', '=', 'renglonesDiario_Mayor.id_cuenta')
            ->orderBy('plancuentas.codigo')
            ->distinct()
            ->get();

        $RenglonesDiario_Mayor = RenglonDIARIO_MAYOR::on('mysql4')->select('renglonesDiario_Mayor.*', 'sucursales.denominacion As sucursal', 'secciones.denominacion As seccion')
            ->join('sucursales', 'sucursales.id', '=', 'renglonesDiario_Mayor.id_sucursal')
            ->join('secciones', 'secciones.id', '=', 'renglonesDiario_Mayor.id_seccion')
            ->join('asientosDiario_Mayor', 'asientosDiario_Mayor.id', '=', 'renglonesDiario_Mayor.id_asiento')
            ->orderBy('asientosDiario_Mayor.fecha')
            ->orderBy('asientosDiario_Mayor.tipo_asiento')
            ->orderBy('renglonesDiario_Mayor.debe_haber')
            ->orderBy('asientosDiario_Mayor.id')
            ->orderBy('renglonesDiario_Mayor.id')
            ->get();

        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();

        $fechadesde = date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa[0]->fecha_emision_diario), 'd-m-y');
        $fechahasta = date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa[0]->fecha_cierre), 'd-m-y');



        $pdf =  PDF::loadView('pdf.mayoresdecuentas', compact('cuentas', 'RenglonesDiario_Mayor', 'datosempresa', 'fechahasta', 'fechadesde'));
        return $pdf->setPaper('a4', 'landscape')->stream('mayoresdecuentas-list.pdf');
    }

    public function exportPdfdiarioDH(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $cuentas = RenglonDIARIO_MAYOR::on('mysql4')->select('plancuentas.id As IdCuenta', 'plancuentas.nombre As NombreCuenta', 'plancuentas.codigo As CodigoCuenta')
            ->join('plancuentas', 'plancuentas.id', '=', 'renglonesDiario_Mayor.id_cuenta')
            ->join('asientosDiario_Mayor', 'asientosDiario_Mayor.id', '=', 'renglonesDiario_Mayor.id_asiento')
            ->where('asientosDiario_Mayor.fecha', '>=', $request->fecha_desde)
            ->where('asientosDiario_Mayor.fecha', '<=', $request->fecha_hasta)
            ->orderBy('plancuentas.codigo')
            ->distinct()
            ->get();

        $RenglonesDiario_Mayor = RenglonDIARIO_MAYOR::on('mysql4')->select('renglonesDiario_Mayor.*', 'sucursales.denominacion As sucursal', 'secciones.denominacion As seccion')
            ->join('sucursales', 'sucursales.id', '=', 'renglonesDiario_Mayor.id_sucursal')
            ->join('secciones', 'secciones.id', '=', 'renglonesDiario_Mayor.id_seccion')
            ->join('asientosDiario_Mayor', 'asientosDiario_Mayor.id', '=', 'renglonesDiario_Mayor.id_asiento')
            ->where('asientosDiario_Mayor.fecha', '>=', $request->fecha_desde)
            ->where('asientosDiario_Mayor.fecha', '<=', $request->fecha_hasta)
            ->orderBy('asientosDiario_Mayor.fecha')
            ->orderBy('asientosDiario_Mayor.tipo_asiento')
            ->orderBy('renglonesDiario_Mayor.debe_haber')
            ->orderBy('asientosDiario_Mayor.id')
            ->orderBy('renglonesDiario_Mayor.id')
            ->get();

        foreach ($cuentas as $cuenta) {
            $RenglonesAuxDiario_Mayor = RenglonDIARIO_MAYOR::on('mysql4')->select('renglonesDiario_Mayor.*')
                ->join('asientosDiario_Mayor', 'asientosDiario_Mayor.id', '=', 'renglonesDiario_Mayor.id_asiento')
                ->where('renglonesDiario_Mayor.id_cuenta', '=', $cuenta->IdCuenta)
                ->where('asientosDiario_Mayor.fecha', '<', $request->fecha_desde)
                ->get();
            $debitosTotales = 0.00;
            $creditosTotales = 0.00;
            $saldo = 0.00;
            foreach ($RenglonesAuxDiario_Mayor as $RenglonAuxDiario_Mayor) {
                if ($RenglonAuxDiario_Mayor->debe_haber == 0) {
                    $debitosTotales += $RenglonAuxDiario_Mayor->importe;
                    $saldo  += $RenglonAuxDiario_Mayor->importe;
                } else {
                    $creditosTotales += $RenglonAuxDiario_Mayor->importe;
                    $saldo  -= $RenglonAuxDiario_Mayor->importe;
                }
            }
            if (count($RenglonesAuxDiario_Mayor) == 0) {
                $mov = "SIN MOVIMIENTOS ANTERIORIORES";
                $deb = 0.00;
                $cred = 0.00;
            } else {
                $mov = "SALDO ANTERIOR";
            }


            $datosCuenta[$cuenta->IdCuenta] = [
                "leyenda" => $mov,
                "debitos" => $debitosTotales,
                "creditos" => $creditosTotales,
                "saldo" => $saldo,
            ];
        }


        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();



        $fechadesde = date_format(date_create_from_format('Y-m-d', $request->fecha_desde), 'd-m-y');
        $fechahasta = date_format(date_create_from_format('Y-m-d', $request->fecha_hasta), 'd-m-y');
        if (isset($datosCuenta)) {
            $pdf =  PDF::loadView('pdf.mayoresdecuentas', compact('cuentas', 'RenglonesDiario_Mayor', 'datosempresa', 'fechadesde', 'fechahasta','datosCuenta'));
        }else{
            $pdf =  PDF::loadView('pdf.mayoresdecuentas', compact('cuentas', 'RenglonesDiario_Mayor', 'datosempresa', 'fechadesde', 'fechahasta'));
        }
        return $pdf->setPaper('a4', 'landscape')->stream('mayoresdecuentasdh-list.pdf');
    }
}
