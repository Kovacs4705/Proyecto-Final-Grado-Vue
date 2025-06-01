<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Resena;

class ResenaSeeder extends Seeder
{
    public function run()
    {
        Resena::truncate(); // Limpiar la tabla antes de insertar nuevos datos

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
            Resena::create([
                'dni_usuario' => $dnis[array_rand($dnis)],
                'id_juego' => $i,
                'calificación' => rand(1, 5),
                'comentario' => "Comentario de reseña $i",
                'fecha_publicacion' => now()->subDays($i),
            ]);
        }
    }
}