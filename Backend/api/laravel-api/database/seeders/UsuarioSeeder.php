<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
class UsuarioSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Usuario::truncate();
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
            Usuario::create([
                'dni_usuario' => $dnis[$i - 1],
                'nombre' => "Usuario $i",
                'email' => "usuario$i@email.com",
                'contraseña' => bcrypt('password' . $i),
                'saldo' => rand(0, 100),
                'avatar' => null,
                'fecha_registro' => now()->subDays($i),
                'rol' => 'usuario',
            ]);
        }
    }
}