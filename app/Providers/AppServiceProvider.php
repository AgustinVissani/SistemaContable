<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Conexion;
use App\Models\Empresa;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $conexion = Conexion::find(1);
        $empresa=Empresa::select('empresa.nombrepila')->where('nombre','=', $conexion->nombre)->get();
       View::share('empre', $empresa[0]->nombrepila);
    }


}
