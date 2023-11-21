<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
/**
 * Class ConductorController
 * @package App\Http\Controllers
 */
class ConductorController extends Controller
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
        $texto=$request->get('texto');

        $conductors = DB::table('conductors')->select('idConductor','NomConductor','ApeConductor','Fechaingreso','FechaNa','Genero','Telefono')
                        ->where('idConductor','LIKE','%'.$texto.'%')->paginate(3);

        return view('conductor.index', compact('conductors'))
            ->with('i', (request()->input('page', 1) - 1) * $conductors->perPage());
    }
    //para crear el PDF
    public function pdf()
    {
        $texto="";

        
        $conductors = DB::table('conductors')->select('idConductor','NomConductor','ApeConductor','Fechaingreso','FechaNa','Genero','Telefono')
                        ->orderBy('Fechaingreso','desc')->paginate(100);
        $porM = Conductor::whereNotNull('Genero')
                        ->groupBy('Genero')
                        ->selectRaw('Genero, count(*) as cantidad, (count(*) / ((select count(*) from conductors))*100) as porcentaje')
                        ->get();
           
           
        
        $pdf = Pdf::loadView('conductor.pdf', compact('conductors','porM'));
        return $pdf->stream('reportePDF');
        //return view('conductor.pdf', compact('conductors'));
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $conductor = new Conductor();
        $num=["Hombre","Mujer","Otro"];
        $num1=0;
        return view('conductor.create', compact('conductor','num','num1'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fehcamin=Carbon::now()->subYears(18)->timestamp;
        $rules = [
            'idConductor' => 'required|numeric|min:1|unique:conductors,idConductor',
            'NomConductor' => 'required',
            'ApeConductor' => 'required',
            'FechaNa' => 'required|date|before:now-18Years',
            'Genero' => 'required',
            'Telefono' => 'required|numeric|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->setCustomMessages([
            'required' => 'El campo :attribute es obligatorio.', 
            'unique'=> 'El valor :attribute ya existe.',
            'numeric'=>'El valor debe de ser numerico mayor de 0',
            'min'=>'El telefono debe de tener al menos 8 caracteres',
            'before'=>'Debe de ser mayor de edad',
            //'FechaNa.min' => 'La fecha de nacimiento debe ser al menos 18 años antes de la fecha actual.',
            
        ]);
        $validator->setAttributeNames([
            'ApeConductor' => 'Apellido',
            'NomConductor' => 'Nombre',
            'FechaNa' => 'Fecha de nacimiento',
            
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        

        $conductor = Conductor::create($request->all());

        return redirect()->route('conductors.index')
            ->with('success', 'Conductor created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($idConductor)
    {
        $conductor = Conductor::find($idConductor);

        return view('conductor.show', compact('conductor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idConductor)
    {
        $conductor = Conductor::find($idConductor);
        $num=["Hombre","Mujer","Otro"];
        $num1=1;
        return view('conductor.edit', compact('conductor','num','num1'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Conductor $conductor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conductor $conductor)
    {

        request()->validate(Conductor::$rules);
        $conductor->update($request->all());

        return redirect()->route('conductors.index')
            ->with('success', 'Conductor updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $conductor = Conductor::find($id)->delete();

        return redirect()->route('conductors.index')
            ->with('success', 'Conductor deleted successfully');
    }
}
