<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Juego
 * 
 * @property int $id_juego
 * @property string $nombre
 * @property string|null $desarrollador
 * @property string|null $editor
 * @property Carbon|null $fecha_lanzamiento
 * @property float $precio
 * @property float|null $descuento
 * 
 * @property Collection|Biblioteca[] $bibliotecas
 * @property Collection|Compra[] $compras
 * @property Collection|Genero[] $generos
 * @property Collection|JuegoImagen[] $juego_imagens
 * @property Collection|Logro[] $logros
 * @property Collection|Resena[] $reseñas
 *
 * @package App\Models
 */
class Juego extends Model
{
	protected $table = 'juego';
	protected $primaryKey = 'id_juego';
	public $timestamps = false;

	protected $casts = [
		'fecha_lanzamiento' => 'datetime',
		'precio' => 'float',
		'descuento' => 'float'
	];

	protected $fillable = [
		'nombre',
		'desarrollador',
		'editor',
		'fecha_lanzamiento',
		'precio',
		'descuento',
		'genero',
		'plataforma',
	];

	public function bibliotecas()
	{
		return $this->hasMany(Biblioteca::class, 'id_juego');
	}

	public function compras()
	{
		return $this->hasMany(Compra::class, 'id_juego');
	}

	public function generos()
	{
		return $this->belongsToMany(Genero::class, 'juego_genero', 'id_juego', 'id_genero');
	}

	public function juego_imagens()
	{
		return $this->hasMany(JuegoImagen::class, 'id_juego');
	}

	public function logros()
	{
		return $this->hasMany(Logro::class, 'id_juego');
	}

	public function reseñas()
	{
		return $this->hasMany(Resena::class, 'id_juego');
	}
}
