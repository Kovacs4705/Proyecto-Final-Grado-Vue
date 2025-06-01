<?php


namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Biblioteca;
use Illuminate\Support\Facades\DB;

class BibliotecaSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Biblioteca::truncate();
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

        $combinaciones = [];
        foreach ($dnis as $dni) {
            for ($juego = 1; $juego <= 10; $juego++) {
                $combinaciones[] = [$dni, $juego];
            }
        }

        shuffle($combinaciones);

        foreach (array_slice($combinaciones, 0, 100) as [$dni, $juego]) {
            Biblioteca::create([
                'dni_usuario' => $dni,
                'id_juego' => $juego,
                'horas_jugadas' => rand(1, 200),
                'ultima_vez_jugado' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}