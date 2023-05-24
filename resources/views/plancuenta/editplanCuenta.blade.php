@extends('welcome')
@section('section')
    <form action="/editplanCuenta/{{ $planCuenta->id }}" method="POST">
        @csrf
        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="codigo">Código</label>
                <input disabled type="text" class="form-control" name="codigo"
                    value="{{ $planCuenta->prefijo }}{{ $planCuenta->sufijo }}" id="codigo" placeholder="Código"
                    required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-3">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" value="{{ $planCuenta->nombre }}" id="nombre" placeholder="Nombre"
                    required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="imp" name="imp">
                    <label class="form-check-label" for="imp">Imputable</label>
                </div>
            </div>
        </div>
        @if ($planCuenta->imp == 'Sí')
            <script>
                document.getElementById('imp').checked = true;
            </script>
        @else
            <script>
                document.getElementById('imp').checked = false;
            </script>
        @endif

        <!-- <div class="mb-3 row">
                        <div class=" col-md-4">
                            <label for="nivel">Nivel</label>
                            <label class="sr-only">Nivel</label>
                            <input type="text" class="form-control" name="nivel" value=" {{ old('nivel') }} " id="nivel"
                                placeholder="nivel" required>
                        </div>
                    </div> -->


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
            <button style="margin: 10px" type="submit" class="btn btn-primary">GUARDAR</button>
            <a  type="reset" id="cancel" name="cancel" href="/planCuentas"  class="btn btn-secondary" value="1">CANCELAR</a>
        </div>

    </form>
@endsection
