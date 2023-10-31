<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return view('user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function create()
    {
        $user = new User();
        // Cualquier otra lógica necesaria.
        return view('user.create', compact('user'));
    }

    public function store(Request $request)
    {
        $rules = [
            'Nombre' => 'required',
            'Apellido' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'Rol' => 'required',
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
        $user = User::create($request->all());

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
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
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
