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
use App\Models\Entrada;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Exception;

class UDBStudentGuestSiteController extends Controller
{
    //
    public function studentUDB(){
        return view('UDBStudentGuestSite.index');
    }

    public function site()
{
    if (session()->has('estudianteUDB')) {
        $now = Carbon::now(); // Obtener la fecha y hora actual

        $guestInfo = DB::table('Eventos')
            ->select('NombreEvento','fecha','hora','precio','idEvento')
            ->where(DB::raw('CONCAT(fecha, " ", hora)'), '>', $now) // Filtrar eventos
            ->get();

        $formativa = DB::table('areaFormativaEntretenimientoEvento as afee')
            ->join('eventos as e', 'e.idEvento', '=', 'afee.idEvento')
            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
            ->join('areaFormativaEntretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
            ->select('e.NombreEvento', 'e.fecha', 'e.hora', 'e.precio', 'e.idEvento', 'e.descripcion', 'a.nombre', 'afe.nombreArea')
            ->where('afe.nombreArea', '=', 'Area Formativa')
            ->where(DB::raw('CONCAT(e.fecha, " ", e.hora)'), '>', $now) // Filtrar eventos
            ->get();

        $entrenimiento = DB::table('areaFormativaEntretenimientoEvento as afee')
            ->join('eventos as e', 'e.idEvento', '=', 'afee.idEvento')
            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
            ->join('areaFormativaEntretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
            ->select('e.NombreEvento', 'e.fecha', 'e.hora', 'e.precio', 'e.idEvento', 'e.descripcion', 'a.nombre', 'afe.nombreArea')
            ->where('afe.nombreArea', '=', 'Area Entretenimiento')
            ->where(DB::raw('CONCAT(e.fecha, " ", e.hora)'), '>', $now) // Filtrar eventos
            ->get();

        return view('UDBStudentGuestSite.site', compact('formativa', 'entrenimiento', 'guestInfo'));
    } else {
        return view('layout.403');
    }
}

     public function show(string $id)
    {
        if (session()->has('estudianteUDB')) {
            $eventInfo = DB::table('eventos as e')
                            ->join('areaformativaentretenimientoevento as afee', 'afee.idEvento', '=', 'e.idEvento')
                            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                            ->join('areaformativaentretenimiento as afe', 'afe.idAreaformativaentretenimiento', '=', 'a.idAreaformativaentretenimiento')
                            ->where('e.idEvento','=',$id)
                            ->get();
            //return $eventInfo;
            return view('UDBStudentGuestSite.eventInformation', compact('eventInfo'));
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
   
    public function purchaseTicketI(string $id){
        if (session()->has('estudianteUDB')) {
            $idUDB = session()->get('estudianteUDB');
            $informacionUDB = DB::table('estudianteUDB')->where('idUDB', '=', $idUDB[0]->idUDB)->first();
            $evento = DB::table('Eventos')->where('idEvento', '=', $id)->first();
           
            if (!$informacionUDB || !$evento) {
                return redirect()->route('UDBStudentGuestSite.site')->with('error', 'Información no disponible');
            }
   
            return view('UDBStudentGuestSite.ticketI', compact('evento', 'informacionUDB'));
        } else {
            return redirect()->route('UDBStudentGuestSite.site')->with('error', 'Sesión no iniciada');
        }
    }
    
    public function purchaseTicketG(string $id){
        if (session()->has('estudianteUDB')) {
            $idUDB = session()->get('estudianteUDB');
            $informacionUDB = DB::table('estudianteUDB')->where('idUDB', '=', $idUDB[0]->idUDB)->first();
            $evento = DB::table('Eventos')->where('idEvento', '=', $id)->first();
           
            if (!$informacionUDB || !$evento) {
                return redirect()->route('UDBStudentGuestSite.site')->with('error', 'Información no disponible');
            }
   
            return view('UDBStudentGuestSite.ticketG', compact('evento', 'informacionUDB'));
        } else {
            return redirect()->route('UDBStudentGuestSite.site')->with('error', 'Sesión no iniciada');
        }
    }
    
    public function addEntry(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'idEvento' => 'required|integer|exists:eventos,idEvento' // Ensure 'eventos' matches your actual table name
        ]);
        
        try {
            DB::beginTransaction();
            $idEvento = $request->input('idEvento');
            $evento = DB::table('eventos')->where('idEvento', '=', $idEvento)->first();
            $capacidadEvento = $evento->capacidad;
    
            // Contar las entradas vendidas para este evento
            $entradasVendidas = DB::table('entradas')->where('idEvento', '=', $idEvento)->count();
    
            // Verificar si hay capacidad disponible
            if ($entradasVendidas >= $capacidadEvento) {
                throw new Exception('No hay capacidad disponible para este evento.');
            }
    
            // Generar contenido y guardar QR
            $nombreEvento = $evento->NombreEvento;       // $url = route('viewEventLog.entry', ['id' => $idEvento]); 
            // Generate QR code content
            $qrContent = json_encode([
                'nombre' => $request->input('nombre'),
                'evento' => $nombreEvento,
                'institucion' => 'UDB',
                //'url' => $url
            ]);
    
            // Generate QR code instance
            $qrCode = QrCode::size(150)->generate($qrContent);
    
            // Save the QR code as an image
            $currentDateTime = date('Ymd_His');
            $qrPath = 'qr/'.$request->input('nombre').'_'.$nombreEvento.'_'.$currentDateTime.'.svg'; // Save as SVG
            file_put_contents(public_path($qrPath), $qrCode);
    
            $id= session()->get('estudianteUDB');
            $idEstudianteUDB = $id[0]->idUDB;
            $idDocenteUDB = 0 ;
            $idPersonalUDB = 0;
            $idEstudianteInstitucion = 0 ;
    
            // Store the entry in the database
            $entrada = new Entrada();
            $entrada->idEvento = $request->input('idEvento');
            $entrada->idEstudianteUDB = $idEstudianteUDB;
            $entrada->idDocenteUDB = $idDocenteUDB ;
            $entrada->idPersonalUDB = $idPersonalUDB;
            $entrada->idEstudianteInstitucion = $idEstudianteInstitucion ;
            $entrada->nombre = $request->input('nombre');
            $entrada->sexo = $request->input('sexo');
            $entrada->institucion = 'UDB';
            $entrada->nivel_educativo = $request->input('nivel_educativo');
            $entrada->qr_code = $qrPath;
            $entrada->save();
    
            DB::commit();
    
            return Redirect::back()->with('exitoAgregar', 'Entrada Adquirida Exitosamente');
        } catch(Exception $e){
            DB::rollback();
            return Redirect::back()->with('errorAgregar', 'Ha ocurrido un error al adquirir la entrada, vuelva a intentarlo más tarde');
        }
    }
    
    public function purchasedTicket() {
        if (session()->has('estudianteUDB')) {
            $id= session()->get('estudianteUDB');
            $informacionUDB = DB::table('estudianteUDB')->where('idUDB','=',$id[0]->idUDB)->first();
            $purchaseTicket = DB::table('entradas')
            ->join('Eventos', 'entradas.idEvento', '=', 'Eventos.idEvento')
            ->select('Eventos.NombreEvento', 'Eventos.fecha', 'Eventos.hora', 'entradas.qr_code')
            ->where('entradas.nombre', '=', $informacionUDB->nombreUDB . ' ' . $informacionUDB->apellidosUDB)
            ->get();
            return view('UDBStudentGuestSite.purchasedTicket', compact('purchaseTicket'));
        } else {
            return view('layout.403');
        }
    }

    public function addEntryG(Request $request){
        // Validate the incoming request data
        $request->validate([
            'idEvento' => 'required|integer|exists:eventos,idEvento', // Ensure 'eventos' matches your actual table name
            'entradas' => 'required|json'
        ]);
    
        try {
            DB::beginTransaction();
            $idEvento = $request->input('idEvento');
            $evento = DB::table('eventos')->where('idEvento', '=', $idEvento)->first();
            $capacidadEvento = $evento->capacidad;
    
            // Contar las entradas vendidas para este evento
            $entradasVendidas = DB::table('entradas')->where('idEvento', '=', $idEvento)->count();
    
            // Verificar si hay capacidad disponible
            if ($entradasVendidas >= $capacidadEvento) {
                throw new Exception('No hay capacidad disponible para este evento.');
            }
    
            $entradas = json_decode($request->input('entradas'), true);
            if ($entradasVendidas + count($entradas) > $capacidadEvento) {
                throw new Exception('No hay capacidad disponible para todos los miembros del grupo.');
            }
    
            $id = session()->get('estudianteUDB');
            $idEstudianteUDB = $id[0]->idUDB;
            $idDocenteUDB = 0;
            $idPersonalUDB = 0;
            $idEstudianteInstitucion = 0;
    
            // Generar contenido y guardar QR para el grupo
            $nombreEvento = $evento->NombreEvento;
            $qrContent = json_encode([
                'grupo' => $entradas,
                'evento' => $nombreEvento,
                'institucion' => 'UDB'
            ]);
    
            $qrCode = QrCode::size(150)->generate($qrContent);
            $currentDateTime = date('Ymd_His');
            $qrPath = 'qr/grupo_'.$nombreEvento.'_'.$currentDateTime.'.svg';
            file_put_contents(public_path($qrPath), $qrCode);
    
            foreach ($entradas as $entradaData) {
                // Store each entry in the database
                $entrada = new Entrada();
                $entrada->idEvento = $idEvento;
                $entrada->idEstudianteUDB = $idEstudianteUDB;
                $entrada->idDocenteUDB = $idDocenteUDB;
                $entrada->idPersonalUDB = $idPersonalUDB;
                $entrada->idEstudianteInstitucion = $idEstudianteInstitucion;
                $entrada->nombre = $entradaData['nombre'];
                $entrada->sexo = $entradaData['sexo'];
                $entrada->institucion = 'UDB';
                $entrada->nivel_educativo = $entradaData['nivel_educativo'];
                $entrada->qr_code = $qrPath;
                $entrada->save();
            }
    
            DB::commit();
    
            return Redirect::back()->with('exitoAgregar', 'Entradas adquiridas exitosamente');
        } catch(Exception $e){
            DB::rollback();
            return Redirect::back()->with('errorAgregar', 'Ha ocurrido un error al adquirir las entradas, vuelva a intentarlo más tarde')->getMessage($e);
        }
    }
    
        
}
    