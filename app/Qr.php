<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Archivo;

class Qr extends Model
{

    protected $table = 'qrs';
    public function archivo(){
        return $this.BelongsTo(Archivo::class);
    }
}
