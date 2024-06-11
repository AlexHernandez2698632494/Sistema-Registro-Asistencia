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
            $idUDB = session()->get('estudianteInstitucion');
            $informacionUDB = DB::table('estudianteInstitucion')->where('idInstitucion', '=', $idUDB[0]->idInstitucion)->first();
            $evento = DB::table('Eventos')->where('idEvento', '=', $id)->first();
           
            if (!$informacionUDB || !$evento) {
                return redirect()->route('StudentGuestSite.site')->with('error', 'Información no disponible');
            }
   
            return view('StudentGuestSite.ticketG', compact('evento', 'informacionInstitucion'));
        } else {
            return redirect()->route('StudentGuestSite.site')->with('error', 'Sesión no iniciada');
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
            $entrada = new Entrada();
            $entrada->idEvento = $request->input('idEvento');
            $entrada->idEstudianteUDB = $idEstudianteUDB;
            $entrada->idDocenteUDB = $idDocenteUDB ;
            $entrada->idPersonalUDB = $idPersonalUDB;
            $entrada->idEstudianteInstitucion = $idEstudianteInstitucion ;
            $entrada->nombre = $request->input('nombre');
            $entrada->sexo = $request->input('sexo');
            $entrada->institucion = $request->input('institucion');
            $entrada->nivel_educativo = $request->input('nivelEducativo');
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
        if (session()->has('estudianteInstitucion')) {
            $id= session()->get('estudianteInstitucion');
            $informacionUDB = DB::table('estudianteInstitucion')->where('idInstitucion','=',$id[0]->idInstitucion)->first();
            $purchaseTicket = DB::table('entradas')
            ->join('Eventos', 'entradas.idEvento', '=', 'Eventos.idEvento')
            ->select('Eventos.NombreEvento', 'Eventos.fecha', 'Eventos.hora', 'entradas.qr_code')
            ->where('entradas.nombre', '=', $informacionUDB->nombreInstitucion . ' ' . $informacionUDB->apellidosInstitucion)
            ->get();
            //return $purchaseTicket;
            return view('StudentGuestSite.purchasedTicket', compact('purchaseTicket'));
        } else {
            return view('layout.403');
        }
    }
    
}
