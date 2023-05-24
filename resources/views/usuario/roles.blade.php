@extends('welcome')
@section('section')




    <a href="/altaRoles" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"
        title="Agrega un nuevo rol">Nuevo Rol</a>
    <br>


    <h1 class="text-center h1tablaProvincia">Tabla Roles</h1>




        <div class="tabla">
            <div class="container">
                <table class="table  table-bordered" id="MyTable">
                    <thead>
                        <tr class="text-center ">
                            <th class="text-center  tdNombre">ID</th>
                            <th class="text-center  tdNombre">Rol</th>
                            <th class="text-center  tdNombre">Editar</th>
                            <th class="text-center  tdNombre">Eliminar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $rol)
                            <tr>
                                <td class="text-center">{{ $rol->id }}</td>
                                <td class="text-center">{{ $rol->descripcion }}</td>

                            <td class="text-center">

                                <a href="editRol/{{ $rol->id }}" class="btn btn-success btn-xs">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
                                </a>
                            </td>

                            <td class="text-center">
                                <form method="POST" action="deleteRol/{{ $rol->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-xs " type="submit"
                                        onclick="return confirm('¿Seguro quiere eliminar?')">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
                                    </button>
                                </form>
                            </td>

                        @endforeach
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>




@endsection
