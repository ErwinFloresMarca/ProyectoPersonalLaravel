<?php

namespace App\Http\Controllers;

use App\Archivo;
use App\User;
use App\Qr;
use App\Permisos;
use Illuminate\Http\Request;
use Carbon\Carbon;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\File;
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
    public function listArchivos($id,$data){
        //$data=[$id,$data];
        //dd($data);
        $archivos=[];
        if($id==0){
            //publicos index
            $result=Archivo::all()->where('user_id','!=',$id);
            foreach($result as $res)
            if($res->privacidad==1)
                if($res->permisos->ver)
                    $archivos[]=$res;   
        }
        else if($data==0){
                //otros home
                $result=Archivo::all()->where('user_id','!=',$id);
                foreach($result as $res)
                if($res->privacidad==1)
                    if($res->permisos->ver)
                        $archivos[]=$res;
            }else{
                //mios arhivos
                $result=Archivo::all()->where('user_id','=',$id);
                $archivos=$result;
            }
            
        
        foreach($archivos as $arch){
            $arch->creado_hace=Carbon::parse($arch->created_at)->subMinutes(2)->diffForHumans();
            $arch->actualizado_hace=Carbon::parse($arch->updated_at)->subMinutes(2)->diffForHumans();
            $arch->permisos;
            $arch->qr;
        };
        return DataTables::of($archivos)->rawColumns(['id','nombre','ruta','privacidad','user_id','permisos','qr'])->make(true);
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
    public function createQr($archivo_id){
        $opt = new QROptions([
            'version'    => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel'   => QRCode::ECC_L,
        ]);
        $qrcode= new QRCode($opt);
        $data=url('archivo').'/'.$archivo_id;
        $pathFile="/qrs/qr-To-".$archivo_id.".svg";
        $qrcode->render($data,public_path().$pathFile);
        $qr=new Qr();
        $qr->archivo_id=$archivo_id;
        $qr->ruta=$pathFile;
        $qr->save();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $extenciones=["txt",'cpp','docx','java'];    
        if($request->ajax()){
            
            if($file=$request->file('archivo')){
                $name=$file->getClientOriginalName();
                $extencion=$file->getClientOriginalExtension();
                if(in_array($extencion,$extenciones)){
                    $destinationPath='/archivos/'.$request->user_id.'/';
                    if(file_exists(public_path().$destinationPath.$name)){
                        return response()->json([
                            'title'=>'Error',
                            'msn'=>'Usted ya tiene un archivo con el mismo nombre "'.$name.'" !!!',
                            'success'=>false
                        ]);    
                    }
                    $file->move(public_path().$destinationPath,$name);
                    $arch=new Archivo;
                    $arch->nombre=$name;
                    $arch->user_id=$request->user_id;
                    $arch->privacidad=($request->privacidad)?1:0;
                    $arch->ruta=$destinationPath.$name;

                    $arch->save();
                    if($request->privacidad){
                        Permisos::savePermisos($arch->id,$request->ver,$request->editar);
                        $this->createQr($arch->id);
                        
                    }
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
        $extenciones=["txt",'cpp','docx','java',"xlsx","pptx","xmlx"];
        $contenido="";
        $tipoEditor="";
        $cmConfMode="";
        $cmMode="";
        switch(explode(".",$archivo->nombre)[1]){
            case "txt": $tipoEditor="texto";
                        $contenido=File::get(public_path().$archivo->ruta);
                break;
            case "cpp": $tipoEditor="codemirror";
                        $cmConfMode="text/x-c++src";
                        $cmMode='clike';
                        $contenido=File::get(public_path().$archivo->ruta);
                break;
            case "xlsx":
            case "pptx":
            case "xmlx":
            case "docx": $tipoEditor="office";
                
                break;
            case "java": $tipoEditor="codemirror";
                        $cmMode='clike';
                        $cmConfMode="text/x-java";
                        $contenido=File::get(public_path().$archivo->ruta);
                break;
        }
        return view('archivo.editFile')
                ->with('archivo',$archivo)
                ->with('contenido',$contenido)
                ->with('cmConfMode',$cmConfMode)
                ->with('cmMode',$cmMode)
                ->with('tipoEditor',$tipoEditor);
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
        if($request->ajax()){
            
                    $archivo->privacidad=$request->privacidad;
                    $archivo->save();
                    if($request->privacidad){
                        Permisos::savePermisos($archivo->id,1,1);
                        Qr::createQr($archivo->id);
                    }
                    else{
                        Qr::deleteQrFile($archivo->qr->ruta);
                        $archivo->qr->delete();
                        $archivo->permisos->delete();
                    }
                    return response()->json([
                        'title'=>'Archivo Modificado',
                        'msn'=>'El archivo '.$archivo->nombre.' fue modificado a '.(($archivo->privacidad)?"Publico":"Privado").'!!!',
                        'success'=>true
                    ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archivo $archivo)
    {
        //dd($archivo);
        $nombre=$archivo->nombre;
        if($archivo->privacidad){
            Qr::deleteQrFile($archivo->qr->ruta);
            $archivo->qr->delete();
            $archivo->permisos->delete();
        }
        //dd($archivo);
        unlink(public_path().$archivo->ruta);
        $archivo->delete();
        return response()->json([
            'title'=>'Archivo Modificado',
            'msn'=>'El archivo '.$nombre.' fue eliminado!!!',
            'success'=>true
        ]);
    }
    public function getArchivo($id){
        $archivo=Archivo::find($id);
        $ruta=public_path().$archivo->ruta; 
        $headers = array(
            'Content-Type: application/docx',
          );
        
        return response()->file($ruta,$headers);
    }
    public function guardarCambios(Request $request,$id){
        //dd($request);
        $archivo=Archivo::find($id);
        $ruta=$archivo->ruta;
        $archivo->ruta="";
        $archivo->save();
        $archivo->ruta=$ruta;
        $archivo->save();
        switch($request->tipoEditor){
            case 'office':
                if($file=$request->file('archivo')){
                    $file->move(public_path().'/archivos/'.$archivo->id.'/',$archivo->nombre);
                    $archivo->save();
                    return response()->json([
                        'title'=>'Archivo Modificado',
                        'msn'=>'El archivo '.$archivo->nombre.' fue sobre escrito exitosamente!!!',
                        'success'=>true
                    ]);
                }
                break;
            case 'codemirror': 
            case 'texto':
                if(file_exists(public_path().$archivo->ruta))
                    unlink(public_path().$archivo->ruta);
                $file=fopen(public_path().$archivo->ruta,"a");
                fwrite($file,$request->contenido);
                fclose($file);
                $archivo->save();
                return response()->json([
                    'title'=>'Archivo Modificado',
                    'msn'=>'Se guardaron los cambios exitosamente!!!',
                    'success'=>true
                ]);
                break;
        }
    }
}
