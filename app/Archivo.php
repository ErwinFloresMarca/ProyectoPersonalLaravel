<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usuario;
use App\Permisos;
use App\Qr;
class Archivo extends Model
{
    protected $table = 'archivos';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function qr(){
        return $this->hasOne(Qr::class);
    }
    public function permisos(){
        return $this->hasOne(Permisos::class);
    }
}
