<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\JuegoImagen;
use Illuminate\Support\Facades\DB;

class JuegoImagenSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        JuegoImagen::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categorias = ['horizontal', 'vertical', 'personaje'];

        for ($i = 1; $i <= 10; $i++) {
            JuegoImagen::create([
                'id_juego' => $i,
                'imagen' => random_bytes(12000), // 12 KB de datos binarios simulados
                'categoria' => $categorias[array_rand($categorias)],
            ]);
        }
    }
}