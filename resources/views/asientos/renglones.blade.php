@extends('welcome')
@section('section')



    <form action="/altaRenglones" method="POST">
        @csrf
        <div class="container text-center p-4">

            <h1 class="text-center h1tablaCliente">Renglones del asiento {{ $asiento->id }}</h1>
            <p style="font-size: 20px" class="text-center"><em>Ultima fecha de emisión del diario: '
                    '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_emision_diario), 'd-m-y') }}'
                </em></p>

            <p style="font-size: 20px" class="text-center"><em>Fecha de cierre del ejercicio:
                    '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_cierre), 'd-m-y') }}'</em>
            </p>


            <label style="font-size: 30px;">Número Asiento: {{ $asiento->id }} </label>
            <label style="font-size: 30px;"> -- Fecha Asiento :
                "{{ date_format(date_create_from_format('Y-m-d H:i:s', $asiento->fecha), 'd-m-y') }}" </label>
            <label style="font-size: 30px;"> -- Tipo Asiento: </label>
            @if ($asiento->tipo_asiento == 1)
                <label style="font-size: 30px;">Apertura</label>
            @elseif ($asiento->tipo_asiento == 5)
                <label style="font-size: 30px;">Normal</label>
            @elseif ($asiento->tipo_asiento == 9)
                <label style="font-size: 30px;">Cierre</label>
            @endif

        </div>

        <div class="parent">


            <label for="id_vista" style="font-size: 20px;">Id del renglón </label>
            <input type="text" class="form-control " name="id_vista" id="id_vista" placeholder="Id del renglón"
                value="{{ $asiento->proximo_id_renglon }}" disabled autofocus style="width: 200px">

            <input type="text" class="form-control sr-only " name="id" id="id" placeholder="Id del renglón"
                value="{{ $asiento->proximo_id_renglon }}" autofocus style="width: 200px">

            <label for="id_asiento_vista" style="font-size: 20px;">Id del asiento </label>
            <input type="text" class="form-control" name="id_asiento_vista" id="id_asiento_vista"
                placeholder="Id del asiento" value="{{ $asiento->id }} " disabled autofocus>

            <input type="text" class="form-control sr-only" name="id_asiento" id="id_asiento" placeholder="Id del asiento"
                value="{{ $asiento->id }} " autofocus>


            <label for="id_codigo" style="font-size: 20px;">Cuentas</label>
            <select name="id_codigo" id="id_codigo" class="form-control" required>
                @foreach ($cuentas as $cuenta)
                    <option value="{{ $cuenta->id }}">{{ $cuenta->codigo }} - {{ $cuenta->nombre }}
                    </option>
                @endforeach
            </select>
            <label hidden id="noCodigo" style="font-size: 20px;">No se encontraron resultados</label>

            <label for="comprobante" style="font-size: 20px;">Comprobante </label>
            <input type="text" class="form-control" name="comprobante" id="comprobante" placeholder="Comprobante"
                value="{{ $asiento->leyenda }}" required autofocus>


            <label for="fecha_vencimiento" style="font-size: 20px;">Fecha de vencimiento </label>
            <input type="date" class="form-control" name="fecha_vencimiento" id="fecha_vencimiento"
                placeholder="Fecha de vencimiento"
                value="{{ date_format(date_create_from_format('Y-m-d H:i:s', $asiento->fecha), 'Y-m-d') }}" required
                autofocus>


            <label for=" fecha_oper" style="font-size: 20px;">Fecha de operación </label>
            <input type="date" class="form-control" name="fecha_oper" id="fecha_oper" placeholder="Fecha de operación"
                value="{{ date_format(date_create_from_format('Y-m-d H:i:s', $asiento->fecha), 'Y-m-d') }}" required
                autofocus>



            <label for="leyenda" style="font-size: 20px;">Leyenda </label>
            <input type="text" class="form-control" name="leyenda" id="leyenda" placeholder="Leyenda"
                value="{{ $asiento->leyenda }}" required autofocus>


            {{-- <label for="idS" style="font-size: 20px;">Id Sucursal</label>
            <label class="sr-only">Id Sucursal</label>
            <input type="number" class="form-control" name="idS" value=" {{ old('idS') }} " id="idS"
                placeholder="Id Sucursal" onkeyup="setSucursal()"> --}}


            <label for="id_sucursal" style="font-size: 20px;">Sucursal</label>
            <select name="id_sucursal" id="id_sucursal" class="form-control" required>
                @foreach ($sucursales as $sucursal)
                    <option value="{{ $sucursal->id }}">{{ $sucursal->id }} {{ $sucursal->denominacion }}
                    </option>
                @endforeach
            </select>
            <label hidden id="noSucursal" style="font-size: 20px;">No se encontraron resultados</label>


            {{-- <label for="idSec" style="font-size: 20px;">Id Sección</label>
            <label class="sr-only">Id Sección</label>
            <input type="number" class="form-control" name="idSec" value=" {{ old('idSec') }} " id="idSec"
                placeholder="Id Sección" onkeyup="setSeccion()"> --}}


            <label for="id_seccion" style="font-size: 20px;">Sección</label>
            <select name="id_seccion" id="id_seccion" class="form-control" required>
                @foreach ($secciones as $seccion)
                    <option value="{{ $seccion->id }}">{{ $seccion->id }} {{ $seccion->denominacion }}
                    </option>
                @endforeach
            </select>
            <label hidden id="noSeccion" style="font-size: 20px;">No se encontraron resultados</label>


            <label for="debe_haber" style="font-size: 20px;">Debe / Haber </label>
            <select name="debe_haber" id="debe_haber" class="form-control" required>
                <option value="0">Debe</option>
                <option value="1">Haber</option>
            </select>




            <label for="importe" style="font-size: 20px;">Importe </label>
            <input type="number" step=0.01  class="form-control" name="importe" id="importe" placeholder="Importe" value=""
            pattern="^\d*(\.\d{0,2})?$"   required autofocus>



            @if ($ultimoRenglon != '')
                <script>
                    document.getElementById('id_codigo').value = {{ $ultimoRenglon->id_cuenta }};
                    document.getElementById('comprobante').value = {{ $ultimoRenglon->comprobante }};
                    document.getElementById('leyenda').value = {{ $ultimoRenglon->leyenda }};
                    document.getElementById('id_sucursal').value = {{ $ultimoRenglon->id_sucursal }};
                    document.getElementById('id_seccion').value = {{ $ultimoRenglon->id_seccion }};
                    document.getElementById('debe_haber').value = {{ $ultimoRenglon->debe_haber }};
                    document.getElementById('importe').value = {{ $ultimoRenglon->importe }} ;
                </script>
            {{-- @else
                <script>
                    document.getElementById('importe').value = 12;
                </script> --}}
            @endif



        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger" style="width: 500px">
                <ul>

                    @foreach ($errors->all() as $error)

                        <li class="errorMessage">{{ $error }}</li>

                    @endforeach

                </ul>
            </div>
        @endif

        <div class="form-group">
            <button style="margin: 10px" type="submit" class="btn btn-primary">Agregar</button>

        </div>


    </form>


    {{-- <div class="container home">
        <h2>Renglones</h2>
        <table id="tablaRenglones" class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">Renglon</th>
                    <th class="text-center">Cuenta</th>
                    <th class="text-center">Leyenda</th>
                    <th class="text-center">Suc</th>
                    <th class="text-center">Secc</th>
                    <th class="text-center">Debe</th>
                    <th class="text-center">Haber</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($renglones as $renglon)
                    <tr id="{{ $renglon->id }}">
                        <td class="text-center">{{ $renglon->id }}</td>
                        <td class="text-center">{{ $renglon->id_cuenta }}</td>
                        <td class="text-center">{{ $renglon->leyenda }}</td>
                        <td class="text-center">{{ $renglon->id_sucursal }}</td>
                        <td class="text-center">{{ $renglon->id_seccion }}</td>
                        @if ($renglon->debe_haber == 0)
                        <td class="text-center">
                                {{ $renglon->importe }}
                            </td>
                            <td class="text-center"></td>
                        @else
                        <td class="text-center"></td>
                        <td class="text-center">
                                {{ $renglon->importe }}
                            </td>
                        @endif



                    </tr>
                @endforeach

            </tbody>
        </table>
    </div> --}}


    <table class="table table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <th class="text-center">Asiento</th>
                <th class="text-center">Renglon</th>
                <th class="text-center">Id Cuenta</th>
                <th class="text-center">Cuenta</th>
                <th class="text-center">Fecha de operación</th>
                <th class="text-center">Fecha de vencimiento</th>
                <th class="text-center">Leyenda</th>
                <th class="text-center">Suc</th>
                <th class="text-center">Secc</th>
                <th class="text-center">Debe</th>
                <th class="text-center">Haber</th>
                <th class="text-center">Eliminar</th>
            </tr>
        </thead>

        @foreach ($renglones as $renglon)
            <tr>

                <td>
                    {{ $asiento->id }}

                </td>

                <td>
                    {{ $renglon->id }}
                </td>

                <td>
                    <a href="#" data-pk="{{ $renglon->id }}-{{ $asiento->id }}" data-name="id_cuenta">
                        {{ $renglon->id_cuenta }}</a>
                </td>

                <td>
                    {{ $renglon->CodigoCuenta }} - {{ $renglon->NombreCuenta }}
                </td>

                <td>
                    <a href="#" id="xeditdate" data-type="date" data-pk="{{ $renglon->id }}-{{ $asiento->id }}"
                        data-name="fecha_oper">
                        {{ date_format(date_create_from_format('Y-m-d H:i:s', $renglon->fecha_oper), 'Y-m-d') }}
                    </a>

                </td>

                <td>
                    <a href="#" id="xeditdate" data-type="date" data-pk="{{ $renglon->id }}-{{ $asiento->id }}"
                        data-name="fecha_vencimiento">
                        {{ date_format(date_create_from_format('Y-m-d H:i:s', $renglon->fecha_vencimiento), 'Y-m-d') }}</a>
                </td>
                {{-- <input  class="form-control" name="fecha_oper" id="fecha_oper" placeholder="Fecha de operación"
                value="{{ date_format(date_create_from_format('Y-m-d H:i:s', $asiento->fecha), 'Y-m-d') }}" required
                autofocus> --}}

                <td>
                    <a href="#" class="xedit" data-pk="{{ $renglon->id }}-{{ $asiento->id }}"
                        data-name="leyenda">
                        {{ $renglon->leyenda }}</a>
                </td>


                <td>
                    {{ $renglon->id_sucursal }} - {{ $sucursal->denominacion }}
                </td>

                <td>
                    {{ $renglon->id_seccion }} - {{ $seccion->denominacion }}</a>
                </td>


                @if ($renglon->debe_haber == 0)
                    <td>
                        <a href="#" class="xedit" data-pk="{{ $renglon->id }}-{{ $asiento->id }}"
                            data-name="importe">
                            {{ $renglon->importe }}</a>
                    </td>
                    <td>

                    </td>


                @else
                    <td>

                    </td>
                    <td>
                        <a href="#" class="xedit" data-pk="{{ $renglon->id }}-{{ $asiento->id }}"
                            data-name="importe">
                            {{ $renglon->importe }}</a>
                    </td>
                @endif

                <td class="text-center">
                    <form method="POST" action="/deleteRenglon/{{ $renglon->id }}">
                        @csrf
                        @method('DELETE')
                        <input type="text" class="form-control sr-only" name="id_asiento" id="id_asiento"
                            placeholder="Id del asiento" value="{{ $asiento->id }} " autofocus>
                        <button class="btn btn-danger btn-xs " type="submit"
                            onclick="return confirm('¿Seguro quiere eliminar?')">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
                        </button>
                    </form>
                </td>


            </tr>
        @endforeach

    </table>

    <script type="text/javascript">
        $.fn.editable.defaults.mode = 'inline';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('.xedit').editable({
            url: "{{ route('editAsiento') }}",
            type: 'text',
            title: 'Update',
            success: function(response, newValue) {
                if (response) {

                } else {

                }
            }
        });

        // $('.xeditdate').editable({
        //     url: "{{ route('editAsiento') }}",
        //     // type: 'date',
        //     title: 'Update',
        //     success: function(response, newValue) {
        //         if (response) {
        //             console.log('Updated: ', response);
        //         } else {
        //             console.log('Unnupdated: ', response);
        //         }
        //     }
        // });

        $('#xeditdate').editable({
            url: "{{ route('editAsiento') }}",
            title: 'Update',
            format: 'yyyy-mm-dd',
            viewformat: 'dd/mm/yyyy',
            datepicker: {
                weekStart: 1
            }
        });
    </script>






    <div class="mb-3 row">
        <div class=" col-md-2">
            <a class="btn btn-success" data-title='Guardar Asiento' data-toggle="modal" data-target="#modalGuardar">Guardar
                Asiento</a>
        </div>
        <div class=" col-md-2">
            <form action="/cancelarAsiento" method="POST">
                @csrf
                <input type="text" class="form-control sr-only" name="id_asiento" id="id_asiento"
                    placeholder="Id del asiento" value="{{ $asiento->id }} " autofocus>

                <button style="margin: 10px"
                    onclick="return confirm('¿Seguro quiere abandonar? Perderá todo lo que tiene en el asiento')"
                    type="submit" class="btn btn-danger">Abandonar</button>
            </form>
        </div>
    </div>

    <div class="modal " tabindex="-1" id="modalGuardar" data-keyboard="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Asiento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Seguro quiere registrar el asiento?</p>
                </div>
                <div class="modal-footer">

                    <form method="POST" action="/altaAsientoOk">
                        @csrf
                        <input type="text" class="form-control sr-only" name="id_asiento" id="id_asiento"
                            placeholder="Id del asiento" value="{{ $asiento->id }} " autofocus>
                        <button type="submit" class="btn btn-primary">Guardar sin
                            registrar</button>
                    </form>

                    <form method="POST" action="/altaAsientoOkRegistro">
                        @csrf
                        <input type="text" class="form-control sr-only" name="id_asiento" id="id_asiento"
                            placeholder="Id del asiento" value="{{ $asiento->id }} " autofocus>
                        <button type="submit" class="btn btn-success">Guardar y registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




@endsection
