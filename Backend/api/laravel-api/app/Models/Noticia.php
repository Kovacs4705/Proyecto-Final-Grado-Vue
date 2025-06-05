<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $table = 'noticia';
    protected $primaryKey = 'id_noticia';

    protected $fillable = [
        'titulo',
        'descripcion',
        'cuerpo',
        'portada',
        'lightbox'
    ];

    public function getPortadaAttribute($value)
    {
        return $value ? base64_encode($value) : null;
    }

    public function getLightboxAttribute($value)
    {
        return $value ? base64_encode($value) : null;
    }

    public function getMimeTypePortadaAttribute()
    {
        return $this->getMimeType($this->attributes['portada']);
    }
    public function getMimeTypeLightboxAttribute()
    {
        return $this->getMimeType($this->attributes['lightbox']);
    }
    private function getMimeType($value)
    {
        if (!$value) {
            return null;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_buffer($finfo, $value);
        finfo_close($finfo);
        return $mime;
    }
}
