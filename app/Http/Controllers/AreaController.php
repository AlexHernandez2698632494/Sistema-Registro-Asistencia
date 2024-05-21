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
    public function index(){
        return view('area.index');
    }

    public function create(){
        $areas = DB::table('areaFormativaEntretenimiento')->get();
        $trainingEntertainment = DB::table('Areas')
                                    ->join('areaFormativaEntretenimiento','Areas.idAreaFormativaEntretenimiento','=','areaFormativaEntretenimiento.idAreaFormativaEntretenimiento')
                                    ->where('Areas.estadoEliminacion','=',1)                            
                                    ->get();
        return view('area.add', compact('areas','trainingEntertainment'));
    }
    
    public function store(Request $request){
        if(session()->has('administrador')){
            $request->validate([
            'nombreArea' => ['required'],
            'tipoArea' => ['required', 'min:1'],
        ]);

        $area = new Areas();
        $area->nombre = $request->input('nombreArea');
        $area->idAreaFormativaEntretenimiento = $request->input('tipoArea');
        $area->estadoEliminacion = 1;
        try{
            if($area->save()){
                return to_route('area.create')->with('exitoAgregar','Area registrada correctamente');
            }else{
                return to_route('area.create')->with('errorAgregar','Ha ocurrido un error al asignar area');
            }

        }catch(Exception $e){
            return to_route('area.create')->with('errorAgregar','Ha ocurrido un error al asignar area');

        }}else{
            return view('layout.403');
        }
    }
}
