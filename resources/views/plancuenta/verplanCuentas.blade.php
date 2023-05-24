@extends('welcome')
@section('section')


    {{-- <h1 class="text-center h1tablaCliente">Vista completas de los Clientes</h1> --}}
    <h1 class="display-5 text-center" style="color: blue">Vista completas de los Clientes</h1>

    <div class="container p-4">
        <a href="{{ route('planCuentas.pdf') }}" class="botonPDF" title="Descarga listado de plan de cuentas PDF">
            <i class="far fa-file-pdf fa-3x " style="color: black;"></i>
        </a>

        <a href="{{ route('planCuentas.xlsx') }}" class="botonPDF" title="Descarga listado de plan de cuentas XLSX">
            <i class="far fa-file-excel fa-3x " style="color: black;"></i>
        </a>
    </div>
    {{-- <br>
    <br>
    <br> --}}
    <div class="container p-4">
        <div class="" style="display:flex; justify-content: center; overflow: scroll; height:700px;">
            <table class="table table-bordered" id="TablaVerCliente">
                <thead>
                    <tr class="text-center ">
                        {{-- <th class="text-center  "> checkbox</th> --}}
                        <th class="text-center  tdNombre">ID</th>
                        <th class="text-center  tdNombre">Código</th>
                        <th class="text-center  tdNombre">Nombre</th>
                        <th class="text-center  tdNombre">Imputable</th>
                        <th class="text-center  tdNombre">Nivel</th>



                    </tr>
                </thead>
                <tbody>
                    @foreach ($planCuentas as $planCuenta)
                        <tr>


                            {{-- <td class="text-center">
                                <div class="form-check">
                                    <input class="form-check-input position-static" type="checkbox" id="blankCheckbox"
                                        value="option1" aria-label="...">
                                </div>
                            </td> --}}
                            <td class="text-center">{{ $planCuenta->id }}</td>
                            <td class="text-center">{{ $planCuenta->codigo }}</td>
                            <td class="text-center">{{ $planCuenta->nombre }}</td>
                            <td class="text-center">{{ $planCuenta->imp }}</td>
                            <td class="text-center">{{ $planCuenta->nivel }}</td>


                        </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
{{--
    <a href="/editSexo/{{ $sexo->id }}" class="btn btn-success btn-xs " style="margin: 5px">
        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
    </a>



    <form method="POST" action="/deleteSexo/{{ $sexo->id }} ">
        @csrf
        @method('DELETE')
        <button style="margin: 5px" class="btn btn-danger btn-xs " type="submit"
            onclick="return confirm('¿Seguro quiere eliminar?')">
            <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
        </button>
    </form> --}}

@endsection
