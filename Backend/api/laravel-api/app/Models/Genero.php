<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Genero
 * 
 * @property int $id_genero
 * @property string $nombre
 * @property string|null $imagen
 * 
 * @property Collection|Juego[] $juegos
 *
 * @package App\Models
 */
class Genero extends Model
{
    protected $table = 'genero';
    protected $primaryKey = 'id_genero';
    public $timestamps = false;
    protected $hidden = ['pivot'];
    protected $fillable = [
        'nombre',
        'imagen'
    ];

    public function juegos()
    {
        return $this->belongsToMany(Juego::class, 'juego_genero', 'id_genero', 'id_juego');
    }

    public function setImagenAttribute($value)
    {
        if (empty($value) || is_null($value)) {
            $this->attributes['imagen'] = null;
            return;
        }
        // Elimina prefijo base64 si existe
        if (strpos($value, 'base64,') !== false) {
            $value = substr($value, strpos($value, 'base64,') + 7);
        }
        // Si es base64, decodifica antes de guardar
        if (base64_encode(base64_decode($value, true)) === $value) {
            $this->attributes['imagen'] = base64_decode($value);
        } else {
            $this->attributes['imagen'] = $value;
        }
    }

    public function getImagenAttribute($value)
    {
        return $value ? base64_encode($value) : null;
    }

    public function getMimeTypeAttribute()
    {
        if (empty($this->attributes['imagen'])) {
            return null;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_buffer($finfo, $this->attributes['imagen']);
        finfo_close($finfo);
        return $mime;
    }
}
