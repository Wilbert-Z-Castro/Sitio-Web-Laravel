<?php

namespace App\Http\Controllers;
use App\Models\Conductor;
use App\Models\Autobu;
use App\Models\Viaje;
use App\Models\Boleto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $Consulta1 = Conductor::whereNotNull('Genero')
                        ->groupBy('Genero')
                        ->selectRaw('Genero, count(*) as cantidad, (count(*) / (select count(*) from conductors)) as porcentaje')
                        ->get();
        $Consulta2 = Boleto::whereNotNull('id_viaje')
                        ->groupBy('id_viaje')
                        ->selectRaw('id_viaje,(select Origen from viaje where idViaje=id_viaje) as Origen,(select Destino from viaje where idViaje=id_viaje) as Destino, count(*) as cantidad, (count(*) / (select count(*) from boleto)) as porcentaje')
                        ->orderBy('id_viaje','desc')
                        ->take(5)
                        ->get();
        $Consulta3 = Viaje::selectRaw('count(*) as cantidad,MONTH(FechaViaje) as mes')
        ->groupBy('mes')
        ->get();
        return view('home',compact('Consulta1','Consulta2','Consulta3'));
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
        return view('home.index');
    }



    public function restauracion(Request $request)
{
    if (!$request->hasFile('backup_file')) {
        return redirect()->route('home')
            ->with('error', 'No se ha cargado ningún archivo. Por favor, seleccione un archivo para restaurar.');
    }

    $archivo = $request->file('backup_file')->getRealPath();

    try {
        // Verifica que el archivo no esté vacío
        if (filesize($archivo) > 0) {
            // Lee el contenido del archivo SQL
            $sql = file_get_contents($archivo);
            $databaseHost = env('DB_HOST');
            $databaseUsername = env('DB_USERNAME');
            $databaseName = env('DB_DATABASE');
            // Ejecuta el contenido del archivo SQL en la base de datos
            exec("mysql -h $databaseHost -u $databaseUsername -p $databaseName < $archivo");

            return redirect()->route('home')
                ->with('success','La base de datos se ha restaurado correctamente.');
        } else {
            return redirect()->route('home')
                ->with('error', 'El archivo SQL está vacío.');
        }
    } catch (Exception $e) {
        dd($e->getMessage()); // Imprime el mensaje de error
        return redirect()->route('home')
            ->with('error', 'Error al restaurar la base de datos: ' . $e->getMessage());
    }
}


}
