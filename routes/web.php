<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservacionesController;
use App\Models\Viaje;

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

Route::resource('conductors', App\Http\Controllers\ConductorController::class);
Route::resource('autobus', App\Http\Controllers\AutobuController::class);
Route::resource('viajes', App\Http\Controllers\ViajeController::class);
Route::resource('boletos', App\Http\Controllers\BoletoController::class);
Route::resource('users',App\Http\Controllers\UserController::class);


Route::get('/Reservaciones',[ReservacionesController::class,'index'])->name('reservaciones.index');
Route::get('/Reservaciones.from',[ReservacionesController::class,'form'])->name('reservaciones.form');
Route::get('/Reservaciones.create',[ReservacionesController::class,'create'])->name('reservaciones.create');
Route::get('/Reservaciones.mostrar',[ReservacionesController::class,'mostrar'])->name('reservaciones.mostrar');

Route::get('/dashboard-admin', function (){
    return view('home');
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
