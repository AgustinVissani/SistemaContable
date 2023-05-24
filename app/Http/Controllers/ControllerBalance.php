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
use App\Models\Balance;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;
use App\Models\planCuenta;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Com\Tecnick\Pdf\Font\Import;
use DB;

class ControllerBalance extends Controller
{
    public function __construct()
    {
        // Filtrar todos los métodos
        $this->middleware('auth');
        $this->middleware('rolAdminTabla');
    }

    public function listarBalance()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        DB::connection('mysql4')->select('TRUNCATE TABLE balances;');

        $cuentas = RenglonDIARIO_MAYOR::on('mysql4')->select('plancuentas.*')
            ->join('plancuentas', 'plancuentas.id', '=', 'renglonesDiario_Mayor.id_cuenta')
            ->orderBy('plancuentas.nivel', 'DESC')
            ->distinct()
            ->get();

        $countCuentas = 0;
        $countRenglones = 0;
        $debe = 0;
        $haber = 0;
        $saldoInicial = 0;
        $saldoAcumulado = 0;
        $saldoCierre = 0;

        while (count($cuentas) != $countCuentas) {              // RECORRO LAS DISTINTAS CUENTAS QUE TIENEN MOVIMIENTOS ASOCIADOS
            $renglones = RenglonDIARIO_MAYOR::on('mysql4')->select('renglonesDiario_Mayor.*', 'asientosDIARIO_MAYOR.tipo_asiento AS tipoAsiento')
                ->join('asientosDIARIO_MAYOR', 'asientosDIARIO_MAYOR.id', '=', 'renglonesDiario_Mayor.id_asiento')
                ->where('renglonesDiario_Mayor.id_cuenta', '=', $cuentas[$countCuentas]->id)
                ->orderBy('renglonesDiario_Mayor.id')
                ->get();
            while (count($renglones) != $countRenglones) {
                if ($renglones[$countRenglones]->tipoAsiento === 1) {            // ASIENTO DE APERTURA, SE SUMA A SALDO INICIAL
                    if ($renglones[$countRenglones]->debe_haber === 1) {
                        $saldoInicial -= $renglones[$countRenglones]->importe;
                    } else {
                        $saldoInicial += $renglones[$countRenglones]->importe;
                    }
                } else {                                                        // ASIENTO NORMAL O DE CIERRE (los tratamos igual), SE SUMA AL CORRESPONDIENTE DEBE O HABER
                    if ($renglones[$countRenglones]->debe_haber === 1) {
                        $haber += $renglones[$countRenglones]->importe;
                    } else {
                        $debe += $renglones[$countRenglones]->importe;
                    }
                }
                $countRenglones++;
            }
            $saldoAcumulado = $debe - $haber;
            $saldoCierre = $saldoInicial + $saldoAcumulado;
            Balance::on('mysql4')->create(array(
                'id_cuenta' => $cuentas[$countCuentas]->id,
                'codigo' => $cuentas[$countCuentas]->codigo,
                'prefijo' => $cuentas[$countCuentas]->prefijo,
                'sufijo' => $cuentas[$countCuentas]->sufijo,
                'nombre' => $cuentas[$countCuentas]->nombre,
                'nivel' => $cuentas[$countCuentas]->nivel,
                'debitos' => $debe,
                'creditos' => $haber,
                'saldo_inicial' => $saldoInicial,
                'saldo_acumulado' => $saldoAcumulado,
                'saldo_cierre' => $saldoCierre,
            ));
            $countRenglones = 0;
            $saldoAcumulado = 0;
            $saldoCierre = 0;
            $saldoInicial = 0;
            $debe = 0;
            $haber = 0;
            $countCuentas++;
        }

        $nivel = Balance::on('mysql4')->select('balances.nivel')->max('balances.nivel');


