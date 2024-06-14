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
use App\Models\Entrada;
use App\Models\estudianteOtraInstitucion;
use App\Models\EventEntry;
use App\Models\Usuarios;
use App\Models\eventos;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    public function show(string $id){
        if (session()->has('estudianteInstitucion')) {
            $eventInfo = DB::table('eventos as e')
                            ->join('areaformativaentretenimientoevento as afee', 'afee.idEvento', '=', 'e.idEvento')
                            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                            ->join('areaformativaentretenimiento as afe', 'afe.idAreaformativaentretenimiento', '=', 'a.idAreaformativaentretenimiento')
                            ->where('e.idEvento','=',$id)
                            ->get();
            //return $eventInfo;
            return view('StudentGuestSite.eventInformation', compact('eventInfo'));
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

            $guest = new estudianteOtraInstitucion();
            $guest->nombreInstitucion = $nombre;
            $guest->apellidosInstitucion = $apellidos;
            $guest->sexoInstitucion = $sexo;
            $guest->carnetInstitucion = $carnet;
            $guest->nivelEducativo = $nivelEducativo;
            $guest->institucion = $institucion;
            $guest->correoInstitucion = $correo;
            $guest->telefonoInstitucion = $telefono;
            $guest->departamentoInstitucion = $departamento;
            $guest->municipioInstitucion = $municipio;
            $guest->estadoEliminacion = 1;

            //envio de credenciales al invitado
         $guestEmail = $request->input('correo');
         $guestName = $request->input('nombre').''.$request->input('apellidos');
        
         $userName = $carnet;
         $pass = $this->generatePass();
        
         $userObj = new Usuarios();
         $userObj->idUsuario = $request->input('carnet');
         $userObj->usuario = $userName;
         $userObj->password = hash('SHA256',$pass);
         $userObj->nivel = 4;
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

    public function miPerfil(){
        if(session()->has('estudianteInstitucion')){
            $id= session()->get('estudianteInstitucion');
            $informacionInstitucion = DB::table('estudianteInstitucion')->where('idInstitucion','=',$id[0]->idInstitucion)->get();
            return view('StudentGuestSite.miPerfil', compact('informacionInstitucion'));
        } else{
            return view('layout.403');
        }
    }
    
    public function updateInfor(Request $request)
    {
        if (session()->has('estudianteInstitucion')) {
            $validator = Validator::make($request->all(), [
                'correoInstitucion' => 'required|email',
                'telefonoInstitucion' => [
                    'required',
                    'regex:/^[267]\d{3}-\d{4}$/'
                ]
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            try {
                $guest = estudianteOtraInstitucion::findOrFail($request->input('idInvitadoActualizar'));
                $guest->correoInstitucion = $request->input('correoInstitucion');
                $guest->telefonoInstitucion = $request->input('telefonoInstitucion');
                $guest->save();
    
                return redirect()->back()->with('exitoModificar', 'Información actualizada correctamente');
            } catch (\Exception $e) {
                return redirect()->back()->with('errorModificar', 'Hubo un error al actualizar la información');
            }
        } else {
            return view('layout.403');
        }
    }
    public function purchaseTicketI(string $id){
        if(session()->has('estudianteInstitucion')){
            $idInstitucion = session()->get('estudianteInstitucion');
            $informacionInstitucion = DB::table('estudianteInstitucion')->where('idInstitucion', '=', $idInstitucion[0]->idInstitucion)->first();
            $evento = DB::table('Eventos')->where('idEvento', '=', $id)->first();
           
            if (!$informacionInstitucion || !$evento) {
                return redirect()->route('StudentGuestSite.site')->with('error', 'Información no disponible');
            }
   
            return view('StudentGuestSite.ticketI', compact('evento', 'informacionInstitucion'));
        } else {
            return redirect()->route('StudentGuestSite.site')->with('error', 'Sesión no iniciada');
        }
    }
    
    public function purchaseTicketG(string $id){
        if (session()->has('estudianteInstitucion')) {
            $idInstitucion = session()->get('estudianteInstitucion');
            $informacionInstitucion = DB::table('estudianteInstitucion')->where('idInstitucion', '=', $idInstitucion[0]->idInstitucion)->first();
            $evento = DB::table('Eventos')->where('idEvento', '=', $id)->first();
           
            if (!$informacionInstitucion || !$evento) {
                return redirect()->route('UDBStudentGuestSite.site')->with('error', 'Información no disponible');
            }
   
            return view('StudentGuestSite.ticketG', compact('evento', 'informacionInstitucion'));
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
            $entradasVendidas = DB::table('entradas')
            ->join('eventEntry', 'entradas.idEventEntry', '=', 'eventEntry.idEventEntry')
            ->where('eventEntry.idEvento', '=', $idEvento)
            ->sum('entradas.cantidad');

        // Verificar si la cantidad de entradas solicitadas excede la capacidad del evento
        if ($entradasVendidas >= $capacidadEvento) {
            return Redirect::back()->with('info', 'Ya no hay entradas para este evento');
        }

    
            // Generar contenido y guardar QR
            $nombreEvento = $evento->NombreEvento;              
            $id= session()->get('estudianteInstitucion');
            // $url = route('viewEventLog.entry', ['id' => $idEvento]); 
            // Generate QR code content
            $qrContent = json_encode([
                'nombre' => $request->input('nombre'),
                'evento' => $nombreEvento,
                'institucion' => $request->input('institucion'),
                //'url' => $url
            ]);
    
            // Generate QR code instance
            $qrCode = QrCode::size(150)->generate($qrContent);
    
            // Save the QR code as an image
            $currentDateTime = date('Ymd_His');
            $qrPath = 'qr/'.$request->input('nombre').'_'.$nombreEvento.'_'.$currentDateTime.'.svg'; // Save as SVG
            file_put_contents(public_path($qrPath), $qrCode);
    
            $idEstudianteUDB = 0;
            $idDocenteUDB = 0 ;
            $idPersonalUDB = 0;
            $idEstudianteInstitucion = $id[0]->idInstitucion ;
    
            // Store the entry in the database
            // Store the entry in the database
            $eventEntry = new EventEntry();
            $eventEntry->idEvento = $request->input('idEvento');
            $eventEntry->idEstudianteUDB = $idEstudianteUDB;
            $eventEntry->idDocenteUDB = $idDocenteUDB;
            $eventEntry->idPersonalUDB = $idPersonalUDB;
            $eventEntry->idEstudianteInstitucion = $idEstudianteInstitucion;
            $eventEntry->nombre = $request->input('nombre');
            $eventEntry->sexo = $request->input('sexo');
            $eventEntry->institucion = $request->input('institucion');
            $eventEntry->nivel_educativo = $request->input('nivelEducativo');
            $eventEntry->qr_code = $qrPath;
            $eventEntry->save();

            // Get the ID of the newly created event entry
            $idEventEntry = $eventEntry->idEventEntry;

            // Store the entry in the 'entradas' table
            DB::table('entradas')->insert([
                'idEventEntry' => $idEventEntry,
                'idEventEntries' => 0,
                'cantidad' => 1
            ]);

            DB::commit();

            return to_route('StudentGuestSite.purchasedTicket')->with('exitoAgregar', 'Entrada Adquirida Exitosamente'); 
        } catch(Exception $e){
            DB::rollback();
            return Redirect::back()->with('errorAgregar', 'Ha ocurrido un error al adquirir la entrada, vuelva a intentarlo más tarde'.$e->getMessage());
        }
    }
    
    public function storeEntries(Request $request)
{
    if (session()->has('estudianteInstitucion')) {
        $idInstitucion = session()->get('estudianteInstitucion');
        $idEstudianteInstitucion = $idInstitucion[0]->idInstitucion;

        $entradas = json_decode($request->entradas);

        if (count($entradas) > 0) {
            $idEvento = $request->input('idEvento');
            $evento = DB::table('eventos')->where('idEvento', '=', $idEvento)->first();

            // Verificar la capacidad del evento
            $capacidadEvento = $evento->capacidad;

            // Contar la cantidad de entradas ya vendidas para el evento
            $entradasVendidas = DB::table('entradas')
                ->join('eventEntry', 'entradas.idEventEntry', '=', 'eventEntry.idEventEntry')
                ->where('eventEntry.idEvento', '=', $idEvento)
                ->sum('entradas.cantidad');

            // Verificar si la cantidad de entradas solicitadas excede la capacidad del evento
            if ($entradasVendidas + count($entradas) > $capacidadEvento) {
                return Redirect::back()->with('info', 'Ya no hay entradas para este evento');
            }

            // Guarda la primera entrada en la tabla 'eventEntry'
            $idEventEntry = DB::table('eventEntry')->insertGetId([
                'idEvento' => $request->idEvento,
                'idEstudianteUDB' => 0,
                'idDocenteUDB' => 0,
                'idPersonalUDB' => 0,
                'idEstudianteInstitucion' =>$idEstudianteInstitucion,
                'nombre' => $entradas[0]->nombre,
                'sexo' => $entradas[0]->sexo,
                'institucion' => $entradas[0]->institucion,
                'nivel_educativo' => $entradas[0]->nivel_educativo,
                'qr_code' => '',
                'asistencia' => false,
            ]);


            // Guarda las siguientes entradas en la tabla 'eventEntries'
            for ($i = 1; $i < count($entradas); $i++) {
                DB::table('eventEntries')->insert([
                    'idEvento' => $request->idEvento,
                    'idEventEntry' => $idEventEntry,
                    'nombre' => $entradas[$i]->nombre,
                    'sexo' => $entradas[$i]->sexo,
                    'institucion' => $entradas[$i]->institucion,
                    'nivel_educativo' => $entradas[$i]->nivel_educativo,
                    'asistencia' => false,
                ]);
            }
            $idEvento = $request->input('idEvento');
            $evento = DB::table('eventos')->where('idEvento', '=', $idEvento)->first();
            // Generar contenido y guardar QR
            $nombreEvento = $evento->NombreEvento;  // Obtén el nombre del evento
            $nombrePrimeraPersona = $entradas[0]->nombre;
            $institucion = $entradas[0]->institucion;
            $cantidadPersonas = count($entradas);

            // Guarda la entrada en la tabla 'entradas'
            DB::table('entradas')->insert([
                'idEventEntry' => $idEventEntry,
                'idEventEntries' => 1,
                'cantidad' => $cantidadPersonas
            ]);

            // Generar el contenido del QR
            $qrContent = json_encode([
                'nombre' => $nombrePrimeraPersona,
                'evento' => $nombreEvento,
                'institucion' => $institucion,
                'cantidad_personas' => $cantidadPersonas,
            ]);

            // Generar la instancia del código QR
            $qrCode = QrCode::size(150)->generate($qrContent);

            // Guardar el código QR como imagen
            $currentDateTime = date('Ymd_His');
            $qrPath = 'qr/' . $nombrePrimeraPersona . '_' . $nombreEvento . '_' . $currentDateTime . '.svg'; // Guardar como SVG
            file_put_contents(public_path($qrPath), $qrCode);

            // Actualizar la entrada con la ruta del QR
            DB::table('eventEntry')->where('idEventEntry', $idEventEntry)->update(['qr_code' => $qrPath]);

            return to_route('StudentGuestSite.purchasedTicket')->with('exitoAgregar', 'Entrada Adquirida Exitosamente'); 
        } else {
            DB::rollback();
            return Redirect::back()->with('errorAgregar', 'Ha ocurrido un error al adquirir la entrada, vuelva a intentarlo más tarde');
        }
    } else {
        return redirect()->route('StudentGuestSite.site')->with('errorAgregar', 'Sesión no iniciada');
    }
}
public function purchasedTicket(){
    if(session()->has('estudianteInstitucion')){
        $id = session()->get('estudianteInstitucion');
        $informacionUDB = DB::table('estudianteInstitucion')->where('idInstitucion','=',$id[0]->idInstitucion)->first();
        $entradas = DB::table('eventEntry')
        ->join('entradas', 'entradas.idEventEntry', '=', 'eventEntry.idEventEntry')
        ->select('eventEntry.idEventEntry')
        ->where('eventEntry.nombre', '=', $informacionUDB->nombreInstitucion . ' ' . $informacionUDB->apellidosInstitucion)
        ->get();
        $purchaseTicket = DB::table('eventEntry')
        ->join('entradas', 'entradas.idEventEntry', '=', 'eventEntry.idEventEntry')
        ->join('Eventos', 'eventEntry.idEvento', '=', 'Eventos.idEvento')
        ->select('Eventos.NombreEvento', 'Eventos.fecha', 'Eventos.hora', 'eventEntry.qr_code', 'eventEntry.idEventEntry')
        ->where('eventEntry.nombre', '=', $informacionUDB->nombreInstitucion . ' ' . $informacionUDB->apellidosInstitucion)
        ->where('entradas.idEventEntries', '=', 0)  // Ajusta esto según el valor dinámico que necesites
        ->get();
        $purchaseTickets = DB::table('eventEntry')
        ->join('entradas', 'entradas.idEventEntry', '=', 'eventEntry.idEventEntry')
        ->join('eventEntries', 'eventEntries.idEventEntry', '=', 'eventEntry.idEventEntry')
        ->join('Eventos', 'eventEntry.idEvento', '=', 'Eventos.idEvento')
        ->select('Eventos.NombreEvento', 'Eventos.fecha', 'Eventos.hora', 'eventEntry.qr_code', 'eventEntry.idEventEntry')
        ->where('eventEntry.nombre', '=', $informacionUDB->nombreInstitucion . ' ' . $informacionUDB->apellidosInstitucion)
        ->where('entradas.idEventEntries', '=', 1)  // Ajusta esto según el valor dinámico que necesites
        ->get();
        //return $entradas;
        return view('StudentGuestSite.purchasedTicket',compact('purchaseTicket','purchaseTickets','entradas'));
    } else {
        return view('layout.403');
    }
    }
    
    public function deleteEntryI()
    {
        if (session()->has('estudianteInstitucion')) {
            $id = session()->get('estudianteInstitucion');
            $informacionUDB = DB::table('estudianteInstitucion')->where('idInstitucion', '=', $id[0]->idInstitucion)->first();
    
            // Obtener todos los idEventEntry relacionados con idEventEntries = 0
            $eventEntryIds = DB::table('entradas')
                ->where('idEventEntries', '=', 0)
                ->pluck('idEventEntry');
    
            // Eliminar entradas primero
            DB::table('entradas')
                ->whereIn('idEventEntry', $eventEntryIds)
                ->delete();
    
            // Luego eliminar los registros correspondientes en eventEntry
            DB::table('eventEntry')
                ->whereIn('idEventEntry', $eventEntryIds)
                ->delete();
    
            return to_route('StudentGuestSite.purchasedTicket')->with('exitoEliminar', 'Entrada eliminada Exitosamente');
        } else {
            return view('layout.403');
        }
    }
    public function deleteEntryG()
    {
        if (session()->has('estudianteInstitucion')) {
            $id = session()->get('estudianteInstitucion');
            $informacionUDB = DB::table('estudianteInstitucion')->where('idInstitucion', '=', $id[0]->idInstitucion)->first();
    
            DB::beginTransaction();
    
            try {
                // Primero, obtenemos los IDs que queremos eliminar
                $entriesToDelete = DB::table('entradas')
                    ->join('eventEntry', 'entradas.idEventEntry', '=', 'eventEntry.idEventEntry')
                    ->join('eventEntries', 'eventEntries.idEventEntry', '=', 'eventEntry.idEventEntry')
                    ->where('entradas.idEventEntries', '=', 1)
                    ->select('entradas.idEventEntry', 'entradas.idEventEntries')
                    ->get();
    
                foreach ($entriesToDelete as $entry) {
                    // Eliminamos primero de las tablas dependientes
                    DB::table('entradas')->where('idEventEntry', $entry->idEventEntry)->delete();
                    DB::table('eventEntries')->where('idEventEntry', $entry->idEventEntry)->delete();
                    DB::table('eventEntry')->where('idEventEntry', $entry->idEventEntry)->delete();
                }
    
                DB::commit();
    
                return to_route('StudentGuestSite.purchasedTicket')->with('exitoEliminar', 'Entrada eliminada Exitosamente');
            } catch (\Exception $e) {
                DB::rollBack();
                return to_route('StudentGuestSite.purchasedTicket')->with('errorEliminar', 'Error al eliminar la entrada');
            }
        } else {
            return view('layout.403');
        }
    }

}
