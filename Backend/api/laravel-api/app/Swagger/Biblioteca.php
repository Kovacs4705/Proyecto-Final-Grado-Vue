<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Respuesta
#[OA\Schema(
    schema: "Biblioteca",
    type: "object",
    properties: [
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "id_juego", type: "integer", example: 1),
        new OA\Property(property: "horas_jugadas", type: "integer", example: 12),
        new OA\Property(property: "ultima_vez_jugado", type: "string", format: "date-time", example: "2025-05-31 18:00:00"),
    ]
)]
class Biblioteca { public $dummy; }

// Creación (POST)
#[OA\Schema(
    schema: "BibliotecaCreate",
    type: "object",
    required: ["dni_usuario", "id_juego"],
    properties: [
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "id_juego", type: "integer", example: 1),
    ]
)]
class BibliotecaCreate { public $dummy; }

// Actualización (PUT/PATCH)
#[OA\Schema(
    schema: "BibliotecaUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "horas_jugadas", type: "integer", example: 12),
        new OA\Property(property: "ultima_vez_jugado", type: "string", format: "date-time", example: "2025-05-31 18:00:00"),
    ]
)]
class BibliotecaUpdate { public $dummy; }