<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::paginate();

        return view('user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function pdf()
    {
        $texto="";

        
        $conductors = DB::table('conductors')->select('idConductor','NomConductor','ApeConductor','Fechaingreso','FechaNa','Genero','Telefono')
                        ->orderBy('Fechaingreso','desc')->paginate(100);
        $porM = Conductor::whereNotNull('Genero')
                        ->groupBy('Genero')
                        ->selectRaw('Genero, count(*) as cantidad, (count(*) / (select count(*) from conductors)) as porcentaje')
                        ->get();
           
           
        
        $pdf = Pdf::loadView('conductor.pdf', compact('conductors','porM'));
        return $pdf->stream('reportePDF');
        //return view('conductor.pdf', compact('conductors'));
        
    }

    public function create()
    {
        $user = new User();
        // Cualquier otra lógica necesaria.
        return view('user.create', compact('user'));
    }

    public function store(Request $request)
    {
        //reglas minimas que debe segir el formualrios
        $rules = [
            'Nombre' => 'required',
            'Apellido' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'Rol' => 'required',
        ];
        //mensaje persolaizados para cada posible error.
        $validator = Validator::make($request->all(), $rules);
        $validator->setCustomMessages([
            'required' => 'El campo :attribute es obligatorio.', 
            'unique'=> 'El valor :attribute ya existe.',
        ]);
        //Asignacion de nombre a los campos para el usuario
        $validator->setAttributeNames([
            'ApeConductor' => 'Apellido',
            'NomConductor' => 'Nombre',
            'FechaNa' => 'Fecha de nacimiento',
            
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::create($request->all());
        //Redireccionamiento y mensaje a mostrar.
        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        // Cualquier otra lógica necesaria.
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'Nombre' => 'required',
            'Apellido' => 'required',
            'email' => 'required',
            'password' => 'required',
            'Rol' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->setCustomMessages([
            'required' => 'El campo :attribute es obligatorio.', 
            'unique'=> 'El valor :attribute ya existe.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update($request->all());

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
