<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class viewEventLogController extends Controller
{
    //
    public function show($id){
        if(session()->has('administrador')){
            $purchaseLog = DB::table('entradas as en')
                            ->join('eventos as e','e.idEvento','=','en.idEvento')
                            ->where('e.idEvento', '=', $id)
                            ->where('en.asistencia', '=', 0)
                            ->get();
            //return $purchaseLog;
            return view('viewEventLog.entry',compact('purchaseLog'));
        }else{
            return view('layout.406');
        }
    }
    
    public function confirmAsistencia($entradaId)
    {
        if (session()->has('administrador')) {
            try {
                // Actualizar el campo 'asistencia' a 1
                Entrada::where('idEntrada', $entradaId)->update(['asistencia' => 1]);
                $idEvento = DB::table('entradas')->where('idEntrada','=',$entradaId)->value('idEvento');

                return to_route('viewEventLog.entry', ['id' => $idEvento])->with('exito', 'Asistencia confirmada correctamente.');
        } catch (Exception $e) {
            return to_route('viewEventLog.entry', ['id' => $idEvento])->with('error', 'Error al confirmar la asistencia.');
        }
        } else {
            return view('layout.403');
        }
    }

    public function viewAttendanceRecordUDB(Request $request){
        if (session()->has('administrador')) {
            $idEvento = $request->get('idEvento'); // Obtener el idEvento desde la solicitud
    
            $records = DB::table('entradas as en')
                        ->select(
                            'e.nombreEvento', 
                            'e.fecha', 
                            'e.hora', 
                            'e.capacidad', 
                            'a.nombre', 
                            'p.profesionUDB',
                            DB::raw('COUNT(en.asistencia) AS total_registrados'),
                            DB::raw('SUM(CASE WHEN en.asistencia = 1 THEN 1 ELSE 0 END) AS total_asistencia')
                        )
                        ->join('eventos as e', 'e.idEvento', '=', 'en.idEvento')
                        ->join('areaformativaentretenimientoevento as afee', 'e.idEvento', '=', 'afee.idEvento')
                        ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                        ->join('areaformativaentretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
                        ->join('personalUDB as p','p.idUDB', '=', 'en.idPersonalUDB')
                        ->where('en.asistencia', '<=', 1); // Filtrar asistencias que tengan 0 o 1
    
            if ($idEvento) {
                $records->where('e.idEvento', $idEvento);
            }
    
            $records = $records->groupBy('e.nombreEvento', 'e.fecha', 'e.hora', 'e.capacidad', 'a.nombre','p.profesionUDB')
                        ->get();

            //return $records;
            return view('viewEventLog.viewAttendanceRecordUDB', compact('records'));
        } else {
            return view('layout.403');
        }
    }

    public function viewAttendanceRecordEntertainmentArea(Request $request) {
        if (session()->has('administrador')) {
            $idEvento = $request->get('idEvento'); // Obtener el idEvento desde la solicitud
    
            $records = DB::table('entradas as en')
                        ->select(
                            'e.nombreEvento', 
                            'e.fecha', 
                            'e.hora', 
                            'e.capacidad', 
                            'a.nombre', 
                            DB::raw('COUNT(en.asistencia) AS total_registrados'),
                            DB::raw('SUM(CASE WHEN en.asistencia = 1 THEN 1 ELSE 0 END) AS total_asistencia')
                        )
                        ->join('eventos as e', 'e.idEvento', '=', 'en.idEvento')
                        ->join('areaformativaentretenimientoevento as afee', 'e.idEvento', '=', 'afee.idEvento')
                        ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
                        ->join('areaformativaentretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
                        ->where('en.asistencia', '<=', 1); // Filtrar asistencias que tengan 0 o 1
    
            if ($idEvento) {
                $records->where('e.idEvento', $idEvento);
            }
    
            $records = $records->groupBy('e.nombreEvento', 'e.fecha', 'e.hora', 'e.capacidad', 'a.nombre')
                        ->get();
    
            //return view('viewEventLog.viewAttendanceRecordEntertainmentArea', compact('records'));
        } else {
            return view('layout.403');
        }
    }
}