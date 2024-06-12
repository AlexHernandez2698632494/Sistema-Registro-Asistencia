<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\EntradaG;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class viewEventLogController extends Controller
{
    
    public function show($id)
{
    if (session()->has('administrador')) {
        $purchaseLog = DB::table('eventEntry as ev')
        ->join('eventos as e','e.idEvento','=','ev.idEvento')
        ->where('e.idEvento', '=', $id)
        ->where('ev.asistencia', '=', 0)
        ->get();
    //return $purchaseLog;
    return view('viewEventLog.entry',compact('purchaseLog'));
    } else {
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
                EntradaG::where('idEntrada', $entradaId)->update(['asistencia' => 1]);
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
            ->join('evententries as ee', 'ee.idEntrada', '=', 'en.idEntrada')
            ->join('eventos as e', 'e.idEvento', '=', 'en.idEvento')
            ->join('areaformativaentretenimientoevento as afee', 'e.idEvento', '=', 'afee.idEvento')
            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
            ->join('areaformativaentretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
            ->join('personalUDB as udb', 'en.idpersonalUDB', '=', 'udb.idUDB') // Asumiendo que esta es la relación correcta
            ->select(
                'e.nombreEvento',
                'e.fecha',
                'e.hora',
                'e.capacidad',
                'a.nombre',
                'udb.profesionUDB', // Selecciona la profesión de la tabla estudianteUDB
                DB::raw('
                (
                    (
                        SELECT COUNT(*) 
                        FROM entradas 
                        WHERE asistencia = 0
                    ) + 
                    (
                        SELECT COUNT(*) 
                        FROM eventEntries 
                        WHERE asistencia = 0
                    )
                ) AS total_registrados'),
                DB::raw('
                    (
                        (
                            SELECT COUNT(*) 
                            FROM entradas 
                            WHERE asistencia = TRUE
                        ) + 
                        (
                            SELECT COUNT(*) 
                            FROM eventEntries 
                            WHERE asistencia = TRUE
                        )
                    ) AS total_asistencia'
                )
            )
            ->where('en.asistencia', '<=', 1);

            if ($idEvento) {
                $records->where('e.idEvento', $idEvento);
            }

            $records = $records->groupBy(
                'e.nombreEvento', 
                'e.fecha', 
                'e.hora', 
                'e.capacidad', 
                'a.nombre',
                'udb.profesionUDB' // Agrupar también por la profesión
            )->get();

            $recordsSUDB = DB::table('entradas as en')
            ->join('evententries as ee', 'ee.idEntrada', '=', 'en.idEntrada')
            ->join('eventos as e', 'e.idEvento', '=', 'en.idEvento')
            ->join('areaformativaentretenimientoevento as afee', 'e.idEvento', '=', 'afee.idEvento')
            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
            ->join('areaformativaentretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
            ->join('estudianteUDB as udb', 'en.idEstudianteUDB', '=', 'udb.idUDB') // Asumiendo que esta es la relación correcta
            ->select(
                'e.nombreEvento',
                'e.fecha',
                'e.hora',
                'e.capacidad',
                'a.nombre',
                'udb.carreraUDB', // Selecciona la profesión de la tabla estudianteUDB
                DB::raw('
                (
                    (
                        SELECT COUNT(*) 
                        FROM entradas 
                        WHERE asistencia = 0
                    ) + 
                    (
                        SELECT COUNT(*) 
                        FROM eventEntries 
                        WHERE asistencia = 0
                    )
                ) AS total_registrados'),
                DB::raw('
                    (
                        (
                            SELECT COUNT(*) 
                            FROM entradas 
                            WHERE asistencia = TRUE
                        ) + 
                        (
                            SELECT COUNT(*) 
                            FROM eventEntries 
                            WHERE asistencia = TRUE
                        )
                    ) AS total_asistencia'
                )
            )
            ->where('en.asistencia', '<=', 1);

        if ($idEvento) {
            $recordsSUDB->where('e.idEvento', $idEvento);
        }

        $recordsSUDB = $recordsSUDB->groupBy(
            'e.nombreEvento', 
            'e.fecha', 
            'e.hora', 
            'e.capacidad', 
            'a.nombre',
            'udb.carreraUDB' // Agrupar también por la profesión
        )->get();
    
            //return $recordSUDB;
            return view('viewEventLog.viewAttendanceRecordUDB', compact('records','recordsSUDB'));
        } else {
            return view('layout.403');
        }
    }

    public function viewAttendanceRecordEntertainmentArea(Request $request) {
        if (session()->has('administrador')) {
            $idEvento = $request->get('idEvento'); // Obtener el idEvento desde la solicitud
    
            $records = DB::table('entradas as en')
            ->join('evententries as ee', 'ee.idEntrada', '=', 'en.idEntrada')
            ->join('eventos as e', 'e.idEvento', '=', 'en.idEvento')
            ->join('areaformativaentretenimientoevento as afee', 'e.idEvento', '=', 'afee.idEvento')
            ->join('areas as a', 'a.idAreas', '=', 'afee.idAreas')
            ->join('areaformativaentretenimiento as afe', 'afe.idAreaFormativaEntretenimiento', '=', 'a.idAreaFormativaEntretenimiento')
            ->select(
                'e.nombreEvento',
                'e.fecha',
                'e.hora',
                'e.capacidad',
                'a.nombre',
                DB::raw('
                (
                    (
                        SELECT COUNT(*) 
                        FROM entradas 
                        WHERE asistencia = 0
                    ) + 
                    (
                        SELECT COUNT(*) 
                        FROM eventEntries 
                        WHERE asistencia = 0
                    )
                ) AS total_registrados'),
                DB::raw('
                    (
                        (
                            SELECT COUNT(*) 
                            FROM entradas 
                            WHERE asistencia = TRUE
                        ) + 
                        (
                            SELECT COUNT(*) 
                            FROM eventEntries 
                            WHERE asistencia = TRUE
                        )
                    ) AS total_asistencia'
                )
            )
            ->where('en.asistencia', '<=', 1);

            if ($idEvento) {
                $records->where('e.idEvento', $idEvento);
            }
    
            $records = $records->groupBy('e.nombreEvento', 'e.fecha', 'e.hora', 'e.capacidad', 'a.nombre')
                        ->get();
            
            return view('viewEventLog.viewAttendanceRecordEntertainmentArea', compact('records'));
        } else {
            return view('layout.403');
        }
    }

}