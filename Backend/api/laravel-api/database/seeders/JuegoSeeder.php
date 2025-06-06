<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Juego;
use App\Models\Genero;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;


class JuegoSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Juego::truncate();
        DB::table('juego_genero')->truncate(); // Si tienes tabla pivote
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $generos = Genero::all();
        $plataformas = ['PC', 'PlayStation', 'Xbox', 'Switch', 'Móvil'];

        for ($i = 1; $i <= 10; $i++) {
            $juego = Juego::create([
                'nombre' => "Juego $i",
                'desarrollador' => "Dev $i",
                'editor' => "Editor $i",
                'fecha_lanzamiento' => now()->subDays($i),
                'precio' => rand(10, 60),
                'descuento' => rand(0, 20),
                'plataforma' => $plataformas[array_rand($plataformas)],
            ]);

            // Asigna 1 o más géneros aleatorios
            $generosIds = $generos->random(rand(1, 2))->pluck('id_genero')->toArray();
            $juego->generos()->attach($generosIds);
        }
    }
}
