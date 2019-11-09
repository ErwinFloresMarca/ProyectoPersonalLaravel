<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Archivo;
class Permisos extends Model
{
    protected $table = 'permisos';

    public function archivo(){
        return $this.BelongsTo(Archivo::class);
    }
}
