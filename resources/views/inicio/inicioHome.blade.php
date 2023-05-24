{{-- <div class="fondoInicio"> --}}
@extends('welcome')
@section('section')
    <h1 class=" text-center h1tablaProvincia">PRACTICAS PROFESIONALES</h1>
    <h1 class="text-center h1tablaProvincia">EMPRESA: '{{ $empresa }}'</h1>


    <br>

    <p style="font-size: 20px" class="text-center"><em>CP: '{{ $datosempresa->cp }}'</em></p>
    <p style="font-size: 20px" class="text-center"><em>ID Provincia: '{{ $datosempresa->id_provincia }}'</em></p>
    <p style="font-size: 20px" class="text-center"><em>Localidad: '{{ $datosempresa->id_localidad }}'</em></p>
    <p style="font-size: 20px" class="text-center"><em>Calle: '{{ $datosempresa->calle }}'</em></p>
    <p style="font-size: 20px" class="text-center"><em>Número: '{{ $datosempresa->numero }}'</em></p>
    <p style="font-size: 20px" class="text-center"><em>Piso: '{{ $datosempresa->piso }}'</em></p>
    <p style="font-size: 20px" class="text-center"><em>Tipo de responsable: '{{ $datosempresa->tipo_responsable }}'</em>
    </p>

    <p style="font-size: 20px; color: rgb(255, 50, 14)" class="text-center"><em>Ultima fecha de emisión del
            diario:
            '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_emision_diario), 'd-m-y') }}'
        </em></p>

    <p style="font-size: 20px; color: rgb(255, 50, 14)" class="text-center"><em>Fecha de apertura del ejercicio:
            '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_apertura), 'd-m-y') }}'</em>
    </p>

    <p style="font-size: 20px; color: rgb(255, 50, 14)" class="text-center"><em>Fecha de cierre del ejercicio:
            '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_cierre), 'd-m-y') }}'</em>
    </p>

    <br>
    <a style=" display: flex; align-items: center; justify-content: center;"
        href="editdatosEmpresa/{{ $datosempresa->id }}" class="btn btn-success btn-xs">
        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR DATOS DE EMPRESA
    </a>



@endsection
