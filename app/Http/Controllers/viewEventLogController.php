<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\EntradaG;
use App\Models\EventEntry;
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
            $purchaseLog = DB::table('entradas as en')
                ->leftJoin('eventEntry as ev', 'ev.idEventEntry', '=', 'en.idEventEntry')
                ->join('eventos as e', 'e.idEvento', '=', 'ev.idEvento')
                ->where('e.idEvento', '=', $id)
                ->where('ev.asistencia', '=', 0)
                ->where('en.idEventEntries', '=', 0)
                ->get();
            $purchaseLogs = DB::table('entradas as en')
                ->leftJoin('eventEntry as ev', 'ev.idEventEntry', '=', 'en.idEventEntry')
                ->join('eventos as e', 'e.idEvento', '=', 'ev.idEvento')
                ->where('e.idEvento', '=', $id)
                ->where('ev.asistencia', '=', 0)
                ->where('en.idEventEntries', '=', 1)
                ->get();
            //return $purchaseLog;
            return view('viewEventLog.entry', compact('purchaseLog', 'purchaseLogs'));
        } else {
            return view('layout.406');
        }
    }

    public function updateCantidad(Request $request)
    {
        $idEventEntry = $request->input('idEventEntry');
        $cantidad = $request->input('cantidad');
    
        // Obtener la entrada por su ID
        $entrada = Entrada::where('idEventEntry', $idEventEntry)->first();
    
        // Verificar si se encontró la entrada
        if ($entrada) {
            // Verificar si la nueva cantidad es menor o igual a la cantidad actual
            if ($cantidad <= $entrada->cantidad) {
                // Actualizar la cantidad
                $entrada->cantidad = $cantidad;
                $entrada->save();
                return redirect()->back()->with('exito', 'Cantidad actualizada correctamente.');
            } else {
                return redirect()->back()->with('error', 'La nueva cantidad no puede ser mayor que la cantidad actual.');
            }
        } else {
            return redirect()->back()->with('error', 'No se encontró la entrada para actualizar la cantidad.');
        }
    }
    


    public function confirmAsistencia($id)
    {
        $entry = EventEntry::find($id);
        if ($entry) {
            $entry->asistencia = 1;
            $entry->save();
            return to_route('viewEventLog.entry')->with('exito', 'Asistencia confirmada correctamente.');
        } else {
            return back()->with('error', 'Entrada no encontrada.');
        }
    }

    public function viewAttendanceRecordUDB(Request $request)
    {
        if (session()->has('administrador')) {
            $idEvento = $request->get('idEvento'); // Obtener el idEvento desde la solicitud

            $records = DB::table('Eventos as e')
            ->select([
                'e.NombreEvento AS nombre_evento',
                'e.fecha AS fecha',
                'e.hora AS hora',
                'e.capacidad AS capacidad',
                'a.nombre AS nombre_area',
                DB::raw("COALESCE(est.carreraUDB, per.profesionUDB, ee.nivel_educativo, en.nivel_educativo, 'Sin especificar') AS carrera_profesion"),
                DB::raw("COUNT(DISTINCT ee.idEventEntry) AS total_registrados"),
                DB::raw("SUM(CASE WHEN en.asistencia = TRUE THEN 1 ELSE 0 END) AS total_asistencia"),
            ])
            ->join('areaFormativaEntretenimientoEvento as afee', 'e.idEvento', '=', 'afee.idEvento')
            ->join('Areas as a', 'afee.idAreas', '=', 'a.idAreas')
            ->leftJoin('eventEntry as ee', 'e.idEvento', '=', 'ee.idEvento')
            ->leftJoin('eventEntries as en', 'ee.idEventEntry', '=', 'en.idEventEntry')
            ->leftJoin('estudianteUDB as est', 'ee.idEstudianteUDB', '=', 'est.idUDB')
            ->leftJoin('personalUDB as per', 'ee.idPersonalUDB', '=', 'per.idUDB')
            ->where('e.estadoEliminacion', 1)
            ->where('a.estadoEliminacion', 1)
            ->where(function($query) {
                $query->where('ee.institucion', 'UDB')
                      ->orWhere('ee.institucion', 'Universidad Don Bosco')
                      ->orWhere('en.institucion', 'UDB')
                      ->orWhere('en.institucion', 'Universidad Don Bosco');
            })
            ->groupBy('e.idEvento', 'a.idAreas', 'carrera_profesion')
            ->orderBy('e.fecha', 'ASC')
            ->orderBy('e.hora', 'ASC')
            ->get();
            
        // return $records;
            return view('viewEventLog.viewAttendanceRecordUDB', compact('records'));
        } else {
            return view('layout.403');
        }
    }

    public function confirmAsistenciaG($idEventEntry)
    {
        // Obtener la entrada del evento específico
        $entrada = Entrada::where('idEventEntry', $idEventEntry)->first();
    
        if (!$entrada) {
            return redirect()->back()->with('error', 'No se encontró la entrada del evento.');
        }
    
        // Obtener la cantidad de la entrada
        $cantidad = $entrada->cantidad;
    
        // Actualizar el estado de asistencia en EventEntry
        $eventEntry = EventEntry::find($idEventEntry);
        if ($eventEntry) {
            $eventEntry->asistencia = true;
            $eventEntry->save();
        } else {
            return redirect()->back()->with('error', 'No se encontró el registro del evento.');
        }
    
        // Actualizar el estado de asistencia en EventEntries
        $eventEntries = EntradaG::where('idEventEntry', $idEventEntry)->get();
        foreach ($eventEntries as $eventEntry) {
            $eventEntry->asistencia = true;
            $eventEntry->save();
        }
    
        return redirect()->back()->with('exito', 'Se ha confirmado la asistencia correctamente.');
    }

    public function viewAttendanceRecordEntertainmentArea(Request $request)
    {
        if (session()->has('administrador')) {
            $idEvento = $request->get('idEvento'); // Obtener el idEvento desde la solicitud
            $eventAsistencias = DB::table('eventEntry')
        ->select('idEvento', DB::raw('SUM(CASE WHEN asistencia = TRUE THEN 1 ELSE 0 END) AS total_asistencia_eventEntry'))
        ->groupBy('idEvento');

    $eventEntriesAsistencias = DB::table('eventEntries')
        ->select('idEvento', DB::raw('SUM(CASE WHEN asistencia = TRUE THEN 1 ELSE 0 END) AS total_asistencia_eventEntries'))
        ->groupBy('idEvento');

    $eventEntradas = DB::table('Eventos as e')
        ->leftJoin('eventEntry as en', 'e.idEvento', '=', 'en.idEvento')
        ->leftJoin('entradas as entradas', 'en.idEventEntry', '=', 'entradas.idEventEntry')
        ->select('e.idEvento', DB::raw('SUM(COALESCE(entradas.cantidad, 0)) AS total_registrados'))
        ->groupBy('e.idEvento');

    $records = DB::table('Eventos as e')
        ->join('areaFormativaEntretenimientoEvento as afee', 'e.idEvento', '=', 'afee.idEvento')
        ->join('Areas as a', 'afee.idAreas', '=', 'a.idAreas')
        ->leftJoinSub($eventAsistencias, 'ea', function($join) {
            $join->on('e.idEvento', '=', 'ea.idEvento');
        })
        ->leftJoinSub($eventEntriesAsistencias, 'eea', function($join) {
            $join->on('e.idEvento', '=', 'eea.idEvento');
        })
        ->leftJoinSub($eventEntradas, 'ee', function($join) {
            $join->on('e.idEvento', '=', 'ee.idEvento');
        })
        ->where('e.estadoEliminacion', 1)
        ->where('afee.estadoEliminacion', 1)
        ->where('a.estadoEliminacion', 1)
        ->groupBy('e.idEvento', 'e.NombreEvento', 'e.fecha', 'e.hora', 'a.nombre', 'e.capacidad')
        ->select(
            'e.NombreEvento as nombreEvento',
            'e.fecha',
            'e.hora',
            'a.nombre as nombre',
            'e.capacidad',
            DB::raw('COALESCE(ee.total_registrados, 0) AS total_registrados'),
            DB::raw('COALESCE(ea.total_asistencia_eventEntry, 0) + COALESCE(eea.total_asistencia_eventEntries, 0) AS total_asistencia')
        )
        ->get();
            return view('viewEventLog.viewAttendanceRecordEntertainmentArea', compact('records'));
        } else {
            return view('layout.403');
        }
    }
}
