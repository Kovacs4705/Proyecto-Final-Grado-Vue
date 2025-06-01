<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Logro;
use Illuminate\Support\Facades\DB;

class LogroSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Logro::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 10; $i++) {
            Logro::create([
                'id_juego' => $i, // Debe existir el juego con este id
                'nombre' => "Logro $i",
                'descripcion' => "Descripción del logro $i",
            ]);
        }
    }
}