<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use Illuminate\Http\Request;
use App\Models\Autobu;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
/**
 * Class ViajeController
 * @package App\Http\Controllers
 */
class ViajeController extends Controller
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

        $viajes = DB::table('viaje')->select('idViaje','FechaViaje','Descripcion','Origen','Destino','Disponibles','id_autobus')
                        ->where('idViaje','LIKE','%'.$texto.'%')
                        ->orWhere('Origen','LIKE','%'.$texto.'%')
                        ->orWhere('Destino','LIKE','%'.$texto.'%')->paginate(5);

        return view('viaje.index', compact('viajes'))
            ->with('i', (request()->input('page', 1) - 1) * $viajes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $viaje = new Viaje();
        $autobus = Autobu::pluck('Matricula','idAutobus');
        $num=0;
        return view('viaje.create', compact('viaje','autobus','num'));
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
            'idViaje' => 'required|numeric|min:1|unique:viaje,idViaje',
            'FechaViaje' => 'required',
            'Descripcion' => 'required',
            'Origen' => 'required',
            'Destino' => 'required',
            'id_autobus' => 'required',
            
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->setCustomMessages([
            'required' => 'El campo :attribute es obligatorio.',
            'unique'=> 'El valor :attribute ya existe.',
            'numeric'=>'El valor debe de ser numerico mayor de 0',
        ]);
        $validator->setAttributeNames([
            'ApeConductor' => 'Apellido',
            'id_autobus' => 'Matricula',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $viaje = Viaje::create($request->all());

        return redirect()->route('viajes.index')
            ->with('success', 'Viaje Creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $viaje = Viaje::find($id);

        return view('viaje.show', compact('viaje'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $viaje = Viaje::find($id);
        $autobus = Autobu::pluck('Matricula','idAutobus');
        $num=1;
        return view('viaje.edit', compact('viaje','autobus','num'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Viaje $viaje
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Viaje $viaje)
    {
        $rules = [
            'idViaje' => 'required|numeric|min:1|unique:viaje,idViaje',
            'FechaViaje' => 'required',
            'Descripcion' => 'required',
            'Origen' => 'required',
            'Destino' => 'required',
            'id_autobus' => 'required',
            
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->setCustomMessages([
            'required' => 'El campo :attribute es obligatorio.',
            'unique'=> 'El valor :attribute ya existe.',
            'numeric'=>'El valor debe de ser numerico mayor de 0',
        ]);
        $validator->setAttributeNames([
            'ApeConductor' => 'Apellido',
            'id_autobus' => 'Matricula',

        ]);

        $viaje->update($request->all());

        return redirect()->route('viajes.index')
            ->with('success', 'Viaje actualizado correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $viaje = Viaje::find($id)->delete();

        return redirect()->route('viajes.index')
            ->with('success', 'Viaje deleted successfully');
    }
}
