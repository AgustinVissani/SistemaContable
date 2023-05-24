@extends('welcome')
@section('section')

    <a href="/altaEmpresa" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"
        title="Agrega un nuevo género">Nueva Empresa</a>
    <br>


    <h1 class="text-center h1tablaProvincia">Tabla Empresas</h1>
        <div class="tabla">
            <div class="container">
                <table class="table  table-bordered" id="MyTable">
                    <thead>
                        <tr class="text-center ">
                            <th class="text-center  tdNombre">ID</th>
                            <th class="text-center  tdNombre">Nombre</th>
                            {{-- <th class="text-center  tdNombre">Editar</th> --}}
                            <th class="text-center  tdNombre">Eliminar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td class="text-center">{{ $empresa->id }}</td>
                                <td class="text-center">{{ $empresa->nombrepila }}</td>

                            {{-- <td class="text-center">

                                <a href="editEmpresa/{{ $empresa->id }}" class="btn btn-success btn-xs">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
                                </a>
                            </td> --}}

                            <td class="text-center">
                                <form method="POST" action="deleteEmpresa/{{ $empresa->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-xs " type="submit"
                                        onclick="return confirm('¿Seguro quiere eliminar? Se eliminarán todos los registros y tablas almacenados en la base de datos')">
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
