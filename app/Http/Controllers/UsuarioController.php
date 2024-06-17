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
        $personalesUDB = DB::table('usuario')->join('personalUDB','usuario.idusuario','=','personalUDB.carnetUDB')->where('usuario.nivel','=',3)->get();
        $estudiantesOtra = DB::table('usuario')->join('estudianteInstitucion','usuario.idusuario','=','estudianteInstitucion.carnetinstitucion')->where('usuario.nivel','=',5)->get();
        $administradores = DB::table('usuario')->join('administrador','usuario.idusuario','=','administrador.carnetAdmin')->where('usuario.nivel','=',0)->get();
        //return $invitados;
        return view('users.index',compact('invitados','estudiantesUDB','administradores','estudiantesOtra','personalesUDB'));
    }

    public function formContra(){
        if (session()->has('invitado')){
            return view('users.cambiarContraGuest');
        } else if (session()->has('administrador')){
            return view('users.cambiarContraAdmin');
        } else if (session()->has('estudianteUDB')){
            return view('users.cambiarContraUDBStudentGuest');
        }else if (session()->has('personalUDB')){
            return view('users.cambiarContraUDBStaffGuest');
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
        }else if(session()->has('personalUDB')){
            $UDBStudentGuestInfo = session()->get('personalUDB');
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

    public function propagandaEvento(){
        if (session()->has('administrador')) {
            $guestInfo = DB::table('Eventos')
                             ->select('NombreEvento','fecha','hora','precio','idEvento')
                             ->get();
            $formativa = DB::table('areaFormativaEntretenimientoEvento as afee')
                ->join('eventos as e', 'e.idEvento', '=', 'afee.idEvento')
                ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                ->join('areaFormativaEntretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
                ->select('e.NombreEvento', 'e.fecha', 'e.hora', 'e.precio', 'e.idEvento', 'e.descripcion', 'a.nombre', 'afe.nombreArea')
                ->where('afe.nombreArea', '=', 'Area Formativa')
                ->get();
            $entrenimiento = DB::table('areaFormativaEntretenimientoEvento as afee')
            ->join('eventos as e', 'e.idEvento', '=', 'afee.idEvento')
            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
            ->join('areaFormativaEntretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
            ->select('e.NombreEvento', 'e.fecha', 'e.hora', 'e.precio', 'e.idEvento', 'e.descripcion', 'a.nombre', 'afe.nombreArea')
            ->where('afe.nombreArea', '=', 'Area Entretenimiento')
            ->get();
            return view('users.site', compact('formativa','entrenimiento','guestInfo'));
        } else {
            return view('layout.403');
        }
    }
    
    public function send(Request $request, string $id) {
        // Obtener la información del evento
        $evento = DB::table('eventos')
                    ->where('idEvento', '=', $id)
                    ->select('nombreEvento', 'lugar', 'fecha', 'hora', 'descripcion', 'precio', 'imagen')
                    ->first();
    
        // Obtener correos electrónicos de todas las tablas
        $correosInvitados = DB::table('invitado')->where('estadoEliminacion', 1)->pluck('correoInvitado')->toArray();
        $correosEstudiantesUDB = DB::table('estudianteUDB')->where('estadoEliminacion', 1)->pluck('correoUDB')->toArray();
        $correosPersonalUDB = DB::table('personalUDB')->where('estadoEliminacion', 1)->pluck('correoUDB')->toArray();
        $correosEstudiantesInstitucion = DB::table('estudianteInstitucion')->where('estadoEliminacion', 1)->pluck('correoInstitucion')->toArray();
    
        // Combinar todos los correos electrónicos en un solo array
        $destinatarios = array_merge($correosInvitados, $correosEstudiantesUDB, $correosPersonalUDB, $correosEstudiantesInstitucion);
    
        $data = [
            'NombreEvento' => $evento->nombreEvento,
            'Lugar' => $evento->lugar,
            'Fecha' => $evento->fecha,
            'Hora' => $evento->hora,
            'Descripcion' => $evento->descripcion,
            'Precio' => $evento->precio,
            'Imagen' => $evento->imagen
        ];
    
        foreach ($destinatarios as $to_email) {
            Mail::send('email.evento', $data, function($message) use ($to_email, $evento) {
                $message->to($to_email)
                        ->subject('Información del Evento: ' . $evento->nombreEvento);
            });
        }
    
        return redirect()->back()->with('success', 'El evento ha sido enviado por correo electrónico a todos los usuarios.');
    }
    }
