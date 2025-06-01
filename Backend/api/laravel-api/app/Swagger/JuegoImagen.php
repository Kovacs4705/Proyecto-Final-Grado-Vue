<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Respuesta
#[OA\Schema(
    schema: "JuegoImagen",
    type: "object",
    properties: [
        new OA\Property(property: "id_imagen", type: "integer", example: 1),
        new OA\Property(property: "id_juego", type: "integer", example: 2),
        new OA\Property(property: "url", type: "string", example: "https://example.com/imagen.jpg"),
        new OA\Property(property: "descripcion", type: "string", nullable: true, example: "Imagen de portada del juego"),
    ]
)]
class JuegoImagen { public $dummy; }

// Creación (POST)
#[OA\Schema(
    schema: "JuegoImagenCreate",
    type: "object",
    required: ["id_juego", "url"],
    properties: [
        new OA\Property(property: "id_juego", type: "integer", example: 2),
        new OA\Property(property: "url", type: "string", example: "https://example.com/imagen.jpg"),
        new OA\Property(property: "descripcion", type: "string", nullable: true, example: "Imagen de portada del juego"),
    ]
)]
class JuegoImagenCreate { public $dummy; }

// Actualización (PUT/PATCH)
#[OA\Schema(
    schema: "JuegoImagenUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "url", type: "string", example: "https://example.com/imagen.jpg"),
        new OA\Property(property: "descripcion", type: "string", nullable: true, example: "Imagen de portada del juego"),
    ]
)]
class JuegoImagenUpdate { public $dummy; }