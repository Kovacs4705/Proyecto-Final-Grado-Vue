<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Respuesta
#[OA\Schema(
    schema: "Resena",
    type: "object",
    properties: [
        new OA\Property(property: "id_reseña", type: "integer", example: 10),
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "id_juego", type: "integer", example: 6),
        new OA\Property(property: "calificación", type: "integer", example: 5),
        new OA\Property(property: "comentario", type: "string", example: "Un metroidvania increíble, gran exploración."),
        new OA\Property(property: "fecha_publicacion", type: "string", format: "date-time", example: "2025-03-20 14:14:55"),
    ]
)]
class Resena { public $dummy; }

// Creación (POST)
#[OA\Schema(
    schema: "ResenaCreate",
    type: "object",
    required: ["dni_usuario", "id_juego", "calificación"],
    properties: [
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "id_juego", type: "integer", example: 6),
        new OA\Property(property: "calificación", type: "integer", example: 5),
        new OA\Property(property: "comentario", type: "string", example: "Un metroidvania increíble, gran exploración."),
    ]
)]
class ResenaCreate { public $dummy; }

// Actualización (PUT/PATCH)
#[OA\Schema(
    schema: "ResenaUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "calificación", type: "integer", example: 5),
        new OA\Property(property: "comentario", type: "string", example: "Un metroidvania increíble, gran exploración."),
    ]
)]
class ResenaUpdate { public $dummy; }