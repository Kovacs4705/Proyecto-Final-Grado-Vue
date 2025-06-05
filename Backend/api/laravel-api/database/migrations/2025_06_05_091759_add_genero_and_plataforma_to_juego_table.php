<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('juego', function (Blueprint $table) {
            $table->string('genero')->nullable()->after('descuento');
            $table->string('plataforma')->nullable()->after('genero');
        });
    }

    public function down(): void
    {
        Schema::table('juego', function (Blueprint $table) {
            $table->dropColumn(['genero', 'plataforma']);
        });
    }
};