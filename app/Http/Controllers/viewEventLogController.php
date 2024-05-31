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
}