<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Respuesta
#[OA\Schema(
    schema: "Logro",
    type: "object",
    properties: [
        new OA\Property(property: "id_logro", type: "integer", example: 1),
        new OA\Property(property: "id_juego", type: "integer", example: 1),
        new OA\Property(property: "nombre", type: "string", example: "Primer nivel completado"),
        new OA\Property(property: "descripcion", type: "string", example: "Supera el primer nivel del juego."),
    ]
)]
class Logro { public $dummy; }

// Creación (POST)
#[OA\Schema(
    schema: "LogroCreate",
    type: "object",
    required: ["id_juego", "nombre"],
    properties: [
        new OA\Property(property: "id_juego", type: "integer", example: 1),
        new OA\Property(property: "nombre", type: "string", example: "Primer nivel completado"),
        new OA\Property(property: "descripcion", type: "string", example: "Supera el primer nivel del juego."),
    ]
)]
class LogroCreate { public $dummy; }

// Actualización (PUT/PATCH)
#[OA\Schema(
    schema: "LogroUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "nombre", type: "string", example: "Primer nivel completado"),
        new OA\Property(property: "descripcion", type: "string", example: "Supera el primer nivel del juego."),
    ]
)]
class LogroUpdate { public $dummy; }