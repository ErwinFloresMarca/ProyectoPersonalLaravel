<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            
        return view("user.index");
    }
    public function listUsers(){
        $users=User::all();
        
        return DataTables::of($users)->rawColumns(['id','email','nombres','apellidos','ci','telefono'])->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            if($request->password==$request->password_confirm){
                $user=new User;
                $user->nombres=$request->nombres;
                $user->apellidos=$request->apellidos;
                $user->telefono=$request->telefono;
                $user->ci=$request->ci;
                $user->email=$request->email;
                $user->password=bcrypt($request->password);
                $user->save();
                return response()->json(['title'=>'Usuario Creado','msn'=>'El usuario '.$request->nombres.' fue creado exitosamente!!!','success'=>true]);
            }else{
                return response()->json(['title'=>'Error en los datos','msn'=>'la contraseña no es la misma que la confirmacion!!!','success'=>false]);    
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);
        return response()->json($user->toJson());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()){
            $user=User::find($id);
            $user->nombres=$request->nombres;
            $user->apellidos=$request->apellidos;
            $user->telefono=$request->telefono;
            $user->ci=$request->ci;
            $user->email=$request->email;
            if($request->password!=null)
                $user->password=bcrypt($request->password);
            $user->save();
            return response()->json(['title'=>'Usuario Actualizado','msn'=>'El usuario '.$request->nombres.' fue actualizado exitosamente!!!','success'=>true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        $nombre=$user->nombres;
        //completar
        $user->delete();
        return response()->json(['title'=>'Usuario Eliminado','msn'=>'El usuario '.$nombre.' fue eliminado!!!','success'=>true]);
    }
}
