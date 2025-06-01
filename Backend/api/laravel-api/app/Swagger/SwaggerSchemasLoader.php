<?php

namespace App\Swagger;

class SwaggerSchemasLoader
{
    public function __construct()
    {
        new SwaggerInfo();
        new Biblioteca();
        new Compra();
        new Genero();
        new Juego();
        new JuegoGenero();
        new JuegoImagen();
        new Logro();
        new Resena();
        new Usuario();
        new UsuarioLogro();
        new Noticia();
    }
}