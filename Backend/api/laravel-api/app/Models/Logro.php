<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Logro
 * 
 * @property int $id_logro
 * @property int $id_juego
 * @property string $nombre
 * @property string|null $descripcion
 * 
 * @property Juego $juego
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Logro extends Model
{
	protected $table = 'logro';
	protected $primaryKey = 'id_logro';
	public $timestamps = false;

	protected $casts = [
		'id_juego' => 'int'
	];

	protected $fillable = [
		'id_juego',
		'nombre',
		'descripcion'
	];

	public function juego()
	{
		return $this->belongsTo(Juego::class, 'id_juego');
	}

	public function usuarios()
	{
		return $this->belongsToMany(Usuario::class, 'usuario_logro', 'id_logro', 'dni_usuario')
					->withPivot('fecha_obtencion');
	}
}
