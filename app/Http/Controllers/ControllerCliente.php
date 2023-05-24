<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\Sexo;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClienteExport;
use Illuminate\Support\Facades\Clientes;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;
use Config;



class ControllerCliente extends Controller
{

    public function __construct()
    {
        // Filtrar todos los métodos
        $this->middleware('auth');
        $this->middleware('rolAdminTabla');
    }


    public function viewClientes()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);
        $clientes = Cliente::on('mysql4')->select('clientes.id', 'clientes.nombre', 'clientes.apellido', 'clientes.dni', 'provincias.descripcion')
            ->join('provincias', 'provincias.id', '=', 'clientes.id_provincia')->orderBy('clientes.apellido')
            ->get();
        return view('clientes/clientes')->with('clientes', $clientes);
    }



    public function verCliente($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);
        $cliente = Cliente::on('mysql4')->find($id);
        $sexo = Sexo::on('mysql4')->select('tipo')->where('id', '=', $cliente->sexo)->get();
        $provincia = Provincia::on('mysql4')->select('descripcion')->where('id', '=', $cliente->id_provincia)->get();
        return view('clientes/verCliente')->with('sexo', $sexo[0]->tipo)->with('provincia', $provincia[0]->descripcion)->with('cliente', $cliente);
    }

    public function altaCliente()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();
        $sexos = Sexo::on('mysql4')->orderBy('tipo')->get();
        return view('clientes/altaCliente')->with('provincias', $provincias)->with('sexos', $sexos);
    }



    private function validarRequest(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|unique:mysql4.clientes',
            'mail' => 'required|unique:mysql4.clientes',
            'telefono' => 'required',
            'direccion' => 'required',
            'sexo' => 'required',
            'id_provincia' => 'required',
        ]);
    }


    private function validarEditRequest(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'mail' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'sexo' => 'required',
            'id_provincia' => 'required',
        ]);
    }

    public function altaClientePost(Request $request)
    {
        self::validarRequest($request);

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        try {
            $cliente = Cliente::on('mysql4')->create(array(
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'dni' => $request->dni,
                'mail' => $request->mail,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'sexo' => $request->sexo,
                'id_provincia' => $request->id_provincia,
            ));
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensaje', 'Ya existe un cliente con el dni "' . $request->dni . '"');
        }


        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();
        return redirect('altaCliente')->with('success', 'Cliente agregado con éxito, su id asignado es: ' . $cliente->id .'" y nombre"' . $cliente->nombre . '"');
    }

    public function editCliente($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $cliente = Cliente::on('mysql4')->find($id);
        $sexos = Sexo::on('mysql4')->orderBy('tipo')->get();
        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();
        return view('clientes/editCliente')->with('provincias', $provincias)->with('cliente', $cliente)->with('sexos', $sexos);
    }



    public function editClientePost(Request $request, $id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        self::validarEditRequest($request);
        try {
            $cliente = Cliente::on('mysql4')->find($id);
            $cliente->nombre = $request->nombre;
            $cliente->apellido = $request->apellido;
            $cliente->dni = $request->dni;
            $cliente->mail = $request->mail;
            $cliente->direccion = $request->direccion;
            $cliente->telefono = $request->telefono;
            $cliente->id_provincia = $request->id_provincia;
            $cliente->sexo = $request->sexo;
            $cliente->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensaje', 'Ya existe un cliente con el dni "' . $request->dni . '"');
        }

        $clientes = Cliente::on('mysql4')->select('clientes.id', 'clientes.nombre', 'clientes.apellido', 'clientes.dni', 'provincias.descripcion')
            ->join('provincias', 'provincias.id', '=', 'clientes.id_provincia')->orderBy('clientes.apellido')
            ->get();
        return redirect('clientes')->with('clientes', $clientes)->with('success', 'Cliente editado con éxito');
    }


    public function deleteCliente($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $cliente = Cliente::on('mysql4')->find($id);
        $cliente->delete();
        $clientes = Cliente::on('mysql4')->orderBy('apellido')->get();
        return redirect('clientes')->with('clientes', $clientes)->with('success', 'Cliente eliminado con éxito');
     }


    public function exportPdf()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $clientes = Cliente::on('mysql4')->select('clientes.id', 'clientes.nombre', 'clientes.apellido', 'clientes.dni', 'clientes.mail', 'clientes.direccion', 'clientes.telefono', 'clientes.sexo AS id_sexo', 'sexos.tipo As sexo', 'clientes.id_provincia', 'provincias.descripcion As provincia',)
            ->join('provincias', 'provincias.id', '=', 'clientes.id_provincia')
            ->join('sexos', 'sexos.id', '=', 'clientes.sexo')
            ->orderBy('clientes.id')
            ->get();
        $pdf = PDF::loadView('pdf.clientespdf', compact('clientes'));
        return $pdf->setPaper('a4','landscape')->stream('clientes-list.pdf');
    }


    public function exportxlsx()
    {
        return Excel::download(new ClienteExport, 'clientes-list.xlsx');
    }


    public function verClientes()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $clientes = Cliente::on('mysql4')->select('clientes.id', 'clientes.nombre', 'clientes.apellido', 'clientes.dni', 'clientes.mail', 'clientes.direccion', 'clientes.telefono', 'clientes.sexo AS id_sexo', 'sexos.tipo As sexo', 'clientes.id_provincia', 'provincias.descripcion As provincia',)
            ->join('provincias', 'provincias.id', '=', 'clientes.id_provincia')
            ->join('sexos', 'sexos.id', '=', 'clientes.sexo')
            ->orderBy('clientes.id')->get();
        return view('clientes/verClientes')->with('clientes', $clientes);
    }


    // SEXOS

    public function editSexoPost(Request $request, $id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $sexos = Sexo::on('mysql4')->find($id);
        $sexos->tipo = $request->tipo;
        $sexos->save();

        $sexos = Sexo::on('mysql4')->select('sexos.id', 'sexos.tipo')
            ->get();
        return redirect('sexos')->with('sexos', $sexos)->with('success', 'Género editado con éxito');
    }


    public function altaSexo()
    {
        return view('clientes/altaSexo');
    }


    public function editSexo($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $sexos = Sexo::on('mysql4')->find($id);
        return view('clientes/editSexo')->with('sexo', $sexos);
    }


    public function viewSexos()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $sexos = Sexo::on('mysql4')->select('sexos.id', 'sexos.tipo')
            ->get();
        return view('clientes/sexos')->with('sexos', $sexos);
    }


    public function deleteSexo($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        try {

            $sexos = Sexo::on('mysql4')->find($id);
            $sexos->delete();
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensajeError', 'No se puede eliminar el Género ' . $sexos->tipo . ', tiene clientes asociados');
        }

        $sexos = Sexo::on('mysql4')->orderBy('id')->get();
        return redirect('sexos')->with('sexos', $sexos)->with('success', 'Género eliminado con éxito');
    }


    public function altaSexoPost(Request $request)
    {

        try {
            $conexion = Conexion::find(1);
            DatabaseConnection::setConnection($conexion->nombre);

            $sexos = Sexo::on('mysql4')->create([
                'tipo' => $request->tipo,
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensaje', 'Ya existe un género con ese nombre "' . $request->tipo . '"');
        }
        return redirect('altaSexo')->with('success', 'Género agregado con éxito, su id asignado es: ' . $sexos->id);
    }
}
