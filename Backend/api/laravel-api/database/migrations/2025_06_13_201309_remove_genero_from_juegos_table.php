<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('juego', function (Blueprint $table) {
        $table->dropColumn('genero');
    });
}

public function down()
{
    Schema::table('juego', function (Blueprint $table) {
        $table->string('genero')->nullable(); // Ajusta el tipo si era diferente
    });
}
};
