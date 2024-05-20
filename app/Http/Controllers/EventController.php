<?php

namespace App\Http\Controllers;

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
    if(session()->has('administrador')){
            $events=eventos::where('estadoEliminacion',"=","1")->get();
   return view('event.index', compact('events'));   
    }else{
        return view('layout.403');            
    }   
}

/**
 * Show the form for creating a new resource.
 */
public function create()
{
    if(session()->has('administrador')){
             $events=eventos::all();
    return view('event.add',compact('events'));
    }else{
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
            'eventImage' => ['required', 'image'], // Cambiado de 'url' a 'image'
        ], [
            'eventPrice.string' => 'Formato incorrecto de Precio.',
            'eventImage.image' => 'El archivo debe ser una imagen.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $event = new eventos(); // Asumiendo que tu modelo se llama Evento

        if ($request->hasFile('eventImage')) {
            $file = $request->file('eventImage');
            $destinationPath = public_path('imagen'); // Ruta absoluta para guardar en public/imagenes
            $fileName = time() . '.' . $file->getClientOriginalExtension(); // NombreEvento único para el archivo
            $file->move($destinationPath, $fileName);
            $event->imagen = 'imagen/' . $fileName; // Ruta relativa para guardar en la base de datos
        }

        $event->NombreEvento = $request->input('eventName');
        $event->lugar = $request->input('eventLocation');
        $event->fecha = $request->input('eventDate');
        $event->hora = $request->input('eventTime');
        $event->descripcion = $request->input('eventDescription');
        $event->precio = $request->input('eventPrice');
        $event->estadoEliminacion = 1;
        $event->save();

        return redirect()->route('events.create')->with('exitoRegistro', 'Evento registrado exitosamente');     
    }else{
        return view('layout.403');            
    } 
}
    

/**
 * Display the specified resource.
 */
public function show(string $id)
{
    if(session()->has('administrador')){
        //echo($id);
    $eventInfo = eventos::find($id);
    //return $eventInfo;
   return view('event.eventInformation',compact('eventInfo'));    
    }else{
        return view('layout.403');            
    }  
}

/**
 * Show the form for editing the specified resource.
 */
public function edit(string $id)
{
    if(session()->has('administrador')){
            $eventEdit = eventos::find($id);
    //return $event;
    return view('event.update', compact('eventEdit'));

    }else{
        return view('layout.403');            
    }   
}
/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    if(session()->has('administrador')){
          $eventEdit = eventos::find($id);
   $eventEdit->NombreEvento = $request->post('NombreEvento');
   $eventEdit->lugar = $request->post('lugar');
    $eventEdit->fecha = $request->post('fecha');
    $eventEdit->hora = $request->post('hora');
    $eventEdit->descripcion = $request->post('descripcion');
   $eventEdit->precio = $request->post('precio');

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
   $eventEdit->imagen= $event->imagen;
   $eventEdit->save();

return redirect()->route("events.index")->with("exitoAgregar","Actualizado con exito");     
    }else{
        return view('layout.403');            
    } 
    
}
/**
 * Remove the specified resource from storage.
 */
public function destroy(Request $request)
{
    if(session()->has('administrador')){
     //
    try{
        $request->validate([
            'idEventoEliminar' => 'required'
        ]);

        $eventId = $request->input('idEventoEliminar');

        $rowAffected = DB::table('Eventos')
                        ->where('idEvento', $eventId)
                        ->update(['estadoEliminacion' => 0]);

        if($rowAffected == 1){
            return to_route('events.index')->with('exitoEliminacion','El evento ha sido eliminado correctamente');
        }else{
            return to_route('events.index')->with('errorEliminacion','Ha ocurrido un error al eliminar el evento');
        }
    }catch(Exception $e){
        return to_route('events.index')->with('errorEliminacion','Ha ocurrido un error al eliminar el evento');
    };       
    }else{
        return view('layout.403');            
    }  
 }

 public function restoreView(){
    if(session()->has('administrador')){
        $removedEvents = eventos::where('estadoEliminacion','=',0)->get();
    return view(('event.remove'),compact('removedEvents'));     
    }else{
        return view('layout.403');            
    } 
 }

 public function restore(Request $request){
    if(session()->has('administrador')){
            $request->validate(['idEventoRestaurar' => ['required','integer']
]);

$restoreEventId = $request->input('idEventoRestaurar');

if($restoreEventId != null){
    try{
        $affected = DB::table('Eventos')->where('idEvento',$restoreEventId)->update(['estadoEliminacion' => 1]);

        if($affected ==1){
            return to_route('event.restoreView')->with('exitoRestaurar','El evento se ha restaurado correctamente');
        }else{
            return to_route('event.restoreView')->with('errorRestaurar','Ha ocurrido un error al restaurar el evento');
        }
    }catch(Exception $e){
        return to_route('event.restoreView')->with('errorRestaurar','Ha ocurrido un error al restaurar el evento');
    }
}else{
    return to_route('event.restoreView')->with('errorRestaurar','Debe de seleccionar un evento para restaurar');
}
  }else{
        return view('layout.403');            
    }     
}
}