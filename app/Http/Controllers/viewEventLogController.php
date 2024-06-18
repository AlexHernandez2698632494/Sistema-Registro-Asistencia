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
    return view('viewEventLog.entry',compact('purchaseLog','purchaseLogs'));
    } else {
        return view('layout.406');
    }
}
    public function confirmAsistencia($entradaId)
    {
        if (session()->has('administrador')) {
            try {
                // Actualizar el campo 'asistencia' a 1
                Entrada::where('idEventEntry', $entradaId)->update(['asistencia' => 1]);
                $idEvento = DB::table('eventEntry')->where('idEventEntry','=',$entradaId)->value('idEvento');
                EntradaG::where('idEventEntry', $entradaId)->update(['asistencia' => 1]);
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
    
            $records = DB::table('eventEntry as en')
    ->join('entradas as ent', 'en.idEventEntry', '=', 'ent.idEventEntry')
    ->join('Eventos as ev', 'en.idEvento', '=', 'ev.idEvento')
    ->join('areaFormativaEntretenimientoEvento as afee', 'ev.idEvento', '=', 'afee.idEvento')
    ->join('Areas as a', 'afee.idAreas', '=', 'a.idAreas')
    ->join('personalUDB as pu', 'en.idPersonalUDB', '=', 'pu.idUDB')  // Aquí se añade el join con la nueva tabla
    ->select(
        'ev.nombreEvento',
        'ev.fecha',
        'ev.hora',
        'ev.capacidad',
        'a.nombre',
        'pu.profesionUDB',  // Se añade el campo profesión
        DB::raw('(SELECT SUM(cantidad) FROM entradas) as total_registrados'),
        DB::raw('
             (
                 (
                     SELECT COUNT(*) 
                     FROM eventEntry 
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
    ->groupBy(
        'ev.nombreEvento', 
        'ev.fecha', 
        'ev.hora', 
        'ev.capacidad', 
        'a.nombre',
        'pu.profesionUDB'  // Se añade también en el group by
    )
    ->get();

    $recordsSUDB = DB::table('eventEntry as en')
    ->join('entradas as ent', 'en.idEventEntry', '=', 'ent.idEventEntry')
    ->join('Eventos as ev', 'en.idEvento', '=', 'ev.idEvento')
    ->join('areaFormativaEntretenimientoEvento as afee', 'ev.idEvento', '=', 'afee.idEvento')
    ->join('Areas as a', 'afee.idAreas', '=', 'a.idAreas')
    ->join('estudianteUDB as udb', 'en.idEstudianteUDB', '=', 'udb.idUDB')  // Aquí se añade el join con la nueva tabla
    ->select(
        'ev.nombreEvento',
        'ev.fecha',
        'ev.hora',
        'ev.capacidad',
        'a.nombre',
        'udb.carreraUDB',  // Se añade el campo profesión
        DB::raw('(SELECT SUM(cantidad) FROM entradas) as total_registrados'),
        DB::raw('
             (
                 (
                     SELECT COUNT(*) 
                     FROM eventEntry 
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
    ->groupBy(
        'ev.nombreEvento', 
        'ev.fecha', 
        'ev.hora', 
        'ev.capacidad', 
        'a.nombre',
        'udb.carreraUDB'  // Se añade también en el group by
    )
    ->get();
    $recordsG = DB::table('eventEntry as en')
    ->join('eventEntries as ee', 'en.idEventEntry', '=', 'ee.idEventEntry')
    ->join('entradas as ent', 'en.idEventEntry', '=', 'ent.idEventEntry')
    ->join('Eventos as ev', 'en.idEvento', '=', 'ev.idEvento')
    ->join('areaFormativaEntretenimientoEvento as afee', 'ev.idEvento', '=', 'afee.idEvento')
    ->join('Areas as a', 'afee.idAreas', '=', 'a.idAreas')
    ->join('personalUDB as pu', 'en.idPersonalUDB', '=', 'pu.idUDB')  // Aquí se añade el join con la nueva tabla
    ->select(
        'ev.nombreEvento',
        'ev.fecha',
        'ev.hora',
        'ev.capacidad',
        'a.nombre',
        'pu.profesionUDB',  // Se añade el campo profesión
        DB::raw('(SELECT SUM(cantidad) FROM entradas) as total_registrados'),
        DB::raw('
             (
                 (
                     SELECT COUNT(*) 
                     FROM eventEntry 
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
    ->groupBy(
        'ev.nombreEvento', 
        'ev.fecha', 
        'ev.hora', 
        'ev.capacidad', 
        'a.nombre',
        'pu.profesionUDB'  // Se añade también en el group by
    )
    ->get();

    $recordsSUDBG = DB::table('eventEntry as en')
    ->join('eventEntries as ee', 'en.idEventEntry', '=', 'ee.idEventEntry')
    ->join('entradas as ent', 'en.idEventEntry', '=', 'ent.idEventEntry')
    ->join('Eventos as ev', 'en.idEvento', '=', 'ev.idEvento')
    ->join('areaFormativaEntretenimientoEvento as afee', 'ev.idEvento', '=', 'afee.idEvento')
    ->join('Areas as a', 'afee.idAreas', '=', 'a.idAreas')
    ->join('estudianteUDB as udb', 'en.idEstudianteUDB', '=', 'udb.idUDB')  // Aquí se añade el join con la nueva tabla
    ->select(
        'ev.nombreEvento',
        'ev.fecha',
        'ev.hora',
        'ev.capacidad',
        'a.nombre',
        'udb.carreraUDB',  // Se añade el campo profesión
        DB::raw('(SELECT SUM(cantidad) FROM entradas) as total_registrados'),
        DB::raw('
             (
                 (
                     SELECT COUNT(*) 
                     FROM eventEntry 
                     WHERE asistencia = TRUE
                 ) + 
                 (
                     SELECT COUNT(*) 
                     FROM eventEntries 
                     WHERE asistencia = TRUE
                 )
             ) AS total_asistencia'
         )
    )->where('en.asistencia', '<=', 1)
    ->groupBy(
        'ev.nombreEvento', 
        'ev.fecha', 
        'ev.hora', 
        'ev.capacidad', 
        'a.nombre',
        'udb.carreraUDB'  // Se añade también en el group by
    )
    ->get();
            //return $recordSUDB;
            return view('viewEventLog.viewAttendanceRecordUDB', compact('records','recordsSUDB','recordsG','recordsSUDBG'));
        } else {
            return view('layout.403');
        }
    }

    public function viewAttendanceRecordEntertainmentArea(Request $request) {
        if (session()->has('administrador')) {
            $idEvento = $request->get('idEvento'); // Obtener el idEvento desde la solicitud
            $records = DB::table('eventEntry as en')
            ->join('eventEntries as ee', 'en.idEventEntry', '=', 'ee.idEventEntry')
            ->join('entradas as ent', 'en.idEventEntry', '=', 'ent.idEventEntry')
            ->join('Eventos as ev', 'en.idEvento', '=', 'ev.idEvento')
            ->join('areaFormativaEntretenimientoEvento as afee', 'ev.idEvento', '=', 'afee.idEvento')
            ->join('Areas as a', 'afee.idAreas', '=', 'a.idAreas')
            ->select(
                'ev.nombreEvento',
                'ev.fecha',
                'ev.hora',
                'ev.capacidad',
                'a.nombre',
                DB::raw('(SELECT SUM(cantidad) FROM entradas) as total_registrados'),
                DB::raw('
                     (
                         (
                             SELECT COUNT(*) 
                             FROM eventEntry 
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
            ->where('en.asistencia', '<=', 1)
            ->where('ev.idEvento', 1)
            ->groupBy(
                'ev.nombreEvento', 
                'ev.fecha', 
                'ev.hora', 
                'ev.capacidad', 
                'a.nombre'
            )
            ->get();
            return view('viewEventLog.viewAttendanceRecordEntertainmentArea', compact('records'));
        } else {
            return view('layout.403');
        }
    }

}