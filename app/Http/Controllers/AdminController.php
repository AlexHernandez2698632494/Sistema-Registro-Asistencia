<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\persona;
use App\Models\admin;
use App\Models\Usuarios;
use Exception;

class AdminController extends Controller
{
    //
    public function index()
    {
        if(session()->has('administrador')){
            //$personas = Persona::where('estadoEliminacion', "=", "1")->get();
        $personas = DB::table('Persona')
                        ->join('Administrador','Persona.idPersona','=','Administrador.idPersona')
                        ->where('Administrador.estadoEliminacion','=',1)
                        ->get();
       //return $personas;
        return view('admin.index', compact('personas'));
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
            return view('admin.add');
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
            'nombre' => ['required', 'max:255', 'string'],
            'apellido' => ['required', 'max:255', 'string'],
            'dui' => ['required', 'regex:/^[0-9]{8}-[0-9]{1}$/', 'unique:Persona,dui'],
            'telefono' => ['required', 'regex:/^([2,6,7][0-9]{3})(-)([0-9]{4})$/', 'unique:Persona,telefono'],
            'correo' => ['required', 'email', 'unique:Persona,correo'],
            'direccion' => ['required', 'max:255', 'string'],
            'cargo' => ['required', 'max:255', 'string'],
            'usuario' => ['required', 'max:255', 'string'],
            'password' => ['required', 'min:8', 'string'],
        ], [
            'dui.regex' => 'Formato incorrecto de DUI.', // Mensaje de error personalizado
        ]);

        if ($validator->fails()) {
            // La validación ha fallado
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $name = $request->input('nombre');
            $apellido = $request->input('apellido');
            $dui = $request->input('dui');
            $telefono = $request->input('telefono');
            $correo = $request->input('correo');
            $direccion = $request->input('direccion');
            $cargo = $request->input('cargo');
            $user = $request->input('usuario');
            $pass = $request->input(('password'));

            $admin = new persona();
            $admin->nombre = $name;
            $admin->apellido = $apellido;
            $admin->dui = $dui;
            $admin->telefono = $telefono;
            $admin->correo = $correo;
            $admin->direccion = $direccion;
            $admin->estadoEliminacion = 1;

             

            if($admin->save()){
                $idPersona = $admin->idPersona;
                $administrateur = new admin();
                $administrateur->idPersona= $idPersona;
                $administrateur->cargo = $cargo;
                $administrateur->estadoEliminacion = 1; 
                $newUser = new Usuarios();
                $newUser->idUsuario = $dui;
                $newUser->usuario = $user;
                $newUser->password = Hash('SHA256',$pass);
                $newUser->nivel = 0;

                if($newUser->save() && $administrateur->save()){
                    DB::commit();
                    return to_route('admin.create')->with('exitoAgregar',' registrado correctamente');
                }else{
                    DB::rollBack();
                    return redirect()->back()->with('errorAgregar','Ha ocurrido un error al registrar ');
                }
            }else{
                DB::rollBack();
                return redirect()->back()->with('errorAgregar','Ha ocurrido un error al registrar ');
            }
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('errorAgregar','Ha ocurrido un error al registrar '.$e->getMessage());
        }
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
        $adminInfo = persona::find($id);
        // return $adminInfo;
        return view('admin.adminInfomation', compact('adminInfo'));
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
            $personaEdit = persona::find($id);

        return view('admin.edit', compact('personaEdit'));
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
            $personaEdit = persona::find($id);
        $personaEdit->nombre = $request->post('nombre');
        $personaEdit->apellido = $request->post('apellido');
        $personaEdit->dui = $request->post('dui');
        $personaEdit->telefono = $request->post('telefono');
        $personaEdit->correo = $request->post('correo');
        $personaEdit->direccion = $request->post('direccion');
        $personaEdit->save();

        return redirect()->route("admin.index")->with("exitoAgregar", "Actualizado con exito");
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
            $adminId = $request->input('idAdminEliminar');
            $affected = DB::table('Persona')
                            ->where('idPersona', '=', $adminId)
                            ->update(['estadoEliminacion' => 0]);
            
            $affected1 = DB::table('Administrador')
                            ->where('idAdministrador','=',$adminId)->update(['estadoEliminacion' => 0]);
            if ($affected == 1){
                if ($affected1 == 1){
                    return to_route('admin.index')->with('exitoEliminacion','El administrador se ha eliminado correctamente');
                }else{
                    return to_route('admin.index')->with('errorEliminacion','Error al eliminar el administrador');            
                }
            }else{
                return to_route('admin.index')->with('errorEliminacion','Error al eliminar el administrador');            
            }
        }else{
            return view('layout.403');            
        }     
    }

    public function restoreView()
    {
        if(session()->has('administrador')){
            $removedAdmins = persona::where('estadoEliminacion', '=', 0)->get();
        return view(('admin.remove'), compact('removedAdmins'));
        }else{
            return view('layout.403');            
        }  
    }

    public function restore(Request $request)
    {
        if(session()->has('administrador')){
            $restoreEventId = $request->input('idAdminRestaurar');
        //DB::beginTransaction();
        //try{
            $affected = DB::table('Persona')
                        ->where('idPersona','=', $restoreEventId)
                        ->update(['estadoEliminacion' => 1]);
        $affected1 = DB::table('Administrador')->where('idPersona','=', $restoreEventId)->update(['estadoEliminacion' => 1]);
        if($affected == 1){
            if($affected1){
                return to_route('admin.restoreView')->with('exitoRestaurar','El administrador se ha restaurado correctamente');
            }else{
                return to_route('admin.restoreView')->with('errorRestaurar','Error al eliminar el administrador');
            }
        }else{
            return to_route('admin.restoreView')->with('errorRestaurar','Error al eliminar el administrador');
        }
        // }catch(Exception $e){
        //     DB::rollback();
        //     return to_route('admin.restoreView')->with('errorRestaurar','Error al eliminar el administrador');
        // }
        }else{
            return view('layout.403');            
        } 
    }
}
