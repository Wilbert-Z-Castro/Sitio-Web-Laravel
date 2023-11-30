<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\User;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;


/**
 * Class BoletoController
 * @package App\Http\Controllers
 */
class BoletoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $boletos = Boleto::paginate(7);
        $texto=$request->get('texto');
        $user =User::get();
        $boletos = DB::table('boleto')->select('idBoleto','FechaBoleto','Cantidad','id_viaje','id_user')
                        ->where('idBoleto','LIKE','%'.$texto.'%')->paginate(5);
        return view('boleto.index', compact('boletos','user'))
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
                        ->selectRaw('id_viaje,(select Origen from viaje where idViaje=id_viaje) as Origen,(select Destino from viaje where idViaje=id_viaje) as Destino, count(*) as cantidad, ((count(*) / (select count(*) from boleto))*100 ) as porcentaje')
                        ->orderBy('id_viaje','desc')
                        ->WhereRaw('month((select FechaViaje from viaje where idViaje=id_viaje)) = month(now())')
                        ->take(5)
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
        $rules = [
            
            'Cantidad' => 'required|integer|min:1|max:'.$request->input('Disponibles'),
        ];
        
        $validator = Validator::make($request->all(), $rules);
        $validator->setCustomMessages([
            'Cantidad' => 'El valor de la :attribute es mayor a la cantidad de asientos disponibles.', 
            'required' => 'El campo :attribute es obligatorio.', 
            'integer' =>'El campo :attribute tiene que ser de tipo entero',
            'min' => 'El campo :attribute tiene que ser de tipo entero mayor a uno ( 1 )',
            //'FechaNa.min' => 'La fecha de nacimiento debe ser al menos 18 años antes de la fecha actual.',
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $boleto = Boleto::create($request->all());
        
        $user = Auth::user();

        // Asigna el valor del ID del usuario al campo id_user
        $boleto->id_user = $user->id;

        // Guarda el boleto
        $boleto->FechaBoleto=date('Y-m-d');
        $boleto->save();
        return redirect()->route('reservaciones.index')
            ->with('success', 'Boleto creado correctamente.');
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
        $user =User::get();
        return view('boleto.show', compact('boleto','user'));
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
        

        $rules = [
            
            'Cantidad' => 'required|integer|min:1|max:'.$request->input('Disponibles'),
        ];
        
        $validator = Validator::make($request->all(), $rules);
        $validator->setCustomMessages([
            'Cantidad' => 'El valor de la :attribute es mayor a la cantidad de asientos disponibles.', 
            'required' => 'El campo :attribute es obligatorio.', 
            'integer' =>'El campo :attribute tiene que ser de tipo entero',
            'min' => 'El campo :attribute tiene que ser de tipo entero mayor a uno ( 1 )',
            //'FechaNa.min' => 'La fecha de nacimiento debe ser al menos 18 años antes de la fecha actual.',
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $boleto->update($request->all());

        return redirect()->route('reservaciones.mostrar')
            ->with('success', 'Boleto actualizado correctamente ');
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
