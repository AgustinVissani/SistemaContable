<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inicio;
use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\Sexo;
use App\Models\Empresa;
use App\Models\Seccion;
use App\Models\Sucursal;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent;
use App\Http\Controllers\ControllerProvincia;
use DB;
use Config;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\DatabaseConnection;
use App\Models\Conexion;
use App\Models\datosEmpresa;
use Illuminate\Support\Facades\Auth;

class ControllerInicio extends Controller
{


    public function __construct()
    {
        // Filtrar todos los métodos
        // $this->middleware('auth');
    }

    public function viewInicio()
    {
        if (!Auth::check() || (Auth::user()->id_rol != 3 && Auth::user()->id_rol != 1 && Auth::user()->id_rol != 2 && Auth::user()->id_rol != 4)) {
            $empresas = Empresa::all()->where('id', '<>', 1);
            return view('inicio/inicio')->with('empresas', $empresas);
        } else {
            $conexion = Conexion::find(1);
            DatabaseConnection::setConnection($conexion->nombre);
            $empresa = Empresa::where('nombre', '=', $conexion->nombre)->get();
            $datosempresa = datosEmpresa::on('mysql4')->select('datosempresa.*')->get();

            return view('inicio/inicioHome')->with('empresa', $empresa[0]->nombrepila)->with('datosempresa', $datosempresa[0]);
        }
    }

    public function seleccionEmpresaPost(Request $request)
    {
        $empresa = $request->nombreEmpresa;

        $conexion = Conexion::find(1);
        $conexion->nombre = $empresa;
        $conexion->save();

        return redirect('login');
    }

    // EMPRESAS

    private function validarRequest(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
        ]);
    }

    private function validarEditRequest(Request $request)
    {
        $this->validate($request, [
            'nombrepila' => 'required',
        ]);
    }
    public function editEmpresaPost(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:empresa,nombre,' . $id,
        ]);
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $empresa = Empresa::find($id);
        $empresa_old = $empresa->nombre;
        $empresa->nombre = $request->nombre;
        $empresa->save();
        DB::connection('mysql')->select('CREATE DATABASE ' . $request->nombre);
        DB::connection('mysql')->select('mysql -u root -p ' . $empresa_old . ' > ' . $request->nombre . '.sql');
        DB::connection('mysql')->select('DROP DATABASE IF EXISTS ' . $empresa_old);

        return redirect('empresas')->with('empresa', $empresa)->with('success', 'Empresa editada con éxito');
    }

    public function editdatosEmpresaPost(Request $request, $id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);


        self::validarEditRequest($request);
        try {
            $datosempresa = datosEmpresa::on('mysql4')->find($id);
            $datosempresa->nombrepila = $request->nombrepila;
            $datosempresa->id_provincia = $request->id_provincia;
            $datosempresa->cp = $request->cp;
            $datosempresa->id_localidad = $request->id_localidad;
            $datosempresa->calle = $request->calle;
            $datosempresa->numero = $request->numero;
            $datosempresa->piso = $request->piso;
            $datosempresa->tipo_responsable = $request->tipo_responsable;
            $datosempresa->cuit = $request->cuit;
            $datosempresa->fecha_emision_diario = $request->fecha_emision_diario;
            $datosempresa->fecha_apertura = $request->fecha_apertura;
            $datosempresa->fecha_cierre = $request->fecha_cierre;

            $datosempresa->save();

            echo $empresa = Empresa::select('empresa.*')->where('empresa.nombre', '=', $conexion->nombre)->get();
            $empresa[0]->nombrepila = $request->nombrepila;
            $empresa[0]->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensaje', 'Ya existe una empresa con ese nombre "' . $request->nombrepila . '"');
        }

        return redirect('inicio')->with('success', 'Datos de la empresa editados con éxito');
    }

    public function altaEmpresa()
    {

        // $conexion = Conexion::find(1);
        // DatabaseConnection::setConnection($conexion->nombre);
        // $sucursal = Sucursal::on('mysql4')->get();
        // $seccion = Seccion::on('mysql4')->get();
        // ->with('sucursal', $sucursal)->with('seccion', $seccion)

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();
        return view('inicio/altaEmpresa')->with('provincias', $provincias);
    }


    public function editEmpresa($id)
    {
        $empresa = Empresa::find($id);
        return view('inicio/editEmpresa')->with('empresa', $empresa);
    }

    public function editdatosEmpresa($id)
    {

        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);
        $provincias = Provincia::on('mysql4')->orderBy('descripcion')->get();

        $datosempresa = datosEmpresa::on('mysql4')->find($id);

        return view('inicio/editEmpresa')->with('empresa', $datosempresa)->with('provincias', $provincias);
    }


    public function viewEmpresas()
    {
        $empresas = Empresa::orderBy('nombre')->where('id', '<>', 1)->get();
        return view('inicio/empresas')->with('empresas', $empresas);
    }


    public function deleteEmpresa($id)
    {

        try {
            $empresa = Empresa::find($id);
            $nombre = $empresa->nombre;
            $conexion = Conexion::find(1);
            if (strcmp($nombre, $conexion->nombre) === 0) {
                return back()->with('mensajeError', 'No se puede eliminar la empresa ' . $nombre . ' conectada actualmente');
            } else {
                $empresa->delete();
                $conexion = Conexion::find(1);
                $conexion->nombre = 'empresas';
                $conexion->save();
            }
            DB::connection('mysqlempresas')->select('DROP DATABASE IF EXISTS ' . $nombre);
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensajeError', 'No se puede eliminar la empresa ' . $nombre);
        }

        $empresa = Empresa::orderBy('nombre')->get();
        return redirect('empresas')->with('empresa', $empresa)->with('success', 'Empresa eliminada con éxito');
    }




    public function altaEmpresaPost(Request $request)
    {
        self::validarRequest($request);

        //   try {
        $empresa = Empresa::create([
            'nombrepila' => $request->nombre,
        ]);
        $empresa->nombre = 'empresa' . $empresa->id;
        $empresa->save();

        $conexion = Conexion::find(1);
        $conexion->nombre = $empresa->nombre;
        $conexion->save();

        DB::connection('mysqlempresas')->select('CREATE DATABASE ' . $empresa->nombre);

        config(['database.connections.mysql3' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $empresa->nombre,
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'dump' => [
                'dump_binary_path' => 'E:\\xampp\\mysql\\bin',
                'use_single_transaction',
                'timeout' => 60 * 5, // 5 minute timeout
            ],
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ]]);

        $provincias = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\provincias.sql');
        DB::connection('mysql3')->select($provincias);

        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Ciudad Autónoma de Buenos Aires");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Buenos Aires");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Catamarca");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Córdoba");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Corrientes");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Entre Ríos");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Jujuy");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Mendoza");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("La Rioja");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Salta");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("San Juan");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("San Luis");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Santa Fe");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Santiago del Estero");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Tucumán");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Chaco");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Chubut");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Formosa");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Misiones");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Neuquén");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("La Pampa");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Río Negro");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Santa Cruz");');
        DB::connection('mysql3')->select('INSERT INTO provincias (descripcion) VALUES ("Tierra del Fuego");');

        $sexos = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\sexos.sql');
        DB::connection('mysql3')->select($sexos);

        DB::connection('mysql3')->select('INSERT INTO sexos (tipo) VALUES ("Femenino");');
        DB::connection('mysql3')->select('INSERT INTO sexos (tipo) VALUES ("Masculino");');
        DB::connection('mysql3')->select('INSERT INTO sexos (tipo) VALUES ("Prefiero no decirlo");');

        $clientes = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\clientes.sql');
        DB::connection('mysql3')->select($clientes);

        $roles = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\roles.sql');
        DB::connection('mysql3')->select($roles);

        DB::connection('mysql3')->select('INSERT INTO roles (descripcion) VALUES ("Admin del Sistema");');
        DB::connection('mysql3')->select('INSERT INTO roles (descripcion) VALUES ("Supervisor de usuarios");');
        DB::connection('mysql3')->select('INSERT INTO roles (descripcion) VALUES ("Administrador de tablas");');
        DB::connection('mysql3')->select('INSERT INTO roles (descripcion) VALUES ("Auditor");');

        $usuarios = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\usuarios.sql');
        DB::connection('mysql3')->select($usuarios);
        DB::connection('mysql3')->select('INSERT INTO users (name, id_rol, email, password) VALUES ("Agustín", 1, "vissani1997@gmail.com","' . bcrypt('39982025') . '");');
        DB::connection('mysql3')->select('INSERT INTO users (name, id_rol, email, password) VALUES ("Supervisor", 2, "supervisor@gmail.com", "' . bcrypt('supervisor') . '");');
        DB::connection('mysql3')->select('INSERT INTO users (name, id_rol, email, password) VALUES ("Administrador de tablas", 3, "administrador@gmail.com", "' . bcrypt('administrador') . '");');
        DB::connection('mysql3')->select('INSERT INTO users (name, id_rol, email, password) VALUES ("Auditor", 4, "auditor@gmail.com", "' . bcrypt('auditor') . '");');

        DB::connection('mysqlempresas')->select('INSERT INTO users (name, id_rol, email, empresa, password) VALUES ("Agustín", 1, "vissani1997@gmail.com","' . $empresa->nombre . '" ,"' . bcrypt('39982025') . '");');
        DB::connection('mysqlempresas')->select('INSERT INTO users (name, id_rol, email, empresa, password) VALUES ("Supervisor", 2, "supervisor@gmail.com", "' . $empresa->nombre . '" ,"' . bcrypt('supervisor') . '");');
        DB::connection('mysqlempresas')->select('INSERT INTO users (name, id_rol, email, empresa, password) VALUES ("Administrador de tablas", 3, "administrador@gmail.com", "' . $empresa->nombre . '" ,"' . bcrypt('administrador') . '");');
        DB::connection('mysqlempresas')->select('INSERT INTO users (name, id_rol, email, empresa, password) VALUES ("Auditor", 4, "auditor@gmail.com", "' . $empresa->nombre . '" ,"' . bcrypt('auditor') . '");');

        $plancuentas = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\plancuentas.sql');
        DB::connection('mysql3')->select($plancuentas);
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("","", "","AGREGAR EN NIVEL 1","No",1);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1","1", "","ACTIVO","No",1);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01","1", ".01","ACTIVO CORRIENTE","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.01","1.01", ".01","DISPONIBILIDADES","No",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.01.01","1.01.01", ".01","Caja","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.01.02","1.01.01", ".02","BANCOS","No",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.01.02.01","1.01.01.02", ".01","Banco provincia c.c.","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.01.02.02","1.01.01.02", ".02","Banco nación c. de ahorro","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.01.02.03","1.01.01.02", ".03","Banco nación cuenta corriente","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.01.03","1.01.01", ".03","Valores a Depositar","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.02","1.01", ".02","CUENTAS POR COBRAR","No",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.02.01","1.01.02", ".01","Deudores en c.c.","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.02.02","1.01.02", ".02","Documentos a cobrar","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.02.03","1.01.02", ".03","Iva crédito fiscal","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.02.04","1.01.02", ".04","AFIP-IVA a favor","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.02.05","1.01.02", ".05","CLIENTES-CUENTAS CORRIENTES","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.03","1.01", ".03","BIENES DE CAMBIO","No",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.03.01","1.01.03", ".01","Mercaderías","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.04","1.01", ".04","INVERSIONES","No",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.05","1.01", ".05","OTROS CRÉDITOS","No",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.05.01","1.01.05", ".01","Socio 1 cuenta particular","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.01.05.02","1.01.05", ".02","Socio 2 cuenta particular","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.02","1", ".02","ACTIVO NO CORRIENTE","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.02.01","1.02", ".01","BIENES DE USO","No",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.02.01.01","1.02.01", ".01","Rodados","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("1.02.01.02","1.02.01", ".02","Muebles y útiles","Sí",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2","2", "","PASIVO","No",1);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01","2", ".01","PASIVO CORRIENTE","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01","2.01", ".01","DEUDAS","No",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.01","2.01.01", ".01","Deudas comerciales","No",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.01.01","2.01.01.01", ".01","Proveedores","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.01.02","2.01.01.01", ".02","Obligaciones a pagar","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.02","2.01.01", ".02","Deudas fiscales","No",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.02.01","2.01.01.02", ".01","Iva débito fiscal","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.02.02","2.01.01.02", ".02","Iva perc. no insc.","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.02.03","2.01.01.02", ".03","Ingresos brutos a pagar","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.02.04","2.01.01.02", ".04","Tasa Insp Segur e Hig a pagar","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.02.05","2.01.01.02", ".05","AFIP-IVA a pagar","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.03","2.01.01", ".03","DEUDAS LABORALES Y PREV.","No",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.03","2.01.01.03", ".01","Sueldos a pagar","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.03.02","2.01.01.03", ".02","DEUDAS POR CARGAS SOCIALES","No",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.03.03","2.01.01.03", ".03","Cargas sociales a pagar","Sí",5);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.01.01.04","2.01.01", ".04","Deudas bancarias","No",4);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("2.02","2", ".02","PASIVO NO CORRIENTE","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("3","3", "","PATRIMONIO NETO","No",1);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("3.01","3", ".01","CAPITAL","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("3.01.01","3.01", ".01","Capital social","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("3.02","3", ".02","RESERVAS","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("3.03","3", ".03","RESULTADOS ACUMULADOS","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("3.03.01","3.03", ".01","Resultados del ej. anterior","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("4","4", "","RESULTADO POSITIVO","No",1);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("4.01","4",".01","INGRESOS ORDINARIOS","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("4.01.01","4.01", ".01","Ventas","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("4.01.02","4.01", ".02","Intereses obtenidos","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("4.01.03","4.01", ".03","Descuentos obtenidos","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("4.01.04","4.01", ".04","Ingresos por serv. prestados","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("4.01.05","4.01", ".05","Ingresos por fletes","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("4.02","4", ".02","INGRESOS EXTRAORDINARIOS","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5","5", "","RESULTADO NEGATIVO","No",1);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.01","5", ".01","GASTOS DE COMERCIALIZACIÓN","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.01.01","5.01", ".01","Costo de venta","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.02","5", ".02","GASTOS ADMINISTRATIVOS","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.02.01","5.02", ".01","Impuestos nacionales","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.02.02","5.02", ".02","Agua, luz y gas","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.02.03","5.02", ".03","Teléfono","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.02.04","5.02", ".04","Alquileres Cedidos","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.02.05","5.02", ".05","Ingresos Brutos","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.02.06","5.02", ".06","Tasa por Insp. Seg. e Hig.","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.03","5", ".03","GASTOS EN PERSONAL","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.03.01","5.03", ".01","Sueldos y jornales","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.03.02","5.03", ".02","Cargas sociales","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.04","5", ".04","GASTOS FINANCIEROS","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.04.01","5.04", ".01","Intereses cedidos","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.04.02","5.04", ".02","Descuentos cedidos","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.04.03","5.04", ".03","Gastos bancarios","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.05","5", ".05","OTROS GASTOS","No",2);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.05.01","5.05", ".01","Fletes pagados","Sí",3);');
        DB::connection('mysql3')->select('INSERT INTO plancuentas (codigo, prefijo, sufijo,  nombre, imp, nivel) VALUES ("5.05.02","5.05", ".02","Conservación y mantenimiento","Sí",3);');


        $datosempresa = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\datosempresa.sql');
        DB::connection('mysql3')->select($datosempresa);
        DB::connection('mysql3')->select('INSERT INTO datosempresa (nombrepila, id_provincia, cp,  id_localidad, calle, numero, piso, tipo_responsable, cuit, fecha_emision_diario, ult_tomo, ult_folio, ult_asiento,  ult_renglon, ult_transporte,  fecha_apertura, fecha_cierre  ) VALUES ("' . $request->nombre . '","' . $request->id_provincia . '", "' . $request->cp . '", "' . $request->id_localidad . '", "' . $request->calle . '", "' . $request->numero . '", "' . $request->piso . '", "' . $request->tipo_responsable . '", "' . $request->cuit . '", "' . $request->fecha_emision_diario . '", "' . '0' . '", "' . '0' . '", "' . '0' . '", "' . '0' . '", "' . '0' . '", "' . $request->fecha_apertura . '", "' . $request->fecha_cierre . '");');


        $sucursal = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\sucursales.sql');
        DB::connection('mysql3')->select($sucursal);
        DB::connection('mysql3')->select('INSERT INTO sucursales (denominacion,id_provincia) VALUES ("Casa central",5);');



        $seccion = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\secciones.sql');
        DB::connection('mysql3')->select($seccion);
        DB::connection('mysql3')->select('INSERT INTO secciones (denominacion) VALUES ("Casa central");');



        $asiento = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\asientos.sql');
        DB::connection('mysql3')->select($asiento);

        $renglon = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\renglones.sql');
        DB::connection('mysql3')->select($renglon);

        $asientoDIARIO_MAYOR = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\asientosDIARIO_MAYOR.sql');
        DB::connection('mysql3')->select($asientoDIARIO_MAYOR);

        $renglonDIARIOS_MAYOR = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\renglonesDIARIO_MAYOR.sql');
        DB::connection('mysql3')->select($renglonDIARIOS_MAYOR);

        $balances = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\balances.sql');
        DB::connection('mysql3')->select($balances);


        $audits = file_get_contents('E:\DesarrolloWEB\mi-proyecto-laravel2\app\audits.sql');
        DB::connection('mysql3')->select($audits);


        return redirect('empresas')->with('success', 'Empresa agregada con éxito, su id asignado es: ' . $empresa->id);
        // } catch (\Illuminate\Database\QueryException $ex) {
        //      return back()->with('mensaje', 'Ya existe una base de datos con ese nombre "' . $request->nombre . '"');
        // }
    }



    // Seccion

    public function editSeccionPost(Request $request, $id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $seccion = Seccion::on('mysql4')->find($id);
        $seccion->denominacion = $request->denominacion;
        $seccion->save();

        $seccion = Seccion::on('mysql4')->select('secciones.id', 'secciones.denominacion')
            ->get();
        return redirect('secciones')->with('seccion', $seccion)->with('success', 'Sección editada con éxito');
    }


    public function altaSeccion()
    {
        return view('inicio/altaSeccion');
    }


    public function editSeccion($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $seccion = Seccion::on('mysql4')->find($id);
        return view('inicio/editSeccion')->with('seccion', $seccion);
    }


    public function viewSeccion()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $secciones = Seccion::on('mysql4')->select('secciones.*')
            ->get();
        return view('inicio/secciones')->with('secciones', $secciones);
    }


    public function deleteSeccion($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        try {

            $seccion = Seccion::on('mysql4')->find($id);
            $seccion->delete();
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensajeError', 'No se puede eliminar la sección ' . $seccion->sec_denominacion . ', tiene empresas asociadas');
        }

        $seccion = Seccion::on('mysql4')->orderBy('id')->get();
        return redirect('secciones')->with('seccion', $seccion)->with('success', 'Sección eliminada con éxito');
    }


    public function altaSeccionPost(Request $request)
    {

        try {
            $conexion = Conexion::find(1);
            DatabaseConnection::setConnection($conexion->nombre);

            $secciones = Seccion::on('mysql4')->create([
                'denominacion' => $request->denominacion,
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensaje', 'Ya existe un sección con ese nombre "' . $request->denominacion . '"');
        }
        return redirect('altaSeccion')->with('success', 'Sección agregado con éxito, su id asignado es: ' . $secciones->id);
    }



    // Sucursal

    public function editSucursalPost(Request $request, $id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $sucursal = Sucursal::on('mysql4')->find($id);
        $sucursal->denominacion = $request->denominacion;
        $sucursal->id_provincia = $request->id_provincia;
        $sucursal->cp = $request->cp;
        $sucursal->id_localidad = $request->id_localidad;
        $sucursal->calle = $request->calle;
        $sucursal->numero = $request->numero;
        $sucursal->piso = $request->piso;
        $sucursal->save();


        $sucursal = Sucursal::on('mysql4')->select('sucursales.id', 'sucursales.denominacion', 'sucursales.id_provincia', 'sucursales.cp', 'sucursales.id_localidad', 'sucursales.calle', 'sucursales.numero', 'sucursales.piso')
            ->get();
        return redirect('sucursales')->with('sucursal', $sucursal)->with('success', 'Sucursal editada con éxito');
    }


    public function altaSucursal()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $provincias = Provincia::on('mysql4')->orderBy('id')->get();
        return view('inicio/altaSucursal')->with('provincias', $provincias);
    }


    public function editSucursal($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $sucursal = Sucursal::on('mysql4')->find($id);

        $provincias = Provincia::on('mysql4')->orderBy('id')->get();
        return view('inicio/editSucursal')->with('sucursal', $sucursal)->with('provincias', $provincias);
    }


    public function viewSucursal()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $sucursales = Sucursal::on('mysql4')->select('sucursales.*')
            ->get();
        return view('inicio/sucursales')->with('sucursales', $sucursales);
    }


    public function deleteSucursal($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        try {

            $sucursal = Sucursal::on('mysql4')->find($id);
            $sucursal->delete();
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensajeError', 'No se puede eliminar la sucursal ' . $sucursal->denominacion . ', tiene empresas asociadas');
        }

        $sucursal = Sucursal::on('mysql4')->orderBy('id')->get();
        return redirect('sucursales')->with('sucursal', $sucursal)->with('success', 'Sucursal eliminada con éxito');
    }


    public function altaSucursalPost(Request $request)
    {
        // self::validarRequest($request);
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);
        try {


            $sucursal = Sucursal::on('mysql4')->create([
                'denominacion' =>  $request->denominacion,
                'id_provincia' => $request->id_provincia,
                'cp' => $request->cp,
                'id_localidad' => $request->id_localidad,
                'calle' => $request->calle,
                'numero' => $request->numero,
                'piso' => $request->piso,
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensaje', 'Ya existe una sucursal con ese nombre "' . $request->denominacion . '"');
        }

        return redirect('altaSucursal')->with('success', 'Sucursal agregada con éxito, su id asignado es: ' . $sucursal->id);
    }
}
