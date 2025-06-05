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
        Schema::table('juego_imagen', function (Blueprint $table) {
            if (Schema::hasColumn('juego_imagen', 'url')) {
                $table->dropColumn('url');
            }
        });
        // Agrega la columna imagen tipo LONGBLOB
        DB::statement('ALTER TABLE juego_imagen ADD imagen LONGBLOB AFTER id_juego');
        // Agrega la columna categoria tipo enum
        Schema::table('juego_imagen', function (Blueprint $table) {
            $table->enum('categoria', ['horizontal', 'vertical', 'personaje'])->default('horizontal')->after('imagen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('juego_imagen', function (Blueprint $table) {
            $table->dropColumn(['imagen', 'categoria']);
            $table->string('url')->nullable()->after('id_juego');
        });
    }
};
