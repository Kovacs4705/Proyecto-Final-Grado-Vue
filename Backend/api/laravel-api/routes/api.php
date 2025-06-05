<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\LogroController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\JuegoImagenController;
use App\Http\Controllers\JuegoGeneroController;
use App\Http\Controllers\UsuarioLogroController;
use App\Http\Controllers\NoticiaController;


// Rutas API RESTful para cada recurso


Route::post('login', [UsuarioController::class, 'login']);
Route::post('registrar-usuario', [UsuarioController::class, 'registrarUsuario']);
Route::get('/juegos/filtrar', [JuegoController::class, 'filtrar']);
Route::get('juegos-destacados', [JuegoController::class, 'listarDestacados']);
Route::get('juegos/buscarPorParametro', [JuegoController::class, 'buscarPorParametro']);
Route::get('biblioteca/usuario/{dni_usuario}', [BibliotecaController::class, 'getBibliotecaByIdUsuario']);
Route::apiResource('juegos', JuegoController::class);
Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('compras', CompraController::class);
Route::apiResource('generos', GeneroController::class);
Route::apiResource('logros', LogroController::class);
Route::apiResource('resenas', ResenaController::class);
Route::apiResource('biblioteca', BibliotecaController::class);
Route::apiResource('juego-imagenes', JuegoImagenController::class);
Route::apiResource('juego-genero', JuegoGeneroController::class);
Route::apiResource('usuario-logros', UsuarioLogroController::class);
Route::apiResource('noticias', NoticiaController::class);