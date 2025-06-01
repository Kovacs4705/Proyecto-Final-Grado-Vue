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

        for ($i = 1; $i <= 10; $i++) {
            JuegoImagen::create([
                'id_juego' => $i,
                'url' => "https://picsum.photos/seed/juego{$i}/600/400"
            ]);
        }
    }
}