<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\Sexo;
use App\Models\Audits;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AuditExport;
use App\Helpers\DatabaseConnection;
use App\Models\Conexion;


class ControllerAudit extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // Filtrar todos los métodos
        $this->middleware('auth');
        $this->middleware('rolAudit');
    }

    public function verAudit()
    {

        $conexion = Conexion::find(1);
        $audits = Audits::on('mysqlempresas')->select('audits.*','users.name As nombreUsuario')
        ->where('audits.empresa','=',$conexion->nombre)
        ->join('users', 'users.id', '=', 'audits.user_id')
        ->orderBy('audits.id','DESC')
        ->get();
        return view('audit/audit')->with('audits', $audits);
    }

    public function verAuditCompleta()
    {
        $conexion = Conexion::find(1);
        $audits = Audits::on('mysqlempresas')->select('audits.*')->where('audits.empresa','=',$conexion->nombre)->get();
        return view('audit/auditCompleta',compact('audits'))->with('audits', $audits);
    }

    // public function valorNuevo($id)
    // {
    //     $audit = Audits::where('audits.id', '=',$id)->get();
    //     // ->join('users', 'users.id', '=', 'audits.user_id')->get();
    //     // echo($audits[0]->old_values[0]);

    //     return view('audit/valorNuevo')->with('audit', $audit[0]->new_values);
    // }


    public function valor($id)
    {

        $conexion = Conexion::find(1);

        $audit = Audits::on('mysqlempresas')->where('audits.id', '=',$id)
         ->join('users', 'users.id', '=', 'audits.user_id')->get();

        $user = User::on('mysqlempresas')->find($audit[0]->user_id);

        return view('audit/valor')->with('audit', $audit[0])->with( 'nombreUsuario', $user->name)->with('oldValues', $audit[0]->old_values)->with( 'newValues', $audit[0]->new_values);
    }

    public function exportPdf()
    {

        $conexion = Conexion::find(1);
        $audits = Audits::on('mysqlempresas')->select('audits.*','users.name As nombreUsuario')
        ->where('audits.empresa','=',$conexion->nombre)
        ->join('users', 'users.id', '=', 'audits.user_id')
        ->orderBy('audits.id','DESC')
        ->get();
        $pdf = PDF::loadView('pdf.auditpdf', compact('audits'));
        $pdf->setPaper('a4','landscape');
        return $pdf->stream('audit-list.pdf');
    }


    public function exportxlsx()
    {
        return Excel::download(new AuditExport, 'audit-list.xlsx');
    }




}
