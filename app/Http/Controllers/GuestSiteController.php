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
use Illuminate\Support\Facades\Redirect;

class GuestSiteController extends Controller
{

    public function site()
    {
        if (session()->has('invitado')) {
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

    public function generateUser(string $name, string $lastName)
    {
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

    public function generatePass()
    {
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

    public function miPerfil()
    {
        if (session()->has('invitado')) {
            $id = session()->get('invitado');
            $informacionInvitado = DB::table('invitado')->where('idInvitado', '=', $id[0]->idInvitado)->get();
            return view('guestSite.miPerfil', compact('informacionInvitado'));
        } else {
            return view('layout.403');
        }
    }

    public function updateInfor(Request $request)
    {
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

    public function buyIndividualGroupTicket (){
        return view('guestSite.ticketIG');
    }
    public function purchaseTicketI(){
        if(session()->has('invitado')){
            $id= session()->get('invitado');
            $informacionInvitado = DB::table('invitado')->where('idInvitado','=',$id[0]->idInvitado)->get();
            $eventos = DB::table('Eventos')->get();
            return view('guestSite.ticketI', compact('eventos','informacionInvitado'));
        
        }
    }
    
    public function purchaseTicketG(){
        return view('guestSite.ticketG');
    }
    
    public function addEntry(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
           'institucion' => 'required|string|max:255',
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
            $entrada->institucion = $request->input('institucion');
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
        if (session()->has('invitado')) {
            $id= session()->get('invitado');
            $informacionUDB = DB::table('invitado')->where('idUDB','=',$id[0]->idUDB)->first();
            $purchaseTicket = DB::table('entradas')->where('nombre','=',$informacionUDB->nombreUDB. ' ' .$informacionUDB->apellidosUDB)->get();
    
            $formativa = DB::table('areaFormativaEntretenimientoEvento as afee')
                ->join('eventos as e', 'e.idEvento', '=', 'afee.idEvento')
                ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                ->join('areaFormativaEntretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
                ->join('entradas as en','en.idEvento', '=', 'e.idEvento')
                ->select('e.NombreEvento', 'e.fecha', 'e.hora', 'e.precio', 'e.idEvento', 'e.descripcion', 'a.nombre', 'afe.nombreArea','en.qr_code')
                ->where('afe.nombreArea', '=', 'Area Formativa')
                ->get();
    
            $entretenimiento = DB::table('areaFormativaEntretenimientoEvento as afee')
                ->join('eventos as e', 'e.idEvento', '=', 'afee.idEvento')
                ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                ->join('areaFormativaEntretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
                ->join('entradas as en','en.idEvento', '=', 'e.idEvento')
                ->select('e.NombreEvento', 'e.fecha', 'e.hora', 'e.precio', 'e.idEvento', 'e.descripcion', 'a.nombre', 'afe.nombreArea','en.qr_code')
                ->where('afe.nombreArea', '=', 'Area Entretenimiento')
                ->get();
            
            // Aquí creamos un array de eventos para estructurar los datos por áreas
            $eventos = [
                'formativa' => $formativa,
                'entretenimiento' => $entretenimiento,
                'purchaseTicket' => $purchaseTicket
            ];
    
            return view('guestSite.purchasedTicket', compact('eventos','formativa','entretenimiento','purchaseTicket'));
        } else {
            return view('layout.403');
        }
    }
    
    }
    