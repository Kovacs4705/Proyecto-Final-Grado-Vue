<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property string $dni_usuario
 * @property string $nombre
 * @property string $email
 * @property string $contraseña
 * @property float|null $saldo
 * @property string|null $avatar
 * @property Carbon $fecha_registro
 * @property string|null $rol
 * 
 * @property Collection|Biblioteca[] $bibliotecas
 * @property Collection|Compra[] $compras
 * @property Collection|Resena[] $reseñas
 * @property Collection|Logro[] $logros
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuario';
	protected $primaryKey = 'dni_usuario';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'saldo' => 'float',
		'fecha_registro' => 'datetime'
	];

	protected $fillable = [
		'dni_usuario',
		'nombre',
		'email',
		'contraseña',
		'saldo',
		'avatar',
		'fecha_registro',
		'rol'
	];

	public function bibliotecas()
	{
		return $this->hasMany(Biblioteca::class, 'dni_usuario');
	}

	public function compras()
	{
		return $this->hasMany(Compra::class, 'dni_usuario');
	}

	public function reseñas()
	{
		return $this->hasMany(Resena::class, 'dni_usuario');
	}

	public function logros()
	{
		return $this->belongsToMany(Logro::class, 'usuario_logro', 'dni_usuario', 'id_logro')
					->withPivot('fecha_obtencion');
	}
}
