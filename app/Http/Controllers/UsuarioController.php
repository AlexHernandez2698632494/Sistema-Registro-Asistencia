<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\Invitacion;
use App\Mail\Credentials;
use App\Mail\EnviarEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    //
    public function index(){
        $invitados = DB::table('usuario')->join('invitado','usuario.idusuario','=','invitado.duiInvitado')->where('usuario.nivel','=',1)->get();
        $estudiantesUDB = DB::table('usuario')->join('estudianteUDB','usuario.idusuario','=','estudianteUDB.carnetUDB')->where('usuario.nivel','=',2)->get();
        $estudiantesOtra = DB::table('usuario')->join('estudianteInstitucion','usuario.idusuario','=','estudianteInstitucion.carnetinstitucion')->where('usuario.nivel','=',3)->get();
        $administradores = DB::table('usuario')->join('administrador','usuario.idusuario','=','administrador.carnetAdmin')->where('usuario.nivel','=',0)->get();
        //return $invitados;
        return view('users.index',compact('invitados','estudiantesUDB','administradores','estudiantesOtra'));
    }

    public function formContra(){
        if (session()->has('invitado')){
            return view('users.cambiarContraGuest');
        } else if (session()->has('administrador')){
            return view('users.cambiarContraAdmin');
        } else if (session()->has('estudianteUDB')){
            return view('users.cambiarContraUDBStudentGuest');
        } else{
            return view('layout.403');
        }
    }

    public function cambiarContra(Request $request){
        if(session()->has('invitado')){
            $guestInfo = session()->get('invitado');
            $usuarioId = $guestInfo[0]->duiInvitado;

            $user = DB::table('usuario')->where('idUsuario', '=',$usuarioId)->get();

            $passwordActual = $request->input('passwordActual');
            $passwordNueva = $request->input('passwordNueva');
            $passwordConfirmar = $request->input('passwordConfirmar');
            
            if($user[0]->password == Hash('SHA256',$passwordActual)){
                if($passwordNueva == $passwordConfirmar){
                    $contra=Hash('SHA256',$passwordNueva);
                    try{
                        DB::table('usuario')->where('idUsuario','=',$usuarioId)->update(['password'=>$contra]);
            
                        return to_route('users.formContra')->with('exitoCambiar','La contraseña del usuario ha sido cambiada');
                    }
                    catch(Exception $e){
                        return to_route('users.formContra')->with('errorCambiar','La contraseña del usuario no ha sido cambiada');
                    }
                }
                else{
                    return to_route('users.formContra')->with('errorCambiar','La contraseña nueva no ha sido confirmada');
                }
            }
        }else if(session()->has('administrador')){
            $adminInfo = session()->get('administrador');
            $usuarioId = $adminInfo[0]->carnetAdmin;

            $user = DB::table('usuario')->where('idUsuario', '=',$usuarioId)->get();

            $passwordActual = $request->input('passwordActual');
            $passwordNueva = $request->input('passwordNueva');
            $passwordConfirmar = $request->input('passwordConfirmar');
            if($user[0]->password == Hash('SHA256',$passwordActual)){
                if($passwordNueva == $passwordConfirmar){
                    $contra=Hash('SHA256',$passwordNueva);
                    try{
                        DB::table('usuario')->where('idUsuario','=',$usuarioId)->update(['password'=>$contra]);
            
                        return to_route('users.formContra')->with('exitoCambiar','La contraseña del usuario ha sido cambiada');
                    }
                    catch(Exception $e){
                        return to_route('users.formContra')->with('errorCambiar','La contraseña del usuario no ha sido cambiada');
                    }
                }
                else{
                    return to_route('users.formContra')->with('errorCambiar','La contraseña nueva no ha sido confirmada');
                }
            }
            else{
                return to_route('users.formContra')->with('errorCambiar','Contraseña actual incorrecta');
            }
        }
        else if(session()->has('estudianteUDB')){
            $UDBStudentGuestInfo = session()->get('estudianteUDB');
            $usuarioId = $UDBStudentGuestInfo[0]->carnetUDB;

            $user = DB::table('usuario')->where('idUsuario', '=',$usuarioId)->get();

            $passwordActual = $request->input('passwordActual');
            $passwordNueva = $request->input('passwordNueva');
            $passwordConfirmar = $request->input('passwordConfirmar');
            if($user[0]->password == Hash('SHA256',$passwordActual)){
                if($passwordNueva == $passwordConfirmar){
                    $contra=Hash('SHA256',$passwordNueva);
                    try{
                        DB::table('usuario')->where('idUsuario','=',$usuarioId)->update(['password'=>$contra]);
            
                        return to_route('users.formContra')->with('exitoCambiar','La contraseña del usuario ha sido cambiada');
                    }
                    catch(Exception $e){
                        return to_route('users.formContra')->with('errorCambiar','La contraseña del usuario no ha sido cambiada');
                    }
                }
                else{
                    return to_route('users.formContra')->with('errorCambiar','La contraseña nueva no ha sido confirmada');
                }
            }
        }
        else{
            return view('layout.403');
        }
    }
    }
