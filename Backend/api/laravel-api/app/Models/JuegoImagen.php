<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JuegoImagen
 * 
 * @property int $id_imagen
 * @property int $id_juego
 * @property string $imagen
 * @property string $categoria
 * 
 * @property Juego $juego
 */
class JuegoImagen extends Model
{
    protected $table = 'juego_imagen';
    protected $primaryKey = 'id_imagen';
    public $timestamps = false;

    protected $casts = [
        'id_juego' => 'int'
    ];

    protected $fillable = [
        'id_juego',
        'imagen',
        'categoria'
    ];

    public function juego()
    {
        return $this->belongsTo(Juego::class, 'id_juego');
    }


    public function setImagenAttribute($value)
    {
        if (empty($value) || is_null($value)) {
            $this->attributes['imagen'] = null;
            return;
        }
        // Si es base64, decodifica antes de guardar
        if (base64_encode(base64_decode($value, true)) === $value) {
            $this->attributes['imagen'] = base64_decode($value);
        } else {
            $this->attributes['imagen'] = $value;
        }
    }

    // Mutator para devolver la imagen como base64 en JSON
    public function getImagenAttribute($value)
    {
        return base64_encode($value);
    }

    public function getMimeTypeAttribute()
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_buffer($finfo, $this->attributes['imagen']);
        finfo_close($finfo);
        return $mime;
    }
}
