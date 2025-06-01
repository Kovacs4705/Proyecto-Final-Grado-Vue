<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Biblioteca
 * 
 * @property string $dni_usuario
 * @property int $id_juego
 * @property int|null $horas_jugadas
 * @property Carbon $ultima_vez_jugado
 * 
 * @property Usuario $usuario
 * @property Juego $juego
 *
 * @package App\Models
 */
class Biblioteca extends Model
{
	protected $table = 'biblioteca';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_juego' => 'int',
		'horas_jugadas' => 'int',
		'ultima_vez_jugado' => 'datetime'
	];

	protected $fillable = [
		'horas_jugadas',
		'ultima_vez_jugado'
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
