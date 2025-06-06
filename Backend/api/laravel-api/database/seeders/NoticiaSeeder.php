<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;

class NoticiaSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Noticia::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ruta absoluta a la carpeta de imágenes
        $imagenesPath = realpath(base_path('/imagenes'));
        if (!$imagenesPath) {
            throw new \Exception("La carpeta de imágenes no existe: " . base_path('/imagenes'));
        }

        // Busca imágenes con extensiones válidas (insensible a mayúsculas)
        $archivos = glob($imagenesPath . '/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);

        $totalImagenes = count($archivos);

        if ($totalImagenes === 0) {
            throw new \Exception("No se encontraron imágenes en la carpeta: $imagenesPath");
        }

        // Configura el manager de Intervention Image
        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        // Tamaño deseado para portada y lightbox (ajusta según tu diseño)
        $portadaSize = [495, 302];
        $lightboxSize = [1400, 720];

        for ($i = 1; $i <= 10; $i++) {
            $portadaPath = $archivos[($i) % $totalImagenes];
            $lightboxPath = $archivos[($i) % $totalImagenes];

            // Procesar portada
            $portadaBin = null;
            if (file_exists($portadaPath)) {
                $img = $manager->read($portadaPath)->cover($portadaSize[0], $portadaSize[1]);
                $portadaBin = (string) $img->toJpeg();
            }

            // Procesar lightbox
            $lightboxBin = null;
            if (file_exists($lightboxPath)) {
                $img = $manager->read($lightboxPath)->cover($lightboxSize[0], $lightboxSize[1]);
                $lightboxBin = (string) $img->toJpeg();
            }

            // Generar texto lorem ipsum de al menos 2000 caracteres
            $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc ut laoreet dictum, massa erat ultricies enim, nec dictum ex nulla ac nisi. ";
            $cuerpo = '';
            while (strlen($cuerpo) < 2000) {
                $cuerpo .= $lorem;
            }
            $cuerpo = substr($cuerpo, 0, 2000);

            Noticia::create([
                'titulo' => "Noticia $i",
                'descripcion' => "Descripción corta de la noticia $i",
                'cuerpo' => $cuerpo,
                'portada' => $portadaBin,
                'lightbox' => $lightboxBin,
            ]);
        }
    }
}
