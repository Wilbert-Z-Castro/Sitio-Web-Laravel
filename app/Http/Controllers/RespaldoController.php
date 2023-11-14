<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RespaldoController extends Controller
{

    public function index()
    {
        return view('respaldo.index');
    }

    public function respaldo()
    {
        if(function_exists('shell_exec')) {
            // Ruta donde se guardará el archivo temporalmente antes de la descarga
            $fechaHora = date('d-m-Y_H-i-s'); // Obtiene la fecha y hora actual en el formato 'YYYY-MM-DD_HH-MM-SS'
            $archivoTemporal = 'backup_' . $fechaHora . '.sql'; // Concatena la fecha y hora al nombre del archivo
        
            // Obtener los valores del archivo .env
            $databaseHost = env('DB_HOST');
            $databaseUsername = env('DB_USERNAME');
            $databaseName = env('DB_DATABASE');

            // Construir el comando mysqldump
            $comando = "C:/xampp/mysql/bin/mysqldump -h $databaseHost -u $databaseUsername $databaseName > $archivoTemporal";
            shell_exec($comando);
        
            // Obtener el contenido del archivo temporal
            $contenido = file_get_contents($archivoTemporal);
        
            // Descargar el archivo
            $response = response($contenido, 200);
            $response->header('Content-Type', 'application/octet-stream');
            $response->header('Content-Disposition', 'attachment; filename=' . $archivoTemporal);
        
            // Borrar el archivo temporal después de la descarga
            unlink($archivoTemporal);
        
            return $response;
        }
        return view('bd/respaldo');
    }



    public function restauracion(Request $request)
    {
        if (!$request->hasFile('backup_file')) {
            return redirect()->route('respaldo.index')
                ->with('error', 'No se ha cargado ningún archivo. Por favor, seleccione un archivo para restaurar.');
        }

        $archivo = $request->file('backup_file')->getRealPath();

        try {
            // Verifica que el archivo no esté vacío
            if (filesize($archivo) > 0) {
                // Lee el contenido del archivo SQL
                $sql = file_get_contents($archivo);

                // Ejecuta el contenido del archivo SQL en la base de datos
                DB::unprepared($sql);

                return redirect()->route('respaldo.index')
                ->with('success','La base de datos se ha restaurado correctamente.');
            } else {
                return redirect()->route('respaldo.index')
                    ->with('error', 'El archivo SQL está vacío.');
            }
        } catch (Exception $e) {
            dd($e->getMessage()); // Imprime el mensaje de error
            return redirect()->route('respaldo.index')
                ->with('error', 'Error al restaurar la base de datos: ' . $e->getMessage());
        }
    }
}