<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;

class NoticiaSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Noticia::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 10; $i++) {
            Noticia::create([
                'titulo' => "Noticia $i",
                'descripcion' => "Descripción corta de la noticia $i",
                'cuerpo' => "Texto completo de la noticia $i",
                // Simula imágenes binarias para portada y lightbox (puedes usar datos reales en producción)
                'portada' => random_bytes(10000),   // 10 KB de datos binarios simulados
                'lightbox' => random_bytes(15000),  // 15 KB de datos binarios simulados
            ]);
        }
    }
}