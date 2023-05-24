@extends('welcome')
@section('section')


    <a href="/altaUsuario" class="btn btn-primary btn-lg active text-center" role="button" aria-pressed="true"
        title="Agrega un nuevo usuario">Nuevo Usuario</a>


    <br>
    <h1 class="text-center h1tablaProvincia">Tabla de Usuarios</h1>

    <div class="tabla">
        <div class="container">
            <table class="table  table-bordered" id="MyTable">
                <thead>
                    <tr class="text-center ">
                        <th class="text-center " scope="row">ID</th>
                        <th class="text-center " scope="row">Nombre</th>
                        <th class="text-center " scope="row">ID Rol</th>
                        <th class="text-center " scope="row">Rol</th>
                        <th class="text-center " scope="row">E-mail</th>
                        {{-- <th class="text-center " scope="row">Contraseña</th>
                        --}}
                        <th class="text-center tdNombre">Editar</th>
                        <th class="text-center tdNombre">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $user->id }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->id_rol }}</td>
                            <td class="text-center">{{ $user->descripcion }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            {{-- <td class="text-center">{{ $user->password }}</td> --}}


                            <td class="text-center">

                                <a href="editUsuario/{{ $user->id }}" class="btn btn-success btn-xs">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
                                </a>
                            </td>

                            <td class="text-center">
                                <form method="POST" action="deleteUsuario/{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-xs " type="submit"
                                        onclick="return confirm('¿Seguro quiere eliminar?')">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
                                    </button>
                                </form>
                            </td>


                        </tr>
                    @endforeach
                </tbody>

            </table>


        </div>


        <td class="text-center">
            <a href="verUsuarios/" class="btn btn-link botonLink">
                <span aria-hidden="true"></span>Generar listados
            </a>
        </td>

    </div>
@endsection
