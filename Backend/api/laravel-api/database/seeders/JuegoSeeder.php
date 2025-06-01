<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Juego;
use Illuminate\Support\Facades\DB;
class JuegoSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Juego::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 10; $i++) {
            Juego::create([
                'nombre' => "Juego $i",
                'desarrollador' => "Dev $i",
                'editor' => "Editor $i",
                'fecha_lanzamiento' => now()->subDays($i),
                'precio' => rand(10, 60),
                'descuento' => rand(0, 20),
            ]);
        }
    }
}