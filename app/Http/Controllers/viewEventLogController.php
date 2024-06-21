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
            
//            return $records;
            return view('viewEventLog.viewAttendanceRecordUDB', compact('records'));
        } else {
            return view('layout.403');
        }
    }

    public function confirmAsistenciaG($id)
    {
        $entry = EventEntry::find($id);
        if ($entry) {
            $entry->asistencia = 1;
            $entry->save();

            // Suponiendo que EventEntries es otra tabla o modelo
            $globalEntry = EntradaG::where('idEventEntry', $id)->first();
            if ($globalEntry) {
                $globalEntry->asistencia = 1;
                $globalEntry->save();
            }

            return back()->with('exito', 'Asistencia global confirmada correctamente.');
        } else {
            return back()->with('error', 'Entrada no encontrada.');
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
