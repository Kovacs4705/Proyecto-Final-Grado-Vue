<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabla usuario
        Schema::create('usuario', function (Blueprint $table) {
            $table->string('dni_usuario', 20)->primary();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('contraseña');
            $table->float('saldo')->nullable();
            $table->string('avatar')->nullable();
            $table->dateTime('fecha_registro');
            $table->string('rol', 20)->nullable();
        });

        // Tabla juego
        Schema::create('juego', function (Blueprint $table) {
            $table->id('id_juego');
            $table->string('nombre');
            $table->string('desarrollador')->nullable();
            $table->string('editor')->nullable();
            $table->date('fecha_lanzamiento')->nullable();
            $table->float('precio');
            $table->float('descuento')->nullable();
        });

        // Tabla genero
        Schema::create('genero', function (Blueprint $table) {
            $table->id('id_genero');
            $table->string('nombre');
        });

        // Tabla compra
        Schema::create('compra', function (Blueprint $table) {
            $table->id('id_compra');
            $table->string('dni_usuario', 20);
            $table->unsignedBigInteger('id_juego');
            $table->dateTime('fecha_compra');
            $table->float('precio_final');
            $table->foreign('dni_usuario')->references('dni_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('id_juego')->references('id_juego')->on('juego')->onDelete('cascade');
        });

        // Tabla logro
        Schema::create('logro', function (Blueprint $table) {
            $table->id('id_logro');
            $table->unsignedBigInteger('id_juego');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->foreign('id_juego')->references('id_juego')->on('juego')->onDelete('cascade');
        });

        // Tabla resena
        Schema::create('resena', function (Blueprint $table) {
            $table->id('id_resena');
            $table->string('dni_usuario', 20);
            $table->unsignedBigInteger('id_juego');
            $table->integer('calificación');
            $table->string('comentario')->nullable();
            $table->dateTime('fecha_publicacion');
            $table->foreign('dni_usuario')->references('dni_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('id_juego')->references('id_juego')->on('juego')->onDelete('cascade');
        });

        // Tabla biblioteca
        Schema::create('biblioteca', function (Blueprint $table) {
            $table->string('dni_usuario', 20);
            $table->unsignedBigInteger('id_juego');
            $table->integer('horas_jugadas')->nullable();
            $table->dateTime('ultima_vez_jugado');
            $table->primary(['dni_usuario', 'id_juego']);
            $table->foreign('dni_usuario')->references('dni_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('id_juego')->references('id_juego')->on('juego')->onDelete('cascade');
        });

        // Tabla juego_imagen
        Schema::create('juego_imagen', function (Blueprint $table) {
            $table->id('id_imagen');
            $table->unsignedBigInteger('id_juego');
            $table->string('url');
            $table->foreign('id_juego')->references('id_juego')->on('juego')->onDelete('cascade');
        });

        // Tabla juego_genero
        Schema::create('juego_genero', function (Blueprint $table) {
            $table->unsignedBigInteger('id_juego');
            $table->unsignedBigInteger('id_genero');
            $table->primary(['id_juego', 'id_genero']);
            $table->foreign('id_juego')->references('id_juego')->on('juego')->onDelete('cascade');
            $table->foreign('id_genero')->references('id_genero')->on('genero')->onDelete('cascade');
        });

        // Tabla usuario_logro
        Schema::create('usuario_logro', function (Blueprint $table) {
            $table->string('dni_usuario', 20);
            $table->unsignedBigInteger('id_logro');
            $table->dateTime('fecha_obtencion');
            $table->primary(['dni_usuario', 'id_logro']);
            $table->foreign('dni_usuario')->references('dni_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('id_logro')->references('id_logro')->on('logro')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_logro');
        Schema::dropIfExists('juego_genero');
        Schema::dropIfExists('juego_imagen');
        Schema::dropIfExists('biblioteca');
        Schema::dropIfExists('resena');
        Schema::dropIfExists('logro');
        Schema::dropIfExists('compra');
        Schema::dropIfExists('genero');
        Schema::dropIfExists('juego');
        Schema::dropIfExists('usuario');
    }
};
