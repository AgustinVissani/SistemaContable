<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Log;
use Exception;
use App\Models\Conexion;

class ControllerBackup extends Controller
{

    public function __construct()
    {
        // Filtrar todos los métodos
        // $this->middleware('auth');
    }

    public function viewBack()
    {
        // $disk = Storage::disk('backup');
        // $directory = '/PracticaProfesional';
        // $files = $disk->files($directory);
        // foreach ($files as $k => $f) {
        //     if (substr($f, -4) == '.zip' && $disk->exists($f)) {
        //         $backups[] = [
        //             'file_path' => $f,
        //             'file_name' => str_replace(config('backup_empresa') . 'PracticaProfesional/', '', $f),
        //             'file_size' => Format::humanReadableSize($disk->size($f)),
        //             'last_modified' => Carbon::createFromTimestamp($disk->lastModified($f)),
        //         ];
        //     }
        // }

        // $backups = array_reverse($backups);
        // return view('backup/backup')->with(compact('backups'));
        return view('backup/backup')->with('backups', []);
    }

    public function realizarBackup()
    {
        try {
            Artisan::call('db:backup');
            return redirect()->back()->with('success', 'Backup realizado con éxito');
        } catch (Exception $e) {
            return redirect()->back()->with('mensajeError', 'Error al realizar el backup');
        }
    }

    public function realizarRestore(Request $request)
    {
        if ($request->hasFile('filesql')) {
            if ($request->file('filesql')->getClientOriginalExtension() != 'sql') {
                return redirect()->back()->with('mensajeError', 'Debe seleccionarse un archivo .sql');
            } else {
                $bd = Conexion::find(1);
                $file = $request->file('filesql')->getClientOriginalName();
                $path = Storage::putFileAs('restores', $request->file('filesql'), $file);
                $content = Storage::get($path);
                $content = substr($content, 0, 500);
                $pos = strpos($content, 'Database: ' . $bd->nombre);
                if ($pos === false) {
                    Storage::delete($path);
                    return redirect()->back()->with('mensajeError', 'Debe seleccionarse un archivo .sql correspondiente a la empresa logueada');
                } else {
                    Artisan::call('db:restore', ['--filename' => $path]);
                    Storage::delete($path);
                    return redirect()->back()->with('success', 'Restauración realizada con éxito');
                }
            }
        } else {
            return redirect()->back()->with('mensajeError', 'Debe seleccionarse un archivo .sql');
        }
    }

    public function eliminarBackup($filename)
    {
        $disk = Storage::disk('backup');
        $directory = '/PracticaProfesional';
        $exists = $disk->exists($directory . '/' . $filename);
        if (!$exists) {
            return back()->with('mensaje', 'No existe el archivo seleccionado');
        } else {
            $del = $disk->delete($directory . '/' . $filename);
            if ($del) {
                return back()->with('success', 'Backup eliminado con éxito');
            } else {
                return back()->with('mensaje', 'Error al eliminar');
            }
        }
    }

    public function downloadZip($filename)
    {
        $disk = Storage::disk('backup');
        $directory = '\PracticaProfesional';
        $exists = $disk->exists($directory . '/' . $filename);
        if (!$exists) {
            return back()->with('mensaje', 'No existe el archivo seleccionado');
        }
        return response()->download('E:\\Desarrollo WEB\\mi-proyecto-laravel\\storage\\app\\backups\\PracticaProfesional\\' . $filename);
    }
}
