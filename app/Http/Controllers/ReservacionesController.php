<?php

namespace App\Http\Controllers;
use App\Models\Viaje;
use Illuminate\Http\Request;
use App\Models\Autobu;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Boleto;
class ReservacionesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $viajes = Viaje::paginate();
        return view('Reservaciones.index', compact('viajes'))
            ->with('i', (request()->input('page', 1) - 1) * $viajes->perPage());
    }
    
    public function create(Request $request)
    {
        $idViaje = $request->get('idViaje');
        $Disponibles = $request->get('Disponibles');
        $boleto = new Boleto();
        $boleto->idViaje = $idViaje;
        $viaje = $request->get('FechaViaje');
        return view('reservaciones.create', compact('boleto', 'viaje', 'idViaje', 'Disponibles'));
    }
    public function mostrar()
    {
        $boletos = Boleto::paginate();

        return view('Reservaciones.mostrar', compact('boletos'))
            ->with('i', (request()->input('page', 1) - 1) * $boletos->perPage());
    }
}