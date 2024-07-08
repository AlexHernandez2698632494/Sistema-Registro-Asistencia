<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\invitado;
use App\Mail\Credentials;
use App\Models\AdquirirEntrada;
use App\Models\Usuarios;
use App\Models\eventos;
use Exception;
use App\Models\Entrada;
use App\Models\EventEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class GuestSiteController extends Controller
{

    public function site()
    {
        if (session()->has('invitado')) {
            $now = Carbon::now(); // Obtener la fecha y hora actual

            $guestInfo = DB::table('Eventos')
                ->select('NombreEvento','fecha','hora','precio','idEvento')
                ->where(DB::raw('CONCAT(fecha, " ", hora)'), '>', $now) // Filtrar eventos
                ->where('estadoEliminacion', '=', '1')
                ->get();
                $formativa = DB::table('areaFormativaEntretenimientoEvento as afee')
                ->join('eventos as e', 'e.idEvento', '=', 'afee.idEvento')
                ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                ->join('areaFormativaEntretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
                ->select('e.NombreEvento', 'e.fecha', 'e.hora', 'e.precio', 'e.idEvento', 'e.descripcion', 'a.nombre', 'afe.nombreArea')
                ->where('afe.nombreArea', '=', 'Area Formativa')
                ->where('e.estadoEliminacion', '=', '1')
                                ->get();
            $entrenimiento = DB::table('areaFormativaEntretenimientoEvento as afee')
            ->join('eventos as e', 'e.idEvento', '=', 'afee.idEvento')
            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
            ->join('areaFormativaEntretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
            ->select('e.NombreEvento', 'e.fecha', 'e.hora', 'e.precio', 'e.idEvento', 'e.descripcion', 'a.nombre', 'afe.nombreArea')
            ->where('afe.nombreArea', '=', 'Area Entretenimiento')
            ->where('e.estadoEliminacion', '=', '1')
            ->get();
            return view('guestSite.site', compact('formativa','entrenimiento','guestInfo'));
        } else {
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
                            ->where('e.idEvento','=',$id)
                            ->get();
            //return $eventInfo;
            return view('guestSite.eventInformation', compact('eventInfo'));
        } else {
            return view('layout.403');
        }
    }

    public function guestSite()
    {
        return view('guestSite.index');
    }

    public function generateUser(string $name, string $lastName){
        $nameElements = explode(' ', $name);
        $lastNameElements = explode(' ', $lastName);

        $user = strtolower($nameElements[0] . '.' . $lastNameElements[0]);

        $counter = 2;

        do {
            $userVerification = DB::table('usuario')
                ->where('usuario', $user)
                ->exists();

            if ($userVerification) {
                $user = strtolower($nameElements[0] . '.' . $lastNameElements[0] . $counter);
                $counter++;
            }
        } while ($userVerification);

        return $user;
    }

    public function generatePass(){
        $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pass = '';
        $strength = 10;

        $stringLenght = strlen($permittedChars);

        for ($i = 0; $i < $strength; $i++) {
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

        try {
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
            $guestName = $request->input('nombreInvitado') . '' . $request->input('apellidosInvitado');

            $userName = $this->generateUser($request->input('nombreInvitado'), $request->input('apellidosInvitado'));
            $pass = $this->generatePass();

            $userObj = new Usuarios();
            $userObj->idUsuario = $request->input('duiInvitado');
            $userObj->usuario = $userName;
            $userObj->password = hash('SHA256', $pass);
            $userObj->nivel = 1;
            $userObj->save();

            if ($guest->save() && $userObj->save()) {
                $email = new Credentials($userName, $pass, $guestName);
                Mail::to($guestEmail)->send($email);
                DB::commit();
                // Redireccionar con un mensaje de éxito
                return to_route('showLogin')->with('exitoAgregar', 'Registro agregado exitosamente.');
            } else {
                DB::rollBack();
                return redirect()->back()->with('errorAgregar', 'Ha ocurrido un error al registrarse');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errorAgregar', 'Ha ocurrido un error al registrarse' . $e->getMessage());
        }
    }

    public function miPerfil(){
        if (session()->has('invitado')) {
            $id = session()->get('invitado');
            $informacionInvitado = DB::table('invitado')->where('idInvitado', '=', $id[0]->idInvitado)->get();
            return view('guestSite.miPerfil', compact('informacionInvitado'));
        } else {
            return view('layout.403');
        }
    }

    public function updateInfor(Request $request){
        if (session()->has('invitado')) {
            $validator = Validator::make($request->all(), [
                'correoInvitado' => 'required|email',
                'telefonoInvitado' => [
                    'required',
                    'regex:/^[267]\d{3}-\d{4}$/'
                ]
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                $invitado = Invitado::findOrFail($request->input('idInvitadoActualizar'));
                $invitado->correoInvitado = $request->input('correoInvitado');
                $invitado->telefonoInvitado = $request->input('telefonoInvitado');
                $invitado->save();

                return redirect()->back()->with('exitoModificar', 'Información actualizada correctamente');
            } catch (\Exception $e) {
                return redirect()->back()->with('errorModificar', 'Hubo un error al actualizar la información');
            }
        } else {
            return view('layout.403');
        }
    }

    public function purchaseTicketI(string $id){
        if (session()->has('invitado')) {
            $idInvitado = session()->get('invitado');
            $informacionInvitado = DB::table('invitado')->where('idInvitado', '=', $idInvitado[0]->idInvitado)->first();
            $evento = DB::table('Eventos')->where('idEvento', '=', $id)->first();
            
            if (!$informacionInvitado || !$evento) {
                return redirect()->route('guestSite.site')->with('error', 'Información no disponible');
            }
    
            return view('guestSite.ticketI', compact('evento', 'informacionInvitado'));
        } else {
            return redirect()->route('guestSite.site')->with('error', 'Sesión no iniciada');
        }
    }
        
    public function purchaseTicketG(string $id){
        if (session()->has('invitado')) {
            $idGuest = session()->get('invitado');
            $informacionInvitado = DB::table('invitado')->where('idInvitado', '=', $idGuest[0]->idInvitado)->first();
            $evento = DB::table('Eventos')->where('idEvento', '=', $id)->first();
           
            if (!$informacionInvitado || !$evento) {
                return redirect()->route('guestSite.site')->with('error', 'Información no disponible');
            }
   
            return view('guestSite.ticketG', compact('evento', 'informacionInvitado'));
        } else {
            return redirect()->route('guestSite.site')->with('error', 'Sesión no iniciada');
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
            $id= session()->get('invitado');
            $idInvitado = $id[0]->idInvitado;
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
            $idInvitado = $idInvitado;
            $idEstudianteUDB = 0;
            $idDocenteUDB = 0 ;
            $idPersonalUDB = 0;
            $idEstudianteInstitucion = 0;
    
            // Store the entry in the database
            $eventEntry = new EventEntry();
            $eventEntry->idEvento = $request->input('idEvento');
            $eventEntry->idInvitado = $idInvitado;
            $eventEntry->idEstudianteUDB = $idEstudianteUDB;
            $eventEntry->idDocenteUDB = $idDocenteUDB;
            $eventEntry->idPersonalUDB = $idPersonalUDB;
            $eventEntry->idEstudianteInstitucion = $idEstudianteInstitucion;
            $eventEntry->nombre = $request->input('nombre');
            $eventEntry->sexo = $request->input('sexo');
            $eventEntry->institucion = $request->input('institucion');
            $eventEntry->nivel_educativo = $request->input('nivel_educativo');
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

            return to_route('guestSite.purchasedTicket')->with('exitoAgregar', 'Entrada Adquirida Exitosamente'); 
        } catch(Exception $e){
            DB::rollback();
            return Redirect::back()->with('errorAgregar', 'Ha ocurrido un error al adquirir la entrada, vuelva a intentarlo más tarde'.$e->getMessage());
        }
    }
public function storeEntries(Request $request)
{
    if (session()->has('invitado')) {
        $idGuest = session()->get('invitado');
        $idInvitado = $idGuest[0]->idInvitado;

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
                'idInvitado' => $idInvitado,
                'idEstudianteUDB' => 0,
                'idDocenteUDB' => 0,
                'idPersonalUDB' => 0,
                'idEstudianteInstitucion' => 0,
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

            return to_route('guestSite.purchasedTicket')->with('exitoAgregar', 'Entrada Adquirida Exitosamente');
        } else {
            return redirect()->route('guestSite.ticketG', ['id' => $request->idEvento])->with('errorAgregar', 'No hay entradas para guardar');
        }
    } else {
        return redirect()->route('guestSite.site')->with('errorAgregar', 'Sesión no iniciada');
    }
}
public function purchasedTicket(){
    if(session()->has('invitado')){
        $id = session()->get('invitado');
        $informacionUDB = DB::table('invitado')->where('idInvitado','=',$id[0]->idInvitado)->first();
        $entradas = DB::table('eventEntry')
        ->join('entradas', 'entradas.idEventEntry', '=', 'eventEntry.idEventEntry')
        ->select('eventEntry.idEventEntry')
        ->where('eventEntry.nombre', '=', $informacionUDB->nombreInvitado . ' ' . $informacionUDB->apellidosInvitado)
        ->get();
        $purchaseTicket = DB::table('eventEntry')
        ->join('entradas', 'entradas.idEventEntry', '=', 'eventEntry.idEventEntry')
        ->join('Eventos', 'eventEntry.idEvento', '=', 'Eventos.idEvento')
        ->select('Eventos.NombreEvento', 'Eventos.fecha', 'Eventos.hora', 'eventEntry.qr_code', 'eventEntry.idEventEntry')
        ->where('eventEntry.nombre', '=', $informacionUDB->nombreInvitado . ' ' . $informacionUDB->apellidosInvitado)
        ->where('entradas.idEventEntries', '=', 0)  // Ajusta esto según el valor dinámico que necesites
        ->get();
        $purchaseTickets = DB::table('eventEntry')
        ->join('entradas', 'entradas.idEventEntry', '=', 'eventEntry.idEventEntry')
        ->join('Eventos', 'eventEntry.idEvento', '=', 'Eventos.idEvento')
        ->select('Eventos.NombreEvento', 'Eventos.fecha', 'Eventos.hora', 'eventEntry.qr_code', 'eventEntry.idEventEntry')
        ->where('eventEntry.nombre', '=', $informacionUDB->nombreInvitado . ' ' . $informacionUDB->apellidosInvitado)
        ->where('entradas.idEventEntries', '=', 1)  // Ajusta esto según el valor dinámico que necesites
        ->get();
        //return $entradas;
        return view('guestSite.purchasedTicket',compact('purchaseTicket','purchaseTickets','entradas'));
    } else {
        return view('layout.403');
    }
    }
    
    public function deleteEntryI()
    {
        if (session()->has('invitado')) {
            $id = session()->get('invitado');
            $informacionUDB = DB::table('invitado')->where('idInvitado', '=', $id[0]->idInvitado)->first();
    
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
    
            return to_route('guestSite.purchasedTicket')->with('exitoEliminar', 'Entrada eliminada Exitosamente');
        } else {
            return view('layout.403');
        }
    }
    public function deleteEntryG()
    {
        if (session()->has('invitado')) {
            $id = session()->get('invitado');
            $informacionUDB = DB::table('invitado')->where('idInvitado', '=', $id[0]->idInvitado)->first();
    
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
    
                return to_route('guestSite.purchasedTicket')->with('exitoEliminar', 'Entrada eliminada Exitosamente');
            } catch (\Exception $e) {
                DB::rollBack();
                return to_route('guestSite.purchasedTicket')->with('errorEliminar', 'Error al eliminar la entrada');
            }
        } else {
            return view('layout.403');
        }
    }

    }
    