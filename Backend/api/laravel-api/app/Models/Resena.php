<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reseña
 *
 * @property int $id_reseña
 * @property string $dni_usuario
 * @property int $id_juego
 * @property int|null $calificación
 * @property string|null $comentario
 * @property Carbon $fecha_publicacion
 *
 * @property Usuario $usuario
 * @property Juego $juego
 *
 * @package App\Models
 */
class Resena extends Model
{
	protected $table = 'resena';
	protected $primaryKey = 'id_resena';
	public $timestamps = false;

	protected $casts = [
		'id_juego' => 'int',
		'calificación' => 'int',
		'fecha_publicacion' => 'datetime'
	];

	protected $fillable = [
		'dni_usuario',
		'id_juego',
		'calificación',
		'comentario',
		'fecha_publicacion'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'dni_usuario');
	}

	public function juego()
	{
		return $this->belongsTo(Juego::class, 'id_juego');
	}
}
