<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Archivo;
class Permisos extends Model
{
    protected $table = 'permisos';

    public function archivo(){
        return $this->belongsTo(Archivo::class);
    }

    public static function savePermisos($archivo_id,$ver,$editar){
        $permiso=new Permisos();
        $permiso->archivo_id=$archivo_id;
        $permiso->ver=$ver;
        $permiso->editar=$editar;
        $permiso->save();
    }
}
