<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;

class CompraSeeder extends Seeder
{
    public function run()
    {

        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Compra::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

         $dnis = [
            '12345678Z',
            '87654321X',
            '11223344A',
            '22334455B',
            '33445566C',
            '44556677D',
            '55667788E',
            '66778899F',
            '77889900G',
            '88990011H'
        ];

        for ($i = 1; $i <= 10; $i++) {
            Compra::create([
                'dni_usuario' => $dnis[array_rand($dnis)],
                'id_juego' => $i,
                'fecha_compra' => now()->subDays($i),
                'precio_final' => rand(10, 60),
            ]);
        }
    }
}