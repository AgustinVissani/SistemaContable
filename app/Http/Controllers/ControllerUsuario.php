<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsuarioExport;
use SebastianBergmann\Environment\Console;
use App\Models\Conexion;
use App\Helpers\DatabaseConnection;
use Config;
use DB;

class ControllerUsuario extends Controller
{
    public function __construct()
    {
        // Filtrar todos los métodos
        $this->middleware('auth');
        $this->middleware('rolSupervisor');
    }


    public function viewUsuarios()
    {
        $conexion = Conexion::find(1);

        DatabaseConnection::setConnection($conexion->nombre);

        $users = User::on('mysql4')->select('users.id', 'users.name', 'users.id_rol', 'users.email', 'roles.descripcion')
            ->join('roles', 'roles.id', '=', 'users.id_rol')
            ->get();
        return view('usuario/usuarios')->with('users', $users);
    }


    public function altaUsuario()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $roles = Rol::on('mysql4')->orderBy('descripcion')->get();
        return view('usuario/altaUsuario')->with('roles', $roles);
    }

    private function validarRequest(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'id_rol' => 'required',
            'email' => 'required|unique:mysql4.users',
            'password' => 'required',
        ]);
    }

    public function altaUsuarioPost(Request $request)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $request->validate([
            'name' => 'required|string|max:255',
            'id_rol' => 'required',
            'email' => 'required|string|email|max:255|unique:mysql4.users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::on('mysql4')->create([
            'name' => $request->name,
            'id_rol' => $request->id_rol,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $userempr = User::on('mysqlempresas')->create([
            'name' => $request->name,
            'id_rol' => $request->id_rol,
            'email' => $request->email,
            'empresa' => $conexion->nombre,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($userempr));

        // event(new Registered($user));

        $roles = Rol::on('mysql4')->orderBy('descripcion')->get();
        return redirect('altaUsuario')->with('roles', $roles)->with('success', 'Usuario agregado con éxito, su id asignado es: ' . $user->id);
    }




    public function editUsuario($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $user = User::on('mysql4')->find($id);
        $roles = Rol::on('mysql4')->orderBy('descripcion')->get();
        return view('usuario/editUsuario')->with('roles', $roles)->with('user', $user);
    }

    private function validPass(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    public function editUsuarioPost(Request $request, $id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $request->validate([
            'name' => 'required|string|max:255',
            'id_rol' => 'required',
            'email' => 'required|string|email|max:255|unique:mysql4.users,email,' . $id,
        ]);

        $user = User::on('mysql4')->find($id);
        $userAux=$user;

        $user->name = $request->name;
        $user->id_rol = $request->id_rol;
        $user->email = $request->email;
        if ($request->password != "") {
            self::validPass($request);
            $user->password = Hash::make($request->password);
        }
        $user->save();


        //$userEmpre =User::on('mysqlempresas')->where('email', '=', $userAux->email)->where('empresa','=',$conexion->nombre)->get();
        // $userEmpre =User::on('mysqlempresas')->where('email', '=', 'user@69')->where('empresa','=',$conexion->nombre)->get();
        // echo $userEmpre;
        // $userEmpre->name = $request->name;
        // $userEmpre->id_rol = $request->id_rol;
        // $userEmpre->email = $request->email;
        // if ($request->password != "") {
        //     self::validPass($request);
        //     $userEmpre->password = Hash::make($request->password);
        // }
        // $userEmpre->save();


        $users = User::on('mysql4')->select('users.id', 'users.name', 'users.id_rol', 'users.email', 'users.password', 'roles.descripcion')
            ->join('roles', 'roles.id', '=', 'users.id_rol')
            ->get();
        return redirect('usuarios')->with('user', $user)->with('success', 'Usuario editado con éxito');
    }

    public function deleteUsuario($id)
    {

        if ($id == 1) {
            return back()->with('mensajeError', 'No se puede eliminar  el usuario administrador');
        } else {
            $conexion = Conexion::find(1);
            DatabaseConnection::setConnection($conexion->nombre);

            $user = User::on('mysql4')->find($id);
            $mail=$user->email;
            $user->delete();


            User::on('mysqlempresas')->where('email', '=', $mail)->where('empresa', '=', $conexion->nombre)->delete();


            $users = User::on('mysql4')->orderBy('id')->get();
            return redirect('usuarios')->with('users', $users)->with('success', 'Usuario eliminado con éxito');
        }
    }

    public function viewRoles()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $roles = Rol::on('mysql4')->select('roles.id', 'roles.descripcion')
            ->get();
        return view('usuario/roles')->with('roles', $roles);
    }

    public function altaRoles()
    {
        return view('usuario/altaRoles');
    }

    public function altaRolPost(Request $request)
    {
        try {
            $conexion = Conexion::find(1);
            DatabaseConnection::setConnection($conexion->nombre);

            $roles = Rol::on('mysql4')->create([
                'descripcion' => $request->descripcion,
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensaje', 'Ya existe un rol con esa descripción "' . $request->descripcion . '"');
        }
        return redirect('altaRoles')->with('success', 'Rol agregado con éxito, su id asignado es: ' . $roles->id);
    }

    public function editRol($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $roles = Rol::on('mysql4')->find($id);
        return view('usuario/editRol')->with('rol', $roles);
    }


    private function validarEditRequest(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required',
        ]);
    }

    public function editRolPost(Request $request, $id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        self::validarEditRequest($request);
        $roles = Rol::on('mysql4')->find($id);
        $roles->descripcion = $request->descripcion;
        $roles->save();

        $roles = Rol::on('mysql4')->select('roles.id', 'roles.descripcion')
            ->get();
        return redirect('roles')->with('roles', $roles)->with('success', 'Rol editado con éxito');
    }


    public function deleteRol($id)
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        try {

            $roles = Rol::on('mysql4')->find($id);
            $roles->delete();
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->with('mensajeError', 'No se puede eliminar el Rol ' . $roles->descripcion . ', tiene usuarios asociados');
        }

        $roles = Rol::on('mysql4')->orderBy('descripcion')->get();
        return redirect('roles')->with('roles', $roles)->with('success', 'Rol eliminado con éxito');
    }

    public function verUsuarios()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $users = User::on('mysql4')->select('users.id', 'users.name', 'users.id_rol','roles.descripcion', 'users.email')
        ->join('roles', 'roles.id', '=', 'users.id_rol') ->orderBy('users.id')->get();
        return view('usuario/verUsuarios')->with('users', $users);
    }

    public function exportPdf()
    {
        $conexion = Conexion::find(1);
        DatabaseConnection::setConnection($conexion->nombre);

        $users = User::on('mysql4')->select('users.id', 'users.name', 'users.id_rol','roles.descripcion', 'users.email')
        ->join('roles', 'roles.id', '=', 'users.id_rol')
        ->orderBy('users.id')
        ->get();
        $pdf = PDF::loadView('pdf.userspdf', compact('users'));
        return $pdf ->stream('users-list.pdf');
    }



    public function exportxlsx()
    {
        return Excel::download(new UsuarioExport, 'users-list.xlsx');
    }

}
