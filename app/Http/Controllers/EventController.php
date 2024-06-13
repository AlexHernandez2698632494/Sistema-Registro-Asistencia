<?php

namespace App\Http\Controllers;

use App\Models\areaFormativaEntretenimiento;
use App\Models\Areas;
use App\Models\eventos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    //
    public function index()
    {
        if (session()->has('administrador')) {
            //$events = eventos::where('estadoEliminacion', "=", "1")->get();
            $events = DB::table('eventos')->join('areaFormativaEntretenimientoEvento','areaFormativaEntretenimientoEvento.idEvento', '=', 'Eventos.idEvento')
            ->join('Areas','Areas.idAreas', '=', 'areaFormativaEntretenimientoEvento.idAreas')
            ->join('areaFormativaEntretenimiento', 'areaFormativaEntretenimiento.idAreaFormativaEntretenimiento', '=', 'Areas.idAreaFormativaEntretenimiento')
            ->select('Eventos.*','areaFormativaEntretenimiento.nombreArea','Areas.nombre')->where('Eventos.estadoEliminacion','=',1)->get();
            return view('event.index', compact('events'));
        } else {
            return view('layout.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        if (session()->has('administrador')) {
            // $areas = DB::table('Areas')->where('estadoEliminacion', '=', 1)->get();
            // $areaformativaentretenimiento = areaFormativaEntretenimiento::all();
            $formativa = DB::table('Areas as a')
                ->join('areaFormativaEntretenimiento as afe', 'a.idAreaFormativaEntretenimiento', '=', 'afe.idAreaFormativaEntretenimiento')
                ->where('a.estadoEliminacion', '=', 1)
                ->where('afe.nombreArea', '=', 'Area Formativa')
                ->select(
                    'afe.idareaFormativaEntretenimiento',
                    'afe.nombreArea',
                    'afe.nivel',
                    'a.idAreas',
                    'a.nombre',
                    'a.idAreaFormativaEntretenimiento',
                    // 'a.estadoEliminacion'
                )
                ->get();
            $entretenimiento = DB::table('Areas as a')
            ->join('areaFormativaEntretenimiento as afe', 'a.idAreaFormativaEntretenimiento', '=', 'afe.idAreaFormativaEntretenimiento')
            ->where('a.estadoEliminacion', '=', 1)
            ->where('afe.nombreArea', '=', 'Area Entretenimiento')
            ->select(
                'afe.idareaFormativaEntretenimiento',
                'afe.nombreArea',
                'afe.nivel',
                'a.idAreas',
                'a.nombre',
                'a.idAreaFormativaEntretenimiento'
            )->get();
            //return $formativa;
            return view('event.add', compact('formativa', 'entretenimiento'));
        } else {
            return view('layout.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(session()->has('administrador')){
            $validator = Validator::make($request->all(), [
                'eventName' => ['required'],
                'eventLocation' => ['required'],
                'eventDate' => ['required', 'date'],
                'eventTime' => ['required', 'date_format:H:i'],
                'eventDescription' => ['required'],
                'eventPrice' => ['required', 'string'],
                'eventImage' => ['required', 'image'],
                'eventCapacity' => ['required', 'integer'],
                'areas' => ['required', 'array', 'size:1'],
            ], [
                'eventPrice.string' => 'Formato incorrecto de Precio.',
                'eventImage.image' => 'El archivo debe ser una imagen.',
                'eventCapacity.integer' => 'La capacidad debe ser un número entero.',
                'areas.required' => 'Debe seleccionar una área.',
                'areas.size' => 'Solo puede seleccionar una área.'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            DB::beginTransaction();
            try{
                $event = new eventos();
    
                if ($request->hasFile('eventImage')) {
                    $file = $request->file('eventImage');
                    $destinationPath = public_path('imagen');
                    $fileName = time() . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $fileName);
                    $event->imagen = 'imagen/' . $fileName;
                }
    
                $event->NombreEvento = $request->input('eventName');
                $event->lugar = $request->input('eventLocation');
                $event->fecha = $request->input('eventDate');
                $event->hora = $request->input('eventTime');
                $event->descripcion = $request->input('eventDescription');
                $event->precio = $request->input('eventPrice');
                $event->capacidad = $request->input('eventCapacity');
                $event->estadoEliminacion = 1;
                $event->save();
    
                $areas = $request->input('areas');
                foreach ($areas as $areaId) {
                    DB::table('areaFormativaEntretenimientoEvento')->insert([
                        'idEvento' => $event->idEvento,
                        'idAreas' => $areaId
                    ]);
                }
    
                DB::commit();
    
                return redirect()->route('events.create')->with('exitoRegistro', 'Evento registrado exitosamente');     
            }catch(Exception $e){
                DB::rollBack();
                return redirect()->route('events.create')->with('errorRegistro', 'Error al registrar evento');     
            }
        }else{
            return view('layout.403');            
        } 
    }
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (session()->has('administrador')) {
            //echo($id);
            $eventInfo = eventos::find($id);
            $eventInfo = DB::table('Eventos')
                            ->join('areaFormativaEntretenimientoEvento','areaFormativaEntretenimientoEvento.idEvento', '=', 'Eventos.idEvento')
                            ->join('Areas','Areas.idAreas', '=', 'areaFormativaEntretenimientoEvento.idAreas')
                            ->join('areaFormativaEntretenimiento', 'areaFormativaEntretenimiento.idAreaFormativaEntretenimiento', '=', 'Areas.idAreaFormativaEntretenimiento')
                            ->select('Eventos.*','areaFormativaEntretenimiento.nombreArea','Areas.nombre')
                            ->where('Eventos.idEvento','=',$id)
                            ->get();
            $purchaseLog = DB::table('eventEntry')->where('idEvento','=',$id)->get();
            //return $eventInfo;
            return view('event.eventInformation', compact('eventInfo','purchaseLog'));
        } else {
            return view('layout.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (session()->has('administrador')) {
            $eventEdit = eventos::find($id);
            //return $event;
            return view('event.update', compact('eventEdit'));
        } else {
            return view('layout.403');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (session()->has('administrador')) {
            $eventEdit = eventos::find($id);
            $eventEdit->NombreEvento = $request->post('NombreEvento');
            $eventEdit->lugar = $request->post('lugar');
            $eventEdit->fecha = $request->post('fecha');
            $eventEdit->hora = $request->post('hora');
            $eventEdit->descripcion = $request->post('descripcion');
            $eventEdit->precio = $request->post('precio');
            $eventEdit->capacidad = $request->post('capacidad');

            // Verificar si se proporciona una nueva imagen
            if ($request->hasFile('imagen')) {
                $validator = Validator::make($request->all(), [
                    'imagen' => ['image'], // Validar que el archivo sea una imagen
                ], [
                    'imagen.image' => 'El archivo debe ser una imagen.',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Eliminar la imagen anterior si existe
                if ($eventEdit->imagen) {
                    $imagenAnterior = public_path($eventEdit->imagen);
                    if (file_exists($imagenAnterior)) {
                        unlink($imagenAnterior);
                    }
                }

                // Guardar la nueva imagen
                $event = new eventos(); // Asumiendo que tu modelo se llama Evento

                if ($request->hasFile('imagen')) {
                    $file = $request->file('imagen');
                    $destinationPath = public_path('imagen'); // Ruta absoluta para guardar en public/imagenes
                    $fileName = time() . '.' . $file->getClientOriginalExtension(); // NombreEvento único para el archivo
                    $file->move($destinationPath, $fileName);
                    $event->imagen = 'imagen/' . $fileName; // Ruta relativa para guardar en la base de datos
                }
            }
            $eventEdit->imagen = $event->imagen;
            $eventEdit->save();

            return redirect()->route("events.index")->with("exitoAgregar", "Actualizado con exito");
        } else {
            return view('layout.403');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (session()->has('administrador')) {
            //
            try {
                $request->validate([
                    'idEventoEliminar' => 'required'
                ]);

                $eventId = $request->input('idEventoEliminar');

                 $rowAffected = DB::table('Eventos')
                     ->where('idEvento', $eventId)
                     ->update(['estadoEliminacion' => 0]);
                     $rowAffected1 = DB::table('areaformativaentretenimientoevento')
                     ->where('idEvento', $eventId)
                     ->update(['estadoEliminacion' => 0]);
                if ($rowAffected == 1 && $rowAffected1) {
                    DB::commit();
                    return to_route('events.index')->with('exitoEliminacion', 'El evento ha sido eliminado correctamente');
                } else {
                    return to_route('events.index')->with('errorEliminacion', 'Ha ocurrido un error al eliminar el evento');
                }
            } catch (Exception $e) {
                return to_route('events.index')->with('errorEliminacion', 'Ha ocurrido un error al eliminar el evento');
            };
        } else {
            return view('layout.403');
        }
    }

    public function restoreView()
    {
        if (session()->has('administrador')) {
            $removedEvents = eventos::where('estadoEliminacion', '=', 0)->get();
            return view(('event.remove'), compact('removedEvents'));
        } else {
            return view('layout.403');
        }
    }

    public function restore(Request $request)
    {
        if (session()->has('administrador')) {
            $request->validate([
                'idEventoRestaurar' => ['required', 'integer']
            ]);

            $restoreEventId = $request->input('idEventoRestaurar');

            if ($restoreEventId != null) {
                try {
                    $affected = DB::table('Eventos')->where('idEvento', $restoreEventId)->update(['estadoEliminacion' => 1]);
                    $rowAffected1 = DB::table('areaformativaentretenimientoevento')
                    ->where('idEvento', $restoreEventId)
                    ->update(['estadoEliminacion' => 1]);
                    if ($affected == 1 && $rowAffected1 == 1) {
                        DB::commit();
                        return to_route('event.restoreView')->with('exitoRestaurar', 'El evento se ha restaurado correctamente');
                    } else {
                        return to_route('event.restoreView')->with('errorRestaurar', 'Ha ocurrido un error al restaurar el evento');
                    }
                } catch (Exception $e) {
                    return to_route('event.restoreView')->with('errorRestaurar', 'Ha ocurrido un error al restaurar el evento');
                }
            } else {
                return to_route('event.restoreView')->with('errorRestaurar', 'Debe de seleccionar un evento para restaurar');
            }
        } else {
            return view('layout.403');
        }
    }
    public function destroyer(Request $request)
    {
        if (session()->has('administrador')) {
            //
            try {
                $request->validate([
                    'idEventoEliminar' => 'required'
                ]);

                $eventId = $request->input('idEventoEliminar');

                DB::transaction(function () use ($eventId) {
                    // Eliminar registros en la tabla areaFormativaEntretenimientoEvento
                    DB::table('areaFormativaEntretenimientoEvento')
                        ->where('idEvento', $eventId)
                        ->delete();
    
                    // Eliminar el registro en la tabla Eventos
                    DB::table('Eventos')
                        ->where('idEvento', $eventId)
                        ->delete();
                });
                return to_route('events.index')->with('exitoEliminacion', 'El evento ha sido eliminado correctamente');
            } catch (Exception $e) {
                return to_route('events.index')->with('errorEliminacion', 'Ha ocurrido un error al eliminar el evento');
            };
        } else {
            return view('layout.403');
        }
    }
}
