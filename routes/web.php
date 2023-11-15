<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservacionesController;
use App\Models\Viaje;
use App\Models\Conductor;
use App\Models\Autobu;
use App\Models\Boleto;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('Conductores/PDF',[App\Http\Controllers\ConductorController::class, 'pdf'])->name('conductores.pdf');
Route::get('Boletos/PDF',[App\Http\Controllers\BoletoController::class, 'pdf'])->name('Boletos.pdf');
Route::get('Usuarios/PDF',[App\Http\Controllers\BoletoController::class, 'pdf'])->name('Usuarios.pdf');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/RespaldoBD', [App\Http\Controllers\HomeController::class, 'respaldo'])->name('home.respaldo');
Route::post('/RestauracionDB', [App\Http\Controllers\HomeController::class, 'restauracion'])->name('home.restauracion');

Route::resource('conductors', App\Http\Controllers\ConductorController::class);
Route::resource('autobus', App\Http\Controllers\AutobuController::class);
Route::resource('viajes', App\Http\Controllers\ViajeController::class);
Route::resource('boletos', App\Http\Controllers\BoletoController::class);
Route::resource('users',App\Http\Controllers\UserController::class);

Route::get('/Respaldo',[RespaldoController::class,'index'])->name('respaldo.index');

Route::get('/Reservaciones',[ReservacionesController::class,'index'])->name('reservaciones.index');
Route::get('/Reservaciones.from',[ReservacionesController::class,'form'])->name('reservaciones.form');
Route::get('/Reservaciones.create',[ReservacionesController::class,'create'])->name('reservaciones.create');
Route::get('/Reservaciones.mostrar',[ReservacionesController::class,'mostrar'])->name('reservaciones.mostrar');

Route::get('/dashboard-admin', function (){
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
})->name('admin.dashboard'); // <--- este es el nombre que busca el controlador.

Route::get('/dashboard', function (){
    $viajes = Viaje::paginate();
    return view('viaje.index', compact('viajes'))
        ->with('i', (request()->input('page', 1) - 1) * $viajes->perPage());
})->name('supervisor.dashboard'); 

Route::get('/dashboard-Viajes', function (){
    $viajes = Viaje::paginate();
    return view('reservaciones.index', compact('viajes'))
    ->with('i', (request()->input('page', 1) - 1) * $viajes->perPage());
})->name('alumno.dashboard'); 

