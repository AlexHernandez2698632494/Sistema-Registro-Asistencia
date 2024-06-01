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
use App\Models\estudianteOtraInstitucion;
use App\Models\Usuarios;
use App\Models\eventos;
use Exception;

class GuestSiteOtherInstitutionController extends Controller
{
    //
    public function student(){
        return view('StudentGuestSite.index');
    }

    public function site () {
        if(session()->has('estudianteInstitucion')){
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
            return view('StudentGuestSite.site',compact('formativa','entrenimiento','guestInfo'));
         }else{
             return view('layout.403');            
        }  
     }

     public function show(string $id)
    {
        if (session()->has('estudianteInstitucion')) {
            $eventInfo = DB::table('eventos as e')
                            ->join('areaformativaentretenimientoevento as afee', 'afee.idEvento', '=', 'e.idEvento')
                            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                            ->join('areaformativaentretenimiento as afe', 'afe.idAreaformativaentretenimiento', '=', 'a.idAreaformativaentretenimiento')
                            ->where('idEvento','=',$id)
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
            'nombre' => ['required', 'max:255', 'string'],
            'apellidos' => ['required', 'max:255', 'string'],
            'sexo' => ['required', 'max:10', 'string'],
            'carnet' => ['required', 'max:50', 'string'],
            'nivelEducativo' => ['required', 'max:255', 'string'],
            'institucion' => ['required', 'max:255', 'string'],
            'correo' => ['required', 'max:255', 'string'],
            'telefono' => ['required', 'max:10', 'string'],
            'departamento' => ['required', 'max:255', 'string'],
            'municipio' => ['required', 'max:255', 'string'],
        ]);

        try{
            DB::beginTransaction();
            $nombre = $request->input('nombre');
            $apellidos = $request->input('apellidos');
            $sexo = $request->input('sexo');
            $carnet = $request->input('carnet');
            $nivelEducativo = $request->input('nivelEducativo');
            $institucion = $request->input('institucion');
            $correo = $request->input('correo');
            $telefono = $request->input('telefono');
            $departamento = $request->input('departamento');
            $municipio = $request->input('municipio');

            $UDB = new estudianteOtraInstitucion();
            $UDB->nombreInstitucion = $nombre;
            $UDB->apellidosInstitucion = $apellidos;
            $UDB->sexoInstitucion = $sexo;
            $UDB->carnetInstitucion = $carnet;
            $UDB->nivelEducativo = $nivelEducativo;
            $UDB->institucion = $institucion;
            $UDB->correoInstitucion = $correo;
            $UDB->telefonoInstitucion = $telefono;
            $UDB->departamentoInstitucion = $departamento;
            $UDB->municipioInstitucion = $municipio;
            $UDB->estadoEliminacion = 1;

            //envio de credenciales al invitado
         $guestEmail = $request->input('correo');
         $guestName = $request->input('nombre').''.$request->input('apellidos');
        
         $userName = $carnet;
         $pass = $this->generatePass();
        
         $userObj = new Usuarios();
         $userObj->idUsuario = $request->input('carnet');
         $userObj->usuario = $userName;
         $userObj->password = hash('SHA256',$pass);
         $userObj->nivel = 5;
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
        if(session()->has('estudianteInstitucion')){
            $id= session()->get('estudiante');
            $informacionUDB = DB::table('estudiante')->where('idUDB','=',$id[0]->idUDB)->get();
            return view('StudentGuestSite.miPerfil', compact('informacionUDB'));
        } else{
            return view('layout.403');
        }
    }

    public function updateInfor(Request $request)
    {
        if (session()->has('estudiante')) {
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
                $UDB = estudianteOtraInstitucion::findOrFail($request->input('idInvitadoActualizar'));
                $UDB->correoInstitucion = $request->input('correoUDB');
                $UDB->telefonoInstitucion = $request->input('telefonoUDB');
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
