<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\personalUDB;
use App\Mail\Credentials;
use App\Models\Usuarios;
use App\Models\eventos;
use Exception;
use App\Models\AdquirirEntrada;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class UDBStaffGuestSiteController extends Controller
{
    //
    public function personalUDB(){
        return view('UDBStaffGuestSite.index');
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
            'profesionUDB' => ['required', 'max:255', 'string'],
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
            $profesionUDB = $request->input('profesionUDB');
            $correoUDB = $request->input('correoUDB');
            $telefonoUDB = $request->input('telefonoUDB');
            $departamentoUDB = $request->input('departamento');
            $municipioUDB = $request->input('municipio');

            $UDB = new personalUDB();
            $UDB->nombreUDB = $nombreUDB;
            $UDB->apellidosUDB = $apellidosUDB;
            $UDB->sexoUDB = $sexoUDB;
            $UDB->carnetUDB = $carnetUDB;
            $UDB->profesionUDB = $profesionUDB;
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
         $userObj->nivel = 3;
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
    public function site()
    {
        if (session()->has('personalUDB')) {
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
            return view('UDBStaffGuestSite.site', compact('formativa','entrenimiento','guestInfo'));
        } else {
            return view('layout.403');
        }
    }
 
 
    public function show(string $id)
    {
        if (session()->has('personalUDB')) {
            $eventInfo = DB::table('eventos as e')
                            ->join('areaformativaentretenimientoevento as afee', 'afee.idEvento', '=', 'e.idEvento')
                            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                            ->join('areaformativaentretenimiento as afe', 'afe.idAreaformativaentretenimiento', '=', 'a.idAreaformativaentretenimiento')
                            ->where('e.idEvento','=',$id)
                            ->get();
            //return $eventInfo;
            return view('UDBStaffGuestSite.eventInformation<', compact('eventInfo'));
        } else {
            return view('layout.403');
        }
    }

public function miPerfil(){
    if(session()->has('personalUDB')){
        $id= session()->get('personalUDB');
        $informacionUDB = DB::table('personalUDB')->where('idUDB','=',$id[0]->idUDB)->get();
        return view('UDBStaffGuestSite.miPerfil', compact('informacionUDB'));
    } else{
        return view('layout.403');
    }
}

public function updateInfor(Request $request)
{
    if (session()->has('personalUDB')) {
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
            $UDB = personalUDB::findOrFail($request->input('idInvitadoActualizar'));
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
public function buyIndividualGroupTicket (){
    return view('UDBStaffGuestSite.ticketIG');
}
public function purchaseTicketI(){
return view('UDBStaffGuestSite.ticketI');
}

public function addEntry(Request $request)
    {
        // Validar los datos entrantes
        $validated = $request->validate([
            'nombre' => 'required|string|max:256',
            'sexo' => 'required|string|max:10',
            'nivel_educativo' => 'required|string',
            'institucion' => 'required|string',
        ]);

        // Crear una nueva entrada
        $entrada = new AdquirirEntrada;
        $entrada->nombres = $validated['nombre'];
        $entrada->sexo = $validated['sexo'];
        $entrada->nivelEducativo = $validated['nivel_educativo'];
        $entrada->institucion = $validated['institucion'];

        // Generar el código QR
        $qrData = $validated['nombre'] . ' - ' . $validated['institucion']; // Personaliza los datos del QR
        $qrCode = QrCode::format('png')->size(200)->generate($qrData);
        
        // Guardar el código QR como base64
        $entrada->qr = base64_encode($qrCode);
        $entrada->save();

        return redirect()->back()->with('exitoAgregar', 'Entrada Adquirida Exitosamente');
    }
    public function scan($id)
    {
        // Buscar la entrada por ID
        $entrada = AdquirirEntrada::findOrFail($id);

        // Actualizar el estado a true
        $entrada->estado = true;
        $entrada->save();
        
        return redirect()->back()->with('exitoAgregar', 'Entrada Adquirida Exitosamente');

    }
}
