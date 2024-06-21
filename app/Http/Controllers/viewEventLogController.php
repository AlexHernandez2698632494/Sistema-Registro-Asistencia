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
    public function confirmAsistencia($id)
    {
        $entry = EventEntry::find($id);
        if ($entry) {
            $entry->asistencia = 1;
            $entry->save();
            return back()->with('exito', 'Asistencia confirmada correctamente.');
        } else {
            return back()->with('error', 'Entrada no encontrada.');
        }
    }

    public function viewAttendanceRecordUDB(Request $request)
    {
        if (session()->has('administrador')) {
            $idEvento = $request->get('idEvento'); // Obtener el idEvento desde la solicitud

            $records = DB::table('Eventos as e')
            ->join('areaFormativaEntretenimientoEvento as afee', 'e.idEvento', '=', 'afee.idEvento')
            ->join('Areas as a', 'afee.idAreas', '=', 'a.idAreas')
            ->leftJoin('eventEntry as en', 'e.idEvento', '=', 'en.idEvento')
            ->leftJoin('eventEntries as ee', 'en.idEventEntry', '=', 'ee.idEventEntry')
            ->leftJoin('entradas', 'en.idEventEntry', '=', 'entradas.idEventEntry')
            ->select(
                'e.NombreEvento as nombre_evento',
                'e.fecha',
                'e.hora',
                'a.nombre as nombre_area',
                'e.capacidad',
                'en.nombre as nombre_event_entry',
                'ee.nombre as nombre_event_entries',
                'en.nivel_educativo as nivel_educativo_event_entry',
                DB::raw('COUNT(DISTINCT en.idEventEntry) as total_registrados'),
                DB::raw('SUM(en.asistencia) as total_asistencia')
            )
            ->where('e.estadoEliminacion', 1)
            ->where('afee.estadoEliminacion', 1)
            ->where('a.estadoEliminacion', 1)
            ->where('en.institucion', 'UDB')
            ->where('en.institucion', 'Universidad Don Bosco')
            ->groupBy(
                'e.idEvento',
                'e.NombreEvento',
                'e.fecha',
                'e.hora',
                'a.nombre',
                'e.capacidad',
                'en.nivel_educativo',
                'en.nombre',
                'ee.nombre'
            )
            ->get();
                    //return $recordSUDB;
            return view('viewEventLog.viewAttendanceRecordUDB', compact('records', 'recordsSUDB', 'recordsG', 'recordsSUDBG'));
        } else {
            return view('layout.403');
        }
    }

    public function viewAttendanceRecordEntertainmentArea(Request $request)
    {
        if (session()->has('administrador')) {
            $idEvento = $request->get('idEvento'); // Obtener el idEvento desde la solicitud
            $records = DB::table('Eventos as e')
                ->join('areaFormativaEntretenimientoEvento as afee', 'e.idEvento', '=', 'afee.idEvento')
                ->join('Areas as a', 'afee.idAreas', '=', 'a.idAreas')
                ->leftJoin('eventEntry as en', 'e.idEvento', '=', 'en.idEvento')
                ->leftJoin('eventEntries as ee', 'en.idEventEntry', '=', 'ee.idEventEntry')
                ->leftJoin('entradas', 'en.idEventEntry', '=', 'entradas.idEventEntry')
                ->where('e.estadoEliminacion', 1)
                ->where('afee.estadoEliminacion', 1)
                ->where('a.estadoEliminacion', 1)
                ->select(
                    'e.nombreEvento',
                    'e.fecha',
                    'e.hora',
                    'a.nombre',
                    'e.capacidad',
                    DB::raw('COALESCE(SUM(entradas.cantidad), 0) as total_registrados'),
                    DB::raw('COALESCE(SUM(CASE WHEN en.asistencia = TRUE THEN 1 ELSE 0 END) + SUM(CASE WHEN ee.asistencia = TRUE THEN 1 ELSE 0 END), 0) as total_asistencia')
                )
                ->groupBy('e.idEvento', 'e.NombreEvento', 'e.fecha', 'e.hora', 'a.nombre', 'e.capacidad')
                ->get();
            return view('viewEventLog.viewAttendanceRecordEntertainmentArea', compact('records'));
        } else {
            return view('layout.403');
        }
    }
}
