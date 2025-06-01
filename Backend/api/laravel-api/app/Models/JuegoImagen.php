<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JuegoImagen
 * 
 * @property int $id_imagen
 * @property int $id_juego
 * @property string $url
 * 
 * @property Juego $juego
 *
 * @package App\Models
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
		'url'
	];

	public function juego()
	{
		return $this->belongsTo(Juego::class, 'id_juego');
	}
}
