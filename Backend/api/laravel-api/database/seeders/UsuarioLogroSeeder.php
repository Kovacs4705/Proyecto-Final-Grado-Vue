<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\UsuarioLogro;
use Illuminate\Support\Facades\DB;
class UsuarioLogroSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        UsuarioLogro::truncate();
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
            UsuarioLogro::create([
                'dni_usuario' => $dnis[array_rand($dnis)],
                'id_logro' => $i,
                'fecha_obtencion' => now()->subDays($i),
            ]);
        }
    }
}