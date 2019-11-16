<?php

namespace App\Http\Controllers;

use App\Archivo;
use App\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("archivo.index");
    }
    public function listArchivos(){
        $archivos=Archivo::all();
        
        return DataTables::of($archivos)->rawColumns(['id','nombre','ruta','privacidad','user_id'])->make(true);
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
        $extenciones=["txt",'cpp','doc','docx'];
        if($request->ajax()){
            
            if($file=$request->file('archivo')){
                $name=$file->getClientOriginalName();
                $extencion=$file->getClientOriginalExtension();
                if(in_array($extencion,$extenciones)){
                    $destinationPath=public_path().'/archivos/'.$request->user_id.'/';
                    $file->move($destinationPath,$name);
                    $arch=new Archivo;
                    $arch->nombre=$name;
                    $arch->user_id=$request->user_id;
                    $arch->privacidad=$request->privacidad;
                    $arch->ruta=$destinationPath.$name;
                    $arch->save();
                    return response()->json([
                        'title'=>'Archivo Subido',
                        'msn'=>'El archivo '.$request->nombre.' fue subido exitosamente!!!',
                        'success'=>true
                    ]);
                }
                else{
                    return response()->json([
                        'title'=>'Error',
                        'msn'=>'Este formato no esta permitido!!!',
                        'success'=>false
                    ]);
                }
                
            }
            else{
                return response()->json([
                    'title'=>'Error',
                    'msn'=>'No selecciono ningun archivo',
                    'success'=>false
                ]);
            }
        }
        //dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function show(Archivo $archivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Archivo $archivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Archivo $archivo)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archivo $archivo)
    {
        //
    }
}
