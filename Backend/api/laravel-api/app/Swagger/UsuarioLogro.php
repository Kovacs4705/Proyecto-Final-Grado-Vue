<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Respuesta
#[OA\Schema(
    schema: "UsuarioLogro",
    type: "object",
    properties: [
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "id_logro", type: "integer", example: 6),
        new OA\Property(property: "fecha_obtencion", type: "string", format: "date-time", example: "2025-03-20 14:12:39"),
    ]
)]
class UsuarioLogro { public $dummy; }

// Creación (POST)
#[OA\Schema(
    schema: "UsuarioLogroCreate",
    type: "object",
    required: ["dni_usuario", "id_logro"],
    properties: [
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "id_logro", type: "integer", example: 6),
    ]
)]
class UsuarioLogroCreate { public $dummy; }

// Actualización (PUT/PATCH)
#[OA\Schema(
    schema: "UsuarioLogroUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "fecha_obtencion", type: "string", format: "date-time", example: "2025-03-20 14:12:39"),
    ]
)]
class UsuarioLogroUpdate { public $dummy; }