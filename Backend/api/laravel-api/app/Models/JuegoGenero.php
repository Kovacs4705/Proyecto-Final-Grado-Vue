<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JuegoGenero
 * 
 * @property int $id_juego
 * @property int $id_genero
 * 
 * @property Juego $juego
 * @property Genero $genero
 *
 * @package App\Models
 */
class JuegoGenero extends Model
{
	protected $table = 'juego_genero';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_juego' => 'int',
		'id_genero' => 'int'
	];

	public function juego()
	{
		return $this->belongsTo(Juego::class, 'id_juego');
	}

	public function genero()
	{
		return $this->belongsTo(Genero::class, 'id_genero');
	}
}
