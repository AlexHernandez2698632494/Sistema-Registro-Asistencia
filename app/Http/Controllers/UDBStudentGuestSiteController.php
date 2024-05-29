<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\estudianteUDB;
use App\Mail\Credentials;
use App\Models\Usuarios;
use App\Models\eventos;
use Exception;

class UDBStudentGuestSiteController extends Controller
{
    //
    public function studentUDB(){
        return view('UDBStudentGuestSite.index');
    }

    public function site () {
        if(session()->has('estudianteUDB')){
            // $guestInfo = DB::table('Eventos')
            //                 ->select('NombreEvento','fecha','hora','precio','idEvento')
            //                 ->get();
            $guestInfo = DB::table('areaFormativaEntretenimientoEvento as afee')
                                ->join('eventos as e','e.idEvento','=', 'afee.idEvento')
                                ->join('areas as a','a.idAreas','=','afee.idAreas') 
                                ->join('areaFormativaEntretenimiento as afe','afe.idAreaFormativaEntretenimiento','=','a.idAreaFormativaEntretenimiento')
                                ->select('e.NombreEvento','e.fecha','e.hora','e.precio','e.idEvento','e.descripcion','a.nombre','afe.nombreArea')
                                ->get();
           // return $guestInfo;
            return view('UDBStudentGuestSite.site',compact('guestInfo'));
         }else{
             return view('layout.403');            
        }  
     }

     public function show(string $id)
    {
        if (session()->has('invitado')) {
            $eventInfo = DB::table('eventos as e')
                            ->join('areaformativaentretenimientoevento as afee', 'afee.idEvento', '=', 'e.idEvento')
                            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                            ->join('areaformativaentretenimiento as afe', 'afe.idAreaformativaentretenimiento', '=', 'a.idAreaformativaentretenimiento')
                            ->get();
            //return $eventInfo;
            return view('guestSite.eventInformation', compact('eventInfo'));
        } else {
            return view('layout.403');
        }
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
            'nombreUDB' => ['required', 'max:255', 'string'],
            'apellidosUDB' => ['required', 'max:255', 'string'],
            'sexo' => ['required', 'max:10', 'string'],
            'carnetUDB' => ['required', 'max:10', 'string'],
            'carrera' => ['required', 'max:255', 'string'],
            'correoUDB' => ['required', 'max:255', 'string'],
            'telefonoUDB' => ['required', 'max:10', 'string'],
            'departamento' => ['required', 'max:255', 'string'],
            'municipio' => ['required', 'max:255', 'string'],
        ]);

        try{
            DB::beginTransaction();
            $nombreUDB = $request->input('nombreUDB');
            $apellidosUDB = $request->input('apellidosUDB');
            $sexoUDB = $request->input('sexo');
            $carnetUDB = $request->input('carnetUDB');
            $carreraUDB = $request->input('carrera');
            $correoUDB = $request->input('correoUDB');
            $telefonoUDB = $request->input('telefonoUDB');
            $departamentoUDB = $request->input('departamento');
            $municipioUDB = $request->input('municipio');

            $UDB = new estudianteUDB();
            $UDB->nombreUDB = $nombreUDB;
            $UDB->apellidosUDB = $apellidosUDB;
            $UDB->sexoUDB = $sexoUDB;
            $UDB->carnetUDB = $carnetUDB;
            $UDB->carreraUDB = $carreraUDB;
            $UDB->correoUDB = $correoUDB;
            $UDB->telefonoUDB = $telefonoUDB;
            $UDB->departamentoUDB = $departamentoUDB;
            $UDB->municipioUDB = $municipioUDB;
            $UDB->estadoEliminacion = 1;

            //envio de credenciales al invitado
         $guestEmail = $request->input('correoUDB');
         $guestName = $request->input('nombreUDB').''.$request->input('apellidosUDB');
        
         $userName = $carnetUDB;
         $pass = $this->generatePass();
        
         $userObj = new Usuarios();
         $userObj->idUsuario = $request->input('carnetUDB');
         $userObj->usuario = $userName;
         $userObj->password = hash('SHA256',$pass);
         $userObj->nivel = 2;
         $userObj->save();

         if($UDB->save() && $userObj->save()){
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

    public function miPerfil(){
        if(session()->has('estudianteUDB')){
            $id= session()->get('estudianteUDB');
            $informacionUDB = DB::table('estudianteUDB')->where('idUDB','=',$id[0]->idUDB)->get();
            return view('UDBStudentGuestSite.miPerfil', compact('informacionUDB'));
        } else{
            return view('layout.403');
        }
    }

    public function updateInfor(Request $request)
    {
        if (session()->has('estudianteUDB')) {
            $validator = Validator::make($request->all(), [
                'correoUDB' => 'required|email',
                'telefonoUDB' => [
                    'required',
                    'regex:/^[267]\d{3}-\d{4}$/'
                ]
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                $UDB = estudianteUDB::findOrFail($request->input('idInvitadoActualizar'));
                $UDB->correoUDB = $request->input('correoUDB');
                $UDB->telefonOUDB = $request->input('telefonoUDB');
                $UDB->save();

                return redirect()->back()->with('exitoModificar', 'Información actualizada correctamente');
            } catch (\Exception $e) {
                return redirect()->back()->with('errorModificar', 'Hubo un error al actualizar la información');
            }
        } else {
            return view('layout.403');
        }
    }
}
