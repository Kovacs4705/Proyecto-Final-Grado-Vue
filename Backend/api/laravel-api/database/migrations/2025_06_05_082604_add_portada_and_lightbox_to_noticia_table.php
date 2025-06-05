<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Elimina la columna imagen si existe
        if (Schema::hasColumn('noticia', 'imagen')) {
            Schema::table('noticia', function (Blueprint $table) {
                $table->dropColumn('imagen');
            });
        }
        // Agrega portada y lightbox como LONGBLOB
        DB::statement('ALTER TABLE noticia ADD portada LONGBLOB NULL AFTER titulo');
        DB::statement('ALTER TABLE noticia ADD lightbox LONGBLOB NULL AFTER portada');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina portada y lightbox, y vuelve a agregar imagen como LONGBLOB
        Schema::table('noticia', function (Blueprint $table) {
            $table->dropColumn(['portada', 'lightbox']);
        });
        DB::statement('ALTER TABLE noticia ADD imagen LONGBLOB NULL AFTER titulo');
    }
};