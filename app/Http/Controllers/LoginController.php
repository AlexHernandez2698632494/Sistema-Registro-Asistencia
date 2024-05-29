<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UsuarioController;
use App\Models\admin;
use App\Http\Controllers\GuestSiteController;
use App\Mail\Credentials;
use App\Models\Usuarios;
use App\Models\persona;
use Illuminate\Support\Facades\Mail;

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
                        $guestStatus = DB::table('invitado')->where('duiInvitado','=',$guestDui)->get();
                        if($guestStatus && $guestStatus[0]->estadoEliminacion == 1){
                            $request->session()->put('user',$user);
                            session()->put('invitado',$guestStatus);
                            return to_route('guestSite.site');
                        }else{
                            return redirect()->back()->with('error','Acceso denegado');
                        }
                    }else if($accessLevel == 2){ //estudiante UDB
                        $carnetUDB = $user[0]->idUsuario;
                        $UDBStudentGuestStatus = DB::table('estudianteUDB')->where('carnetUDB','=',$carnetUDB)->get();
                        if($UDBStudentGuestStatus && $UDBStudentGuestStatus[0]->estadoEliminacion == 1){
                            $request->session()->put('user',$user);
                            session()->put('estudianteUDB',$UDBStudentGuestStatus);
                            return to_route('UDBStudentGuestSite.site');
                        }else{
                            return redirect()->back()->with('error','Acceso denegado');
                        }
                    }else if($accessLevel == 3){ //Personal UDB
                        $carnetUDB = $user[0]->idUsuario;
                        $UDBStaffGuestStatus = DB::table('personalUDB')->where('carnetUDB','=',$carnetUDB)->get();
                        if($UDBStaffGuestStatus && $UDBStaffGuestStatus[0]->estadoEliminacion == 1){
                            $request->session()->put('user',$user);
                            session()->put('personalUDB',$UDBStaffGuestStatus);
                            return to_route('UDBStaffGuestSite.site');
                        }else{
                            return redirect()->back()->with('error','Acceso denegado');
                        }
                    }else if($accessLevel == 0){ //administrador
                        $adminDui = $user[0]->idUsuario;
                        $adminStatus = DB::table('administrador')
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
        }else if(session()->has('estudianteUDB')){
            session()->forget('estudianteUDB');
        }else if(session()->has('personalUDB')){
            session()->forget('personalUDB');
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
    public function showLogin(){
        if(session()->has('user')){
            session()->forget('user');
        }  

        if(session()->has('invitado')){
            session()->forget('invitado');
        }else if(session()->has('estudianteUDB')){
            session()->forget('estudianteUDB');
        }else if(session()->has('personalUDB')){
            session()->forget('personalUDB');
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
            'carnet' => ['required', 'max:255', 'string'],
            'telefono' => ['required', 'regex:/^([2,6,7][0-9]{3})(-)([0-9]{4})$/', 'unique:administrador,telefonoAdmin'],
            'correo' => ['required', 'email', 'unique:administrador,correoAdmin'],
            'cargo' => ['required', 'max:255', 'string'],
            'usuario' => ['required', 'max:255', 'string'],
            'password' => ['required', 'min:8', 'string'],        ]);
        
        try{
            date_default_timezone_set('America/El_Salvador');
            DB::beginTransaction();
            $name = $request->input('nombre');
            $apellido = $request->input('apellido');
            $sexo = $request->input('sexo');
            $carnet = $request->input('carnet');
            $telefono = $request->input('telefono');
            $correo = $request->input('correo');
            $cargo = $request->input('cargo');
            $user = $request->input('usuario');
            $pass = $request->input(('password'));

            $admin = new admin();
            $admin->nombreAdmin = $name;
            $admin->apellidosAdmin = $apellido;
            $admin->sexoAdmin = $sexo;
            $admin->carnetAdmin = $carnet;
            $admin->telefonoAdmin = $telefono;
            $admin->correoAdmin = $correo;
            $admin->cargoAdmin = $cargo;
            $admin->estadoEliminacion = 1;

             

            if($admin->save()){
                // $idPersona = $admin->idPersona;
                // $administrateur = new admin();
                // $administrateur->idPersona= $idPersona;
                // $administrateur->cargo = $cargo;
                // $administrateur->estadoEliminacion = 1; 
                $newUser = new Usuarios();
                $newUser->idUsuario = $carnet;
                $newUser->usuario = $user;
                $newUser->password = Hash('SHA256',$pass);
                $newUser->nivel = 0;


                if($newUser->save() ){                    
                    DB::commit();
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
        }else if(session()->has('estudianteUDB')){
            session()->forget('estudianteUDB');
        }else if(session()->has('personalUDB')){
            session()->forget('personalUDB');
        }else if(session()->has('administrador')){
            session()->forget('administrador');            
        }
        
        return to_route('showLogin');
    }

    public function generatePass()
    {
        $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pass = '';
        $strength = 10;

        $stringLenght = strlen($permittedChars);

        for ($i = 0; $i < $strength; $i++) {
            $randomCharacter = $permittedChars[mt_rand(0, $stringLenght - 1)];
            $pass .= $randomCharacter;
        }
        return $pass;
    }

    public function recuperarView(){
        return view('recuperarContra');
    }

    public function recuperarContra(Request $request){
        $request->validate([
            'user' => 'required|string|max:255',
        ]);
        $userName = $request->input('user');

        $user = DB::table('usuario')->where('usuario','=', $userName)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }
        if($user->nivel ==1){
            $guest = DB::table('invitado')->where('duiInvitado','=', $user->idUsuario)->first();
            $guestEmail = $guest->correoInvitado;
            $newPassword = $this->generatePass();
            DB::table('usuario')->where('usuario', $userName)->update([
                'password' => hash('SHA256', $newPassword),
            ]);
    
            $guestName = $guest->nombreInvitado . ' ' . $guest->apellidosInvitado;
            $email = new Credentials($userName, $newPassword, $guestName);
            Mail::to($guestEmail)->send($email);
            return to_route('showLogin')->with('exitoRestablecer','La contraseña del usuario ha sido restablecida');
        } else if($user->nivel ==2){
            $studentUDB = DB::table('estudianteUDB')->where('carnetUDB','=', $user->idUsuario)->first();   
            $studentUDBEmail = $studentUDB->correoUDB;  
            $newPassword = $this->generatePass();
            DB::table('usuario')->where('usuario', $userName)->update([
                'password' => hash('SHA256', $newPassword),
            ]);
            $studentUDBName = $studentUDB->nombreUDB . ' ' . $studentUDB->apellidosUDB;
            $email = new Credentials($userName, $newPassword, $studentUDBName);
            Mail::to($studentUDBEmail)->send($email);
            return to_route('showLogin')->with('exitoRestablecer','La contraseña del usuario ha sido restablecida');
        }
    }
}
