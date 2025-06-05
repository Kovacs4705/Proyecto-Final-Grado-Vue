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
}