<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    


    
    /**
     * Create a new controller instance.
     *
     *  public function redirecTo(){
        $user= Auth::user()->Rol;
        if(Auth::user()->Rol =='Administrador'){
            $this->redirecTo = route('home');
        }else{
            if(Auth::user()->Rol =='Supervisor'){
                $this->redirecTo = route('viajes.index');
            }else{
                $this->redirecTo = route('reservaciones.index');
            }
        }
        return $this->redirecTo;
    }
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated($request , $user){
        if($user->Rol=='administrador' || $user->Rol=='Administrador'){
            return redirect()->route('admin.dashboard') ;
        }else{
            return redirect()->route('supervisor.dashboard') ;
        }
        return redirect()->route('alumno.dashboard'); 

    }
}
