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
}
