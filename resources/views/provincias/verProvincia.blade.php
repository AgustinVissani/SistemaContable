@extends('welcome')
@section('section')


    <h1 class="text-center h1tablaCliente">Vista completa de la provincia</h1>


    <div class="tabla" style="display:flex; justify-content: center;">
        <table class="table table-bordered" id="TablaVerCliente">
            <thead>
                <tr class="text-center ">
                    <th class="text-center  tdNombre">ID</th>
                    <th class="text-center  tdNombre">Descripción</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">{{ $provincia->id }}</td>
                    <td class="text-center">{{ $provincia->descripcion }}</td>
                </tr>




            </tbody>
        </table>
    </div>
@endsection
