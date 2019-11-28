<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Archivo;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use League\Flysystem\File;

class Qr extends Model
{

    protected $table = 'qrs';
    public function archivo(){
        return $this->belongsTo(Archivo::class);
    }

    public static function createQr($archivo_id){
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
    public static function deleteQrFile($ruta){
        
        unlink(public_path().$ruta);
    }
}
