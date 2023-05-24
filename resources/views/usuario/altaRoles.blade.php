@extends('welcome')
@section('section')



    <form action="altaRoles" method="POST">
        @csrf
        <div class="container text-center ">

            <h1 class="text-center h1tablaCliente">Alta Rol</h1>

        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="descripcion">Rol </label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Rol"
                    value=" {{ old('descripcion') }} " required autofocus>
            </div>
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
            <button style="margin: 10px" type="submit" class="btn btn-primary">GUARDAR</button>


            <a  type="reset" id="cancel" name="cancel" href="/roles"  class="btn btn-secondary" value="1">CANCELAR</a>
        </div>



    </form>
@endsection
