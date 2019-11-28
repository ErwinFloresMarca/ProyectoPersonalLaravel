<?php

namespace App\Http\Controllers;

use App\Permisos;
use App\Archivo;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function show(Permisos $permisos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function edit(Permisos $permisos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $permisos=Permisos::find($id);
        
        if($request->ajax()){
            $cambio="";
            if($request->ver!=null){
                $permisos->ver=$request->ver;
                $cambio='"ver"';
            }
            if($request->editar!=null){
                $permisos->editar=$request->editar;
                $cambio='"editar"';
            }
            $msn="Los Permiso de ".$cambio." del archivo ".Archivo::find($permisos->archivo_id)->nombre." a cambiado!!!";
            $permisos->save();
            return response()->json([
                'title'=>'Permiso Cambiado',
                'msn'=>$msn,
                'success'=>true
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permisos $permisos)
    {
        //
    }
}
