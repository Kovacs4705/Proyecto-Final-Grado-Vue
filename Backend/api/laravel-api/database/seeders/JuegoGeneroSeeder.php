<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\JuegoGenero;
use Illuminate\Support\Facades\DB;
class JuegoGeneroSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        JuegoGenero::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 10; $i++) {
            JuegoGenero::create([
                'id_juego' => $i,
                'id_genero' => $i,
            ]);
        }
    }
}