<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Areas;
use App\Models\areaFormativaEntretenimiento;
use App\Models\areaFormativaEntretenimientoEvento;

class AreaController extends Controller
{
    //
    public function index()
    {
        $areas = DB::table('areaFormativaEntretenimiento')->get();
        $trainingEntertainment = DB::table('Areas')
            ->join('areaFormativaEntretenimiento', 'Areas.idAreaFormativaEntretenimiento', '=', 'areaFormativaEntretenimiento.idAreaFormativaEntretenimiento')
            ->where('Areas.estadoEliminacion', '=', 1)
            ->get();
        return view('area.index', compact('areas', 'trainingEntertainment'));
    }

    public function create()
    {
        $areas = DB::table('areaFormativaEntretenimiento')->get();
        $trainingEntertainment = DB::table('Areas')
            ->join('areaFormativaEntretenimiento', 'Areas.idAreaFormativaEntretenimiento', '=', 'areaFormativaEntretenimiento.idAreaFormativaEntretenimiento')
            ->where('Areas.estadoEliminacion', '=', 1)
            ->get();
        return view('area.add', compact('areas', 'trainingEntertainment'));
    }

    public function store(Request $request)
    {
        if (session()->has('administrador')) {
            $request->validate([
                'nombreArea' => ['required'],
                'tipoArea' => ['required', 'min:1'],
            ]);

            $area = new Areas();
            $area->nombre = $request->input('nombreArea');
            $area->idAreaFormativaEntretenimiento = $request->input('tipoArea');
            $area->estadoEliminacion = 1;
            try {
                if ($area->save()) {
                    return to_route('area.create')->with('exitoAgregar', 'Area registrada correctamente');
                } else {
                    return to_route('area.create')->with('errorAgregar', 'Ha ocurrido un error al asignar area');
                }
            } catch (Exception $e) {
                return to_route('area.create')->with('errorAgregar', 'Ha ocurrido un error al asignar area');
            }
        } else {
            return view('layout.403');
        }
    }

    public function destroy(Request $request)
    {
        if (session()->has('administrador')) {
            try {
                $request->validate([
                    'idAreaEliminar' => 'required'
                ]);

                $areaId = $request->input('idAreaEliminar');

                $rowAffected = DB::table('Areas')
                    ->where('idAreas', $areaId)
                    ->update(['estadoEliminacion' => 0]);

                if ($rowAffected == 1) {
                    return to_route('area.index')->with('exitoEliminar', 'El festival ha sido eliminado correctamente');
                } else {
                    return to_route('area.index')->with('errorEliminacion', 'Ha ocurrido un error al eliminar el festival');
                }
            } catch (Exception $e) {
                return to_route('area.index')->with('errorEliminacion', 'Ha ocurrido un error al eliminar el festival');
            };
        } else {
            return view('layout.403');
        }
    }

    public function restoreView(){
        if(session()->has('administrador')){
            $removedArea =  DB::table('Areas')
            ->join('areaFormativaEntretenimiento', 'Areas.idAreaFormativaEntretenimiento', '=', 'areaFormativaEntretenimiento.idAreaFormativaEntretenimiento')
            ->where('Areas.estadoEliminacion', '=', 0)
            ->get();
            // $removedArea = Areas::where('estadoEliminacion','=',0)->get();
        return view(('area.remove'),compact('removedArea'));     
        }else{
            return view('layout.403');            
        } 
     }

     public function restore(Request $request){
        if(session()->has('administrador')){
                $request->validate(['idAreaRestaurar' => ['required','integer']
    ]);
    
    $restoreAreaId = $request->input('idAreaRestaurar');
    
    if($restoreAreaId != null){
        try{
            $affected = DB::table('Areas')->where('idAreas',$restoreAreaId)->update(['estadoEliminacion' => 1]);
    
            if($affected ==1){
                return to_route('area.restoreView')->with('exitoRestaurar','El festival se ha restaurado correctamente');
            }else{
                return to_route('area.restoreView')->with('errorRestaurar','Ha ocurrido un error al restaurar el festival');
            }
        }catch(Exception $e){
            return to_route('area.restoreView')->with('errorRestaurar','Ha ocurrido un error al restaurar el festival');
        }
    }else{
        return to_route('area.restoreView')->with('errorRestaurar','Debe de seleccionar un festival para restaurar');
    }
      }else{
            return view('layout.403');            
        }     
    }
}
