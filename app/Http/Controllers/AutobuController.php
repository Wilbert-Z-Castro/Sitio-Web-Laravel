<?php

namespace App\Http\Controllers;

use App\Models\Autobu;
use App\Models\Conductor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * Class AutobuController
 * @package App\Http\Controllers
 */
class AutobuController extends Controller
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

        $autobus = DB::table('autobus')->select('idAutobus','id_Conductor','Matricula','Modelo','Color','Capacidad')
                        ->where('idAutobus','LIKE','%'.$texto.'%')
                        ->orWhere('Matricula','LIKE','%'.$texto.'%')->paginate(5);

        return view('autobu.index', compact('autobus'))
            ->with('i', (request()->input('page', 1) - 1) * $autobus->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $autobu = new Autobu();
        $conductor = Conductor::pluck('Nomconductor','idConductor');
        $num=0;
        return view('autobu.create', compact('autobu','conductor','num'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * 
         * $rules = [
            'idConductor' => 'required|numeric|unique:conductors,idConductor',
            'NomConductor' => 'required',
            'ApeConductor' => 'required',
            'FechaNa' => 'required|date',
            'Genero' => 'required',
            'Telefono' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->setCustomMessages([
            'required' => 'El campo :attribute es obligatorio.', 
            'unique'=> 'El valor :attribute ya existe.',
        ]);
        $validator->setAttributeNames([
            'ApeConductor' => 'Apellido',
            'NomConductor' => 'Nombre',
            'FechaNa' => 'Fecha de nacimiento',
            
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
         */
        $rules = [
            'idAutobus' => 'required|numeric|min:1|unique:autobus,idAutobus',
            'id_Conductor' => 'required',
            'Matricula' => 'required|unique:autobus,Matricula',
            'Modelo' => 'required',
            'Capacidad' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->setCustomMessages([
            'required' => 'El campo :attribute es obligatorio.',
            'unique'=> 'El valor :attribute ya existe.',
            'numeric'=>'El valor debe de ser numerico mayor de 0',
        ]);
        $validator->setAttributeNames([
            'id_Conductor' => 'Conductor',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $autobu = Autobu::create($request->all());

        return redirect()->route('autobus.index')
            ->with('success', 'Autobu created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $autobu = Autobu::find($id);

        return view('autobu.show', compact('autobu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $autobu = Autobu::find($id);
        $conductor = Conductor::pluck('Nomconductor','idConductor');
        $num=1;
        return view('autobu.edit', compact('autobu','conductor','num'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Autobu $autobu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Autobu $autobu)
    {
        request()->validate(Autobu::$rules);

        $autobu->update($request->all());

        return redirect()->route('autobus.index')
            ->with('success', 'Autobu updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $autobu = Autobu::find($id)->delete();

        return redirect()->route('autobus.index')
            ->with('success', 'Autobu deleted successfully');
    }
}
