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
                'imagen' => "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAEklEQVR42mP8z8BQz0AEYBxVSFMAAAeZAf7LU9RQAAAAAElFTkSuQmCC",
                'descripcion' => "Descripción corta de la noticia $i",
                'cuerpo' => "Texto completo de la noticia $i",
            ]);
        }
    }
}