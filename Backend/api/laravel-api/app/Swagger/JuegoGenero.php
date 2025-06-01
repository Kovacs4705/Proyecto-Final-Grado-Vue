<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Respuesta
#[OA\Schema(
    schema: "JuegoGenero",
    type: "object",
    properties: [
        new OA\Property(property: "id_juego", type: "integer", example: 1),
        new OA\Property(property: "id_genero", type: "integer", example: 1),
    ]
)]
class JuegoGenero { public $dummy; }

// Creación (POST)
#[OA\Schema(
    schema: "JuegoGeneroCreate",
    type: "object",
    required: ["id_juego", "id_genero"],
    properties: [
        new OA\Property(property: "id_juego", type: "integer", example: 1),
        new OA\Property(property: "id_genero", type: "integer", example: 1),
    ]
)]
class JuegoGeneroCreate { public $dummy; }

// Actualización (PUT/PATCH)
#[OA\Schema(
    schema: "JuegoGeneroUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "id_genero", type: "integer", example: 1),
    ]
)]
class JuegoGeneroUpdate { public $dummy; }