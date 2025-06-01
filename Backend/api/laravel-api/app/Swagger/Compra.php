<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Respuesta
#[OA\Schema(
    schema: "Compra",
    type: "object",
    properties: [
        new OA\Property(property: "id_compra", type: "integer", example: 10),
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "id_juego", type: "integer", example: 6),
        new OA\Property(property: "fecha_compra", type: "string", format: "date-time", example: "2025-03-20 14:11:06"),
        new OA\Property(property: "precio_final", type: "number", format: "float", example: 14.99),
    ]
)]
class Compra { public $dummy; }

// Creación (POST)
#[OA\Schema(
    schema: "CompraCreate",
    type: "object",
    required: ["dni_usuario", "id_juego", "precio_final"],
    properties: [
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "id_juego", type: "integer", example: 6),
        new OA\Property(property: "precio_final", type: "number", format: "float", example: 14.99),
    ]
)]
class CompraCreate { public $dummy; }

// Actualización (PUT/PATCH)
#[OA\Schema(
    schema: "CompraUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "precio_final", type: "number", format: "float", example: 14.99),
    ]
)]
class CompraUpdate { public $dummy; }