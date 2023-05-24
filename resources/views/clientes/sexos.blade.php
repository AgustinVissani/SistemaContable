@extends('welcome')
@section('section')




    <a href="/altaSexo" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"
        title="Agrega un nuevo género">Nuevo Género</a>
    <br>


    <h1 class="text-center h1tablaProvincia">Tabla Géneros</h1>




        <div class="tabla">
            <div class="container">
                <table class="table  table-bordered" id="MyTable">
                    <thead>
                        <tr class="text-center ">
                            <th class="text-center  tdNombre">ID</th>
                            <th class="text-center  tdNombre">Género</th>
                            <th class="text-center  tdNombre">Editar</th>
                            <th class="text-center  tdNombre">Eliminar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sexos as $sexo)
                            <tr>
                                <td class="text-center">{{ $sexo->id }}</td>
                                <td class="text-center">{{ $sexo->tipo }}</td>

                            <td class="text-center">

                                <a href="editSexo/{{ $sexo->id }}" class="btn btn-success btn-xs">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
                                </a>
                            </td>

                            <td class="text-center">
                                <form method="POST" action="deleteSexo/{{ $sexo->id }}">
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
