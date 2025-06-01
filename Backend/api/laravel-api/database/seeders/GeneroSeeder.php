<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Genero;
use Illuminate\Support\Facades\DB;

class GeneroSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Genero::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 10; $i++) {
            Genero::create([
                'nombre' => "Género $i",
            ]);
        }
    }
}