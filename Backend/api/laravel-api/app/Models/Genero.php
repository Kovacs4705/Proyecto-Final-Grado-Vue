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

	protected $fillable = [
		'nombre'
	];

	public function juegos()
	{
		return $this->belongsToMany(Juego::class, 'juego_genero', 'id_genero', 'id_juego');
	}
}
