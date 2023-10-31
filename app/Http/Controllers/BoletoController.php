<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


/**
 * Class BoletoController
 * @package App\Http\Controllers
 */
class BoletoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boletos = Boleto::paginate(7);

        return view('boleto.index', compact('boletos'))
            ->with('i', (request()->input('page', 1) - 1) * $boletos->perPage());
    }

    public function pdf()
    {
        $texto="";

        
        /*$conductors = DB::table('conductors')->select('idConductor','NomConductor','ApeConductor','Fechaingreso','FechaNa','Genero','Telefono')
                        ->orderBy('Fechaingreso','desc')->paginate(100);
        $porM = Conductor::whereNotNull('Genero')
                        ->groupBy('Genero')
                        ->selectRaw('Genero, count(*) as cantidad, (count(*) / (select count(*) from conductors)) as porcentaje')
                        ->get();*/
           
           
        $boletos = Boleto::paginate();
        $porM = Boleto::whereNotNull('id_viaje')
                        ->groupBy('id_viaje')
                        ->selectRaw('id_viaje,(select Origen from viaje where idViaje=id_viaje) as Origen,(select Destino from viaje where idViaje=id_viaje) as Destino, count(*) as cantidad, (count(*) / (select count(*) from boleto)) as porcentaje')
                        ->orderBy('id_viaje','desc')
                        ->get();
        $pdf = Pdf::loadView('boleto.pdf', compact('boletos','porM'));
        return $pdf->stream('reportePDF');
        //return view('conductor.pdf', compact('conductors'));
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     
    */
    public function create(Request $request)
        {
            $idViaje = $request->get('idViaje');
            $Disponibles = $request->get('Disponibles');
            $boleto = new Boleto();
            $boleto->idViaje = $idViaje;
            $viaje = $request->get('FechaViaje');
            return view('reservaciones.create', compact('boleto', 'viaje', 'idViaje', 'Disponibles'));
    }
    
    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Cantidad' => 'required|integer|min:1|max:'.$request->input('Disponibles'),
            // Otras reglas de validación aquí
        ]);

        $boleto = Boleto::create($request->all());
        
        $user = Auth::user();

        // Asigna el valor del ID del usuario al campo id_user
        $boleto->id_user = $user->id;

        // Guarda el boleto
        $boleto->save();
        return redirect()->route('reservaciones.index')
            ->with('success', 'Boleto created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boleto = Boleto::find($id);

        return view('boleto.show', compact('boleto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boleto = Boleto::find($id); // Intenta encontrar el boleto por ID

    if ($boleto) {
        // El boleto se encontró, ahora puedes acceder a sus propiedades
        $viaje = $boleto->viaje; // Accede a la relación para obtener el viaje relacionado

        // Ahora puedes acceder a los datos del viaje
        $idViaje = $viaje->idViaje;
        $Disponibles = $viaje->Disponibles;
        $FechaViaje = $viaje->FechaViaje;

        return view('boleto.edit', compact('boleto', 'idViaje', 'Disponibles', 'FechaViaje'));
    } else {
        // Manejar el caso en el que el boleto no se encontró, por ejemplo, redirigiendo o mostrando un mensaje de error
        return redirect()->route('boletos.index')->with('error', 'El boleto no existe.');
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Boleto $boleto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Boleto $boleto)
    {
        

        $request->validate([
            'Cantidad' => 'required|integer|min:1|max:'.$request->input('Disponibles'),
            // Otras reglas de validación aquí
        ]);

        $boleto->update($request->all());

        return redirect()->route('boletos.index')
            ->with('success', 'Boleto updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $boleto = Boleto::find($id)->delete();

        return redirect()->route('boletos.index')
            ->with('success', 'Boleto deleted successfully');
    }
}
