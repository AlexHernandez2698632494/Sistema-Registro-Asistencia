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
}
