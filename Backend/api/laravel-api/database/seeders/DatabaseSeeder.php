<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call([
            JuegoSeeder::class,
            UsuarioSeeder::class,
            CompraSeeder::class,
            GeneroSeeder::class,
            LogroSeeder::class,
            ResenaSeeder::class,
            BibliotecaSeeder::class,
            JuegoImagenSeeder::class,
            JuegoGeneroSeeder::class,
            UsuarioLogroSeeder::class,
            NoticiaSeeder::class,
        ]);
    }
}
