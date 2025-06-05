<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;

class NoticiaSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Noticia::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ruta absoluta a la carpeta de imágenes
        $imagenesPath = realpath(base_path('../../imagenes'));
        if (!$imagenesPath) {
            throw new \Exception("La carpeta de imágenes no existe: " . base_path('../../imagenes'));
        }

        // Busca imágenes con extensiones válidas (insensible a mayúsculas)
        $archivos = glob($imagenesPath . '/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);

        $totalImagenes = count($archivos);

        if ($totalImagenes === 0) {
            throw new \Exception("No se encontraron imágenes en la carpeta: $imagenesPath");
        }

        for ($i = 1; $i <= 10; $i++) {
            $portadaPath = $archivos[($i) % $totalImagenes];
            $lightboxPath = $archivos[($i) % $totalImagenes];

            // Generar texto lorem ipsum de al menos 500 caracteres
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
                'portada' => file_get_contents($portadaPath),
                'lightbox' => file_get_contents($lightboxPath),
            ]);
        }
    }
}
