<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UsuarioController;
use App\Models\admin;
use App\Http\Controllers\GuestSiteController;
use App\Models\Usuarios;
use App\Models\persona;

class LoginController extends Controller
{
    /**
     * Función para realizar el login de la aplicación
     */
    public function login(Request $request){
        $request->validate([
            'user'=>['required'],
            'password'=>['required']
        ]);

        try{
            $userName = $request->input("user");
            $pass = $request->input('password');

            $user = DB::table('usuario')
                        ->where('usuario','=',$userName)->get();

            if(!empty($user[0])){
                if($user[0]->password == Hash('SHA256',$pass)){
                    $accessLevel = $user[0]->nivel;

                    if($accessLevel == 1){  //Invitado
                        $guestDui = $user[0]->idUsuario;
                        $guestStatus = DB::table('Persona')
                        ->join('Invitado', 'Invitado.idPersona', '=', 'Persona.idPersona')
                        ->get();
                        if($guestStatus[0]->estadoEliminacion == 1){
                            $request->session()->put('user',$user);
                            session()->put('invitado',$guestStatus);
                            return to_route('guestSite.site');
                        }else{
                            return redirect()->back()->with('error','Acceso denegado');
                        }
                    }else if($accessLevel == 0){ //administrador
                        $adminDui = $user[0]->idUsuario;
                        $adminStatus = DB::table('Persona')
                        ->join('Administrador', 'Administrador.idPersona', '=', 'Persona.idPersona')
                        ->get();
                        if($adminStatus[0]->estadoEliminacion == 1){
                            $request->session()->put('user',$user); //Creando variable de sesion con la información del usuario
                            session()->put('administrador',$adminStatus);
                            return to_route('events.index');
                        }else{
                            return redirect()->back()->with('error','Acceso denegado');
                        }}else{
                            return redirect()->back()->with('error','Acceso denegado');
                        }
    
                    }else{
                        return redirect()->back()->with('error','Usuario y/o contraseña incorrectos');
                    }
                } else{
                    return redirect()->back()->with('error','Usuario y/o contraseña incorrectos');
                }
            }catch(Exception $e){
                return redirect()->back()->with('error','Error al iniciar sesión');
            }         
    }

    /**
     * Función para mostrar vista de inicio de la aplicación
     */
    public function welcome(){
        if(session()->has('user')){
            session()->forget('user');
        } 

        if(session()->has('invitado')){
            session()->forget('invitado');
        }else if(session()->has('administrador')){
            session()->forget('administrador');            
        }

        $admins = DB::table('usuario')
                        ->where('nivel','=',0)
                        ->count();
    
        if($admins > 0){ 
            return view('welcome');
        }else{
            return view('firstAdmin');
        }
                         
    }

    /**
     * Función para mostrar vista de login
     */
    public function showLogin()
    {
        if(session()->has('user')){
            session()->forget('user');
        }  

        if(session()->has('invitado')){
            session()->forget('invitado');
        }else if(session()->has('administrador')){
            session()->forget('administrador');            
        }

        return view('welcome');
    }
    /**
     * Función para registrar primer administrador
     */
    public function storeFirstAdmin(Request $request){
        $request->validate([
            'nombre' => ['required', 'max:255', 'string'],
            'apellido' => ['required', 'max:255', 'string'],
            'dui' => ['required', 'regex:/^[0-9]{8}-[0-9]{1}$/', 'unique:Persona,dui'],
            'telefono' => ['required', 'regex:/^([2,6,7][0-9]{3})(-)([0-9]{4})$/', 'unique:Persona,telefono'],
            'correo' => ['required', 'email', 'unique:Persona,correo'],
            'direccion' => ['required', 'max:255', 'string'],
            'cargo' => ['required', 'max:255', 'string'],
            'usuario' => ['required', 'max:255', 'string'],
            'password' => ['required', 'min:8', 'string'],        ]);
        
        try{
            date_default_timezone_set('America/El_Salvador');
            DB::beginTransaction();
            $name = $request->input('nombre');
            $apellido = $request->input('apellido');
            $dui = $request->input('dui');
            $telefono = $request->input('telefono');
            $correo = $request->input('correo');
            $direccion = $request->input('direccion');
            $cargo = $request->input('cargo');
            $user = $request->input('usuario');
            $pass = $request->input(('password'));

            $admin = new persona();
            $admin->nombre = $name;
            $admin->apellido = $apellido;
            $admin->dui = $dui;
            $admin->telefono = $telefono;
            $admin->correo = $correo;
            $admin->direccion = $direccion;
            $admin->estadoEliminacion = 1;

             

            if($admin->save()){
                $idPersona = $admin->idPersona;
                $administrateur = new admin();
                $administrateur->idPersona= $idPersona;
                $administrateur->cargo = $cargo;
                $administrateur->estadoEliminacion = 1; 
                $newUser = new Usuarios();
                $newUser->idUsuario = $dui;
                $newUser->usuario = $user;
                $newUser->password = Hash('SHA256',$pass);
                $newUser->nivel = 0;


                if($newUser->save() && $administrateur->save()){                    DB::commit();
                    return to_route('showLogin')->with('exitoRegistoAdmin','Administrador registrado correctamente');
                }else{
                    DB::rollBack();
                    return redirect()->back()->with('error','Ha ocurrido un error al registrar administrador');
                }
            }else{
                DB::rollBack();
                return redirect()->back()->with('error','Ha ocurrido un error al registrar administrador');
            }
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','Ha ocurrido un error al registrar administrador'.$e->getMessage());
        } 
    }

    /**
     * Función para cerrar sesión
     */
    public function logout(){
        if(session()->has('user')){
            session()->forget('user');
        }

        if(session()->has('invitado')){
            session()->forget('invitado');
        }else if(session()->has('administrador')){
            session()->forget('administrador');            
        }
        return to_route('showLogin');
    }
}
