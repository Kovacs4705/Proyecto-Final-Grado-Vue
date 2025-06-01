<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Compra
 * 
 * @property int $id_compra
 * @property string $dni_usuario
 * @property int $id_juego
 * @property Carbon $fecha_compra
 * @property float $precio_final
 * 
 * @property Usuario $usuario
 * @property Juego $juego
 *
 * @package App\Models
 */
class Compra extends Model
{
	protected $table = 'compra';
	protected $primaryKey = 'id_compra';
	public $timestamps = false;

	protected $casts = [
		'id_juego' => 'int',
		'fecha_compra' => 'datetime',
		'precio_final' => 'float'
	];

	protected $fillable = [
		'dni_usuario',
		'id_juego',
		'fecha_compra',
		'precio_final'
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
