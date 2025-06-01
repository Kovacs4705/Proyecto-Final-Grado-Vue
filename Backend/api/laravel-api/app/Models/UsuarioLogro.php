<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsuarioLogro
 * 
 * @property string $dni_usuario
 * @property int $id_logro
 * @property Carbon $fecha_obtencion
 * 
 * @property Usuario $usuario
 * @property Logro $logro
 *
 * @package App\Models
 */
class UsuarioLogro extends Model
{
	protected $table = 'usuario_logro';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_logro' => 'int',
		'fecha_obtencion' => 'datetime'
	];

	protected $fillable = [
		'fecha_obtencion'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'dni_usuario');
	}

	public function logro()
	{
		return $this->belongsTo(Logro::class, 'id_logro');
	}
}
