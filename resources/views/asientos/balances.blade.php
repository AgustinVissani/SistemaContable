@extends('welcome')
@section('section')
    <h1 class="text-center h1tablaProvincia">Tabla  BALANCE COMPLETO DETALLADO</h1>
    <a href="{{ route('balance.pdf') }}" class="botonPDF" title="Descarga listado horizontal de balance PDF">
        <i class="far fa-file-pdf fa-3x " style="color: black;"></i>
    </a>

    <form action="balancesDH" method="POST">
        @csrf
        <div class="mb-3 row">
            <div class=" col-md-2">
                <script type="text/javascript">
                    // guardar datos
                    localStorage.setItem("fecha_desde", "fecha_desde");
                </script>
                <label for="fecha_desde" style="font-size: 20px;">Fecha desde:</label>
                <input type="date" class="form-control" name="fecha_desde" value=" {{ old('fecha_desde') }} "
                    id="fecha_desde" placeholder="Fecha" required>
            </div>
            <div class=" col-md-2">
                {{-- <script type="text/javascript">
                    // guardar datos
                    localStorage.setItem("fecha_hasta", "fecha_hasta");
                </script> --}}
                <label for="fecha_hasta" style="font-size: 20px;">Fecha hasta:</label>
                <input type="date" class="form-control" name="fecha_hasta" value=" {{ old('fecha_hasta') }} "
                onchange="finmes2()"  id="fecha_hasta" placeholder="Fecha" required>
                <label hidden id="noFinmes" style="color: red; font-size: 16px">No es fin de mes</label>
            </div>
        </div>

        <button style="margin: 10px" type="submit" class="btn btn-success">Generar listado DESDE/HASTA</button>
    </form>

    <div class="taCa">
        <div class="container">
            <table class="table  table-bordered" id="MyTable">
                <thead>
                    <tr class="text-center ">
                        <th class="text-center  tdNombre">ID Cuenta</th>
                        <th class="text-center  tdNombre">Código</th>
                        <th class="text-center  tdNombre">Nombre</th>
                        <th class="text-center  tdNombre">S.Inicial</th>
                        <th class="text-center  tdNombre">Debitos</th>
                        <th class="text-center  tdNombre">Creditos</th>
                        <th class="text-center  tdNombre">Saldo acumulado</th>
                        <th class="text-center  tdNombre">Saldo cierre</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($balances as $balance)
                        <tr>
                            <td class="text-center">{{ $balance->id_cuenta }}</td>
                            <td class="text-center">{{ $balance->codigo }}</td>
                            <td class="text-center">{{ $balance->nombre }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->saldo_inicial) }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->debitos) }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->creditos)  }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->saldo_acumulado) }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->saldo_cierre) }}</td>




                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

{{--
        <td class="text-center">
            <a href="verClientes/" class="btn btn-link botonLink">
                <span aria-hidden="true"></span>Generar listados
            </a>
        </td> --}}

    </div>

@endsection

