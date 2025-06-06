<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Genero;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;


class GeneroSeeder extends Seeder
{
    public function run()
    {
       // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Genero::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Lista de nombres de archivos de imagen disponibles
        $imagenes = [
            'balatro2.jpeg',
            'balatro3.jpeg',
            'balatroPortada.png',
            'Epic+Games+Node_ue-alt-1920x1080-e653a4a4dae65307fd2420076abe44bb71b22f06.png',
            'Epic+Games+Node_ut-1920x1080-416b0b679e572854df52c39154aff5945328c04d (1).png',
            'hades2.jpg',
            'hades3.webp',
            'hadesPortada.jpg',
            'HollowKnight2png.jpg',
            'HollowKnight3.webp',
            'HollowKnightPortada.png',
            'juego1.png',
            'juego2@2x.png',
            'juego4.png',
            'reddead@2x.png',
            'stardewValley2.png',
            'stardewValley3.png',
            'stardewValleyPortada.png',
            'vampireSurvivors2.jpg',
            'vampireSurvivors3.webp',
            'VampireSurvivorsPortada.jpg',
        ];

        // Tamaño deseado para la imagen del género
        $size = [295, 139]; // Puedes ajustar el tamaño según tu diseño

        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        for ($i = 1; $i <= 10; $i++) {
            // Selecciona una imagen aleatoria
            $imagen = $imagenes[array_rand($imagenes)];
            $ruta = database_path('../imagenes/' . $imagen);

            $binario = null;
            if (file_exists($ruta)) {
                $img = $manager->read($ruta)->cover($size[0], $size[1]);
                $binario = (string) $img->toJpeg();
            }

            Genero::create([
                'nombre' => "Género $i",
                'imagen' => $binario,
            ]);
        }
    }
}