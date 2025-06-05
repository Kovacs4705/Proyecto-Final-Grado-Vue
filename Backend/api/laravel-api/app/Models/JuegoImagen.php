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

    // Mutator para devolver la imagen como base64 en JSON
    public function getImagenAttribute($value)
    {
        return base64_encode($value);
    }
}
