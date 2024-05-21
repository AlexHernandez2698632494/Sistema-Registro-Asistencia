<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function store(Request $request){
        //Validar los datos ingresados por el usuario
        $request->validate([
            'nombreInvitado' => ['required', 'max:255', 'string'],
            'apellidosInvitado' => ['required', 'max:255', 'string'],
            // 'sexoInvitado' => ['required', 'max:10', 'string'],
            'duiInvitado' => ['required', 'max:10', 'string'],
            'correoInvitado' => ['required', 'max:255', 'string'],
            'telefonoInvitado' => ['required', 'max:10', 'string'],
            'departamento' => ['required', 'max:255', 'string'],
            'municipio' => ['required', 'max:255', 'string'],
            // 'departamentoInvitado' => ['required', 'max:255', 'string'],
            // 'municipioInvitado' => ['required', 'max:255', 'string'],
        ]);

        try{
            DB::beginTransaction();
            $nombreInvitado = $request->input('nombreInvitado');
            $apellidosInvitado = $request->input('apellidosInvitado');
            $sexoInvitado = $request->input('sexo');
            $duiInvitado = $request->input('duiInvitado');
            $correoInvitado = $request->input('correoInvitado');
            $telefonoInvitado = $request->input('telefonoInvitado');
            $departamentoInvitado = $request->input('departamento');
            $municipioInvitado = $request->input('municipio');

            $guest = new invitado();
            $guest->nombreInvitado = $nombreInvitado;
            $guest->apellidosInvitado = $apellidosInvitado;
            $guest->sexoInvitado = $sexoInvitado;
            $guest->duiInvitado = $duiInvitado;
            $guest->correoInvitado = $correoInvitado;
            $guest->telefonoInvitado = $telefonoInvitado;
            $guest->departamentoInvitado = $departamentoInvitado;
            $guest->municipioInvitado = $municipioInvitado;
            $guest->estadoEliminacion = 1;

            //envio de credenciales al invitado
         $guestEmail = $request->input('correoInvitado');
         $guestName = $request->input('nombreInvitado').''.$request->input('apellidosInvitado');
        
         $userName = $this->generateUser($request->input('nombreInvitado'),$request->input('apellidosInvitado'));
         $pass = $this->generatePass();
        
         $userObj = new Usuarios();
         $userObj->idUsuario = $request->input('duiInvitado');
         $userObj->usuario = $userName;
         $userObj->password = hash('SHA256',$pass);
         $userObj->nivel = 1;
         $userObj->save();

         if($guest->save() && $userObj->save()){
            $email = new Credentials($userName, $pass, $guestName);
         Mail::to($guestEmail)->send($email);
         DB::commit();
         // Redireccionar con un mensaje de éxito
         return to_route('showLogin')->with('exitoAgregar', 'Registro agregado exitosamente.');
         }else{
            DB::rollBack();
            return redirect()->back()->with('errorAgregar','Ha ocurrido un error al registrarse');
        }
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('errorAgregar','Ha ocurrido un error al registrarse'.$e->getMessage());
        } 
    }
}
