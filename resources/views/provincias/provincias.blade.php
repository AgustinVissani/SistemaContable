@extends('welcome')
@section('section')


    <a href="/altaProvincia" class="btn btn-primary btn-lg active text-center" role="button" aria-pressed="true"
        title="Agrega una nueva provincia">Nueva Provincia</a>



    <br>
    <h1 class="text-center h1tablaProvincia">Tabla Provincias</h1>

    <div class="tabla">
        <div class="container">
            <table class="table  table-bordered" id="MyTable">
                <thead>
                    <tr class="text-center ">
                        <th class="text-center " scope="row">ID</th>
                        <th class="text-center " scope="row">Descripción</th>
                        {{-- <th class="text-center  tdNombre">Ver</th> --}}
                        <th class="text-center tdNombre">Editar</th>
                        <th class="text-center tdNombre">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($provincias as $provincia)
                        <tr>
                            <td class="text-center">{{ $provincia->id }}</td>
                            <td class="text-center">{{ $provincia->descripcion }}</td>

                            {{-- <td class="text-center">
                                <a href="verProvincia/{{ $provincia->id }}" class="btn btn-info">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>VER
                                </a>
                            </td> --}}



                            <td class="text-center">

                                <a href="editProvincia/{{ $provincia->id }}" class="btn btn-success btn-xs">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
                                </a>
                            </td>

                            <td class="text-center">
                                <form method="POST" action="deleteProvincia/{{ $provincia->id }}">
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
            <a href="verProvincias/" class="btn btn-link botonLink">
                <span aria-hidden="true"></span>Generar listados
            </a>
        </td>

    </div>
@endsection
