<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\persona;
use App\Models\invitado;
use App\Mail\Credentials;
use App\Models\Usuarios;
use App\Models\eventos;
use Exception;

class GuestSiteController extends Controller
{
    
     public function site () {
        if(session()->has('invitado')){
            $guestInfo = DB::table('Eventos')
                            ->select('NombreEvento','fecha','hora','precio','idEvento')
                            ->get();
            //return $guestInfo;
            return view('guestSite.site',compact('guestInfo'));
         }else{
             return view('layout.403');            
        }  
     }


    public function show(string $id)
    {
        if(session()->has('invitado')){
            $eventInfo = eventos::find($id);
        //return $eventInfo;
        return view('guestSite.eventInformation',compact('eventInfo'));
    }else{
        return view('layout.403');            
   }  
}

    public function guestSite(){
        return view('guestSite.index');
    }

    public function generateUser(string $name, string $lastName)
	{
		$nameElements = explode(' ',$name);
		$lastNameElements = explode(' ',$lastName);

		$user = strtolower($nameElements[0].'.'.$lastNameElements[0]);

		$counter = 2;

		do{
			$userVerification = DB::table('usuario')
									->where('usuario', $user)
									->exists();

			if($userVerification){
				$user = strtolower($nameElements[0].'.'.$lastNameElements[0].$counter);
				$counter++;
			}

		}while($userVerification);

		return $user;		
	}

	public function generatePass()
	{
		$permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$pass = '';
		$strength = 10;

		$stringLenght = strlen($permittedChars);

		for($i = 0; $i < $strength; $i++) {
			$randomCharacter = $permittedChars[mt_rand(0, $stringLenght - 1)];
			$pass .= $randomCharacter;
		}
		return $pass;
	}

    public function store(Request $request)
    {
        // Validar los datos ingresados por el usuario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dui' => 'required|string|max:10',
            'telefono' => 'required|string|max:10',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'carrera' => 'nullable|string|max:255',
        ]);
        // Si la validación falla, redireccionar con los errores
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        // Crear una nueva persona
        $persona = new Persona();
        $persona->nombre = $request->input('nombre');
        $persona->apellido = $request->input('apellido');
        $persona->dui = $request->input('dui');
        $persona->telefono = $request->input('telefono');
        $persona->correo = $request->input('correo');
        $persona->direccion = $request->input('direccion');
        $persona->save();
        // Crear un nuevo invitado asociado a la persona
        $invitado = new Invitado();
        $invitado->idPersona = $persona->idPersona;
        $invitado->save();

        //envio de credenciales al invitado
        $guestEmail = $request->input('correo');
        $guestName = $request->input('nombre').''.$request->input('apellido');

        $userName = $this->generateUser($request->input('nombre'),$request->input('apellido'));
        $pass = $this->generatePass();

        $userObj = new Usuarios();
        $userObj->idUsuario = $request->input('dui');
        $userObj->usuario = $userName;
        $userObj->password = hash('SHA256',$pass);
        $userObj->nivel = 1;
        $userObj->save();

        $email = new Credentials($userName, $pass, $guestName);
        Mail::to($guestEmail)->send($email);
        DB::commit();
        // Redireccionar con un mensaje de éxito
        return to_route('showLogin')->with('exitoAgregar', 'Registro agregado exitosamente.');
    }
}
