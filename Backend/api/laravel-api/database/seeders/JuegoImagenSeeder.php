<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JuegoImagen;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;


class JuegoImagenSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        JuegoImagen::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categorias = [
            'horizontal' => [
                'balatroPortada.png',
                'Epic+Games+Node_ue-alt-1920x1080-e653a4a4dae65307fd2420076abe44bb71b22f06.png',
                'hadesPortada.jpg'
            ],
            'vertical' => [
                'balatro2.jpeg',
                'Epic+Games+Node_ut-1920x1080-416b0b679e572854df52c39154aff5945328c04d (1).png',
                'hades2.jpg'
            ],
            'personaje' => [
                'balatro3.jpeg',
                'hades3.webp'
            ]
        ];

        // Tamaños por categoría
        $sizes = [
            'horizontal' => [495, 302],
            'vertical' => [203, 261],
            'personaje' => [512, 512],
        ];

        $juegos = range(1, 10);
        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        foreach ($juegos as $i) {
            foreach ($categorias as $categoria => $archivos) {
                $archivo = $archivos[($i - 1) % count($archivos)];
                $ruta = database_path('../imagenes/' . $archivo);
                echo "Procesando imagen: $ruta\n";

                if (file_exists($ruta)) {
                    // Redimensiona la imagen según la categoría
                    $image = $manager->read($ruta)->cover($sizes[$categoria][0], $sizes[$categoria][1]);
                    $binario = (string) $image->toJpeg(); // o toPng()

                    JuegoImagen::create([
                        'id_juego' => $i,
                        'imagen' => $binario,
                        'categoria' => $categoria,
                    ]);
                }
            }
        }
    }
}
