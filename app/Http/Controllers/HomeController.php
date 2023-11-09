<?php

namespace App\Http\Controllers;
use App\Models\Conductor;
use App\Models\Autobu;
use App\Models\Viaje;
use App\Models\Boleto;
use App\Models\User;
use Illuminate\Http\Request;

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
}