        while ($nivel > 1) {
            $balances = Balance::on('mysql4')->select('balances.*')->where('balances.nivel', '=', $nivel)->get();
            $countBalances = 0;
            while (count($balances) != $countBalances) {
                $padre = Balance::on('mysql4')->select('balances.*')->where('balances.codigo', '=', $balances[$countBalances]->prefijo)->get();
                if (count($padre) != 0) {
                    $padre[0]->debitos += $balances[$countBalances]->debitos;
                    $padre[0]->creditos += $balances[$countBalances]->creditos;
                    $padre[0]->saldo_inicial += $balances[$countBalances]->saldo_inicial;
                    $padre[0]->saldo_acumulado += $balances[$countBalances]->saldo_acumulado;
                    $padre[0]->saldo_cierre += $balances[$countBalances]->saldo_cierre;
                    $padre[0]->save();
                } else {
                    $padreNuevo = planCuenta::on('mysql4')->select('planCuentas.*')->where('planCuentas.codigo', '=', $balances[$countBalances]->prefijo)->orderby('planCuentas.codigo')->get();
                    Balance::on('mysql4')->create(array(
                        'id_cuenta' => $padreNuevo[0]->id,
                        'codigo' => $padreNuevo[0]->codigo,
                        'prefijo' => $padreNuevo[0]->prefijo,
                        'sufijo' => $padreNuevo[0]->sufijo,
                        'nombre' => $padreNuevo[0]->nombre,
                        'nivel' => $padreNuevo[0]->nivel,
                        'debitos' => $balances[$countBalances]->debitos,
                        'creditos' => $balances[$countBalances]->creditos,
                        'saldo_inicial' => $balances[$countBalances]->saldo_inicial,
                        'saldo_acumulado' => $balances[$countBalances]->saldo_acumulado,
                        'saldo_cierre' => $balances[$countBalances]->saldo_cierre,
                    ));
                }
                $countBalances++;
            }
            $nivel--;
        }
        $bal = Balance::on('mysql4')->select('balances.*')->orderby('balances.id')->get();
        return view('asientos/balances')->with('balances', $bal);
    }


    public function exportPdfbalance(Request $request)
    {


        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $balances = Balance::on('mysql4')->select('balances.*')
            ->orderby('balances.id_cuenta')
            ->orderby('balances.codigo')
            ->get();
        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();

        $fechadesde = date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa[0]->fecha_emision_diario), 'd-m-y');
        $fechahasta = date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa[0]->fecha_cierre), 'd-m-y');
        $pdf = PDF::loadView('pdf.balancepdf', compact('balances', 'datosempresa', 'fechahasta', 'fechadesde'));
        return $pdf->setPaper('a4', 'landscape')->stream('balance-list.pdf');
    }

    public function exportPdfbalanceDH(Request $request)
    {


        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        DB::connection('mysql4')->select('TRUNCATE TABLE balances;');

        $cuentas = RenglonDIARIO_MAYOR::on('mysql4')->select('plancuentas.*')
            ->join('plancuentas', 'plancuentas.id', '=', 'renglonesDiario_Mayor.id_cuenta')
            ->join('asientosDIARIO_MAYOR', 'asientosDIARIO_MAYOR.id', '=', 'renglonesDiario_Mayor.id_asiento')
            ->where('asientosDIARIO_MAYOR.fecha', '>=', $request->fecha_desde)
            ->where('asientosDIARIO_MAYOR.fecha', '<=', $request->fecha_hasta)
            ->orderBy('plancuentas.nivel', 'DESC')
            ->distinct()
            ->get();

        $countCuentas = 0;
        $countRenglones = 0;
        $debe = 0;
        $haber = 0;
        $saldoInicial = 0;
        $saldoAcumulado = 0;
        $saldoCierre = 0;

        while (count($cuentas) != $countCuentas) {              // RECORRO LAS DISTINTAS CUENTAS QUE TIENEN MOVIMIENTOS ASOCIADOS
            $renglones = RenglonDIARIO_MAYOR::on('mysql4')->select('renglonesDiario_Mayor.*', 'asientosDIARIO_MAYOR.tipo_asiento AS tipoAsiento')
                ->join('asientosDIARIO_MAYOR', 'asientosDIARIO_MAYOR.id', '=', 'renglonesDiario_Mayor.id_asiento')
                ->where('renglonesDiario_Mayor.id_cuenta', '=', $cuentas[$countCuentas]->id)
                ->where('asientosDIARIO_MAYOR.fecha', '>=', $request->fecha_desde)
                ->where('asientosDIARIO_MAYOR.fecha', '<=', $request->fecha_hasta)
                ->orderBy('renglonesDiario_Mayor.id')
                ->get();
            while (count($renglones) != $countRenglones) {
                if ($renglones[$countRenglones]->tipoAsiento === 1) {            // ASIENTO DE APERTURA, SE SUMA A SALDO INICIAL
                    if ($renglones[$countRenglones]->debe_haber === 1) {
                        $saldoInicial -= $renglones[$countRenglones]->importe;
                    } else {
                        $saldoInicial += $renglones[$countRenglones]->importe;
                    }
                } else {                                                        // ASIENTO NORMAL O DE CIERRE (los tratamos igual), SE SUMA AL CORRESPONDIENTE DEBE O HABER
                    if ($renglones[$countRenglones]->debe_haber === 1) {
                        $haber += $renglones[$countRenglones]->importe;
                    } else {
                        $debe += $renglones[$countRenglones]->importe;
                    }
                }
                $countRenglones++;
            }
            $saldoAcumulado = $debe - $haber;
            $saldoCierre = $saldoInicial + $saldoAcumulado;
            Balance::on('mysql4')->create(array(
                'id_cuenta' => $cuentas[$countCuentas]->id,
                'codigo' => $cuentas[$countCuentas]->codigo,
                'prefijo' => $cuentas[$countCuentas]->prefijo,
                'sufijo' => $cuentas[$countCuentas]->sufijo,
                'nombre' => $cuentas[$countCuentas]->nombre,
                'nivel' => $cuentas[$countCuentas]->nivel,
                'debitos' => $debe,
                'creditos' => $haber,
                'saldo_inicial' => $saldoInicial,
                'saldo_acumulado' => $saldoAcumulado,
                'saldo_cierre' => $saldoCierre,
            ));
            $countRenglones = 0;
            $saldoAcumulado = 0;
            $saldoCierre = 0;
            $saldoInicial = 0;
            $debe = 0;
            $haber = 0;
            $countCuentas++;
        }

        $nivel = Balance::on('mysql4')->select('balances.nivel')->max('balances.nivel');


        while ($nivel > 1) {
            $balances = Balance::on('mysql4')->select('balances.*')->where('balances.nivel', '=', $nivel)->get();
            $countBalances = 0;
            while (count($balances) != $countBalances) {
                $padre = Balance::on('mysql4')->select('balances.*')->where('balances.codigo', '=', $balances[$countBalances]->prefijo)->get();
                if (count($padre) != 0) {
                    $padre[0]->debitos += $balances[$countBalances]->debitos;
                    $padre[0]->creditos += $balances[$countBalances]->creditos;
                    $padre[0]->saldo_inicial += $balances[$countBalances]->saldo_inicial;
                    $padre[0]->saldo_acumulado += $balances[$countBalances]->saldo_acumulado;
                    $padre[0]->saldo_cierre += $balances[$countBalances]->saldo_cierre;
                    $padre[0]->save();
                } else {
                    $padreNuevo = planCuenta::on('mysql4')->select('planCuentas.*')->where('planCuentas.codigo', '=', $balances[$countBalances]->prefijo)->orderby('planCuentas.codigo')->get();
                    Balance::on('mysql4')->create(array(
                        'id_cuenta' => $padreNuevo[0]->id,
                        'codigo' => $padreNuevo[0]->codigo,
                        'prefijo' => $padreNuevo[0]->prefijo,
                        'sufijo' => $padreNuevo[0]->sufijo,
                        'nombre' => $padreNuevo[0]->nombre,
                        'nivel' => $padreNuevo[0]->nivel,
                        'debitos' => $balances[$countBalances]->debitos,
                        'creditos' => $balances[$countBalances]->creditos,
                        'saldo_inicial' => $balances[$countBalances]->saldo_inicial,
                        'saldo_acumulado' => $balances[$countBalances]->saldo_acumulado,
                        'saldo_cierre' => $balances[$countBalances]->saldo_cierre,
                    ));
                }
                $countBalances++;
            }
            $nivel--;
        }

        $balances = Balance::on('mysql4')->select('balances.*')
            ->orderby('balances.id_cuenta')
            ->orderby('balances.codigo')
            ->get();

        $fechadesde = date_format(date_create_from_format('Y-m-d', $request->fecha_desde), 'd-m-y');
        $fechahasta = date_format(date_create_from_format('Y-m-d', $request->fecha_hasta), 'd-m-y');
        $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();
        $pdf = PDF::loadView('pdf.balancepdf', compact('cuentas', 'balances', 'datosempresa', 'fechahasta', 'fechadesde'));
        return $pdf->setPaper('a4', 'landscape')->stream('balance-list.pdf');
    }
}
