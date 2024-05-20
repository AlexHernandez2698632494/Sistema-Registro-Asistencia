<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
    public function index(){
        $invitados = DB::table('usuario')->join('persona','usuario.idusuario','=','persona.dui')->where('usuario.nivel','=',1)->get();
        $estudiantes = DB::table('usuario')->join('persona','usuario.idusuario','=','persona.dui')->where('usuario.nivel','=',2)->get();
        $administradores = DB::table('usuario')->join('persona','usuario.idusuario','=','persona.dui')->where('usuario.nivel','=',0)->get();
        $instituciones = DB::table('usuario')->join('persona','usuario.idusuario','=','persona.dui')->where('usuario.nivel','=',3)->get();
        //return $invitados;
        return view('users.index',compact('invitados','estudiantes','administradores','instituciones'));
    }
}
