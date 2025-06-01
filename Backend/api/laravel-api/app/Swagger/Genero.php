<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Respuesta
#[OA\Schema(
    schema: "Genero",
    type: "object",
    properties: [
        new OA\Property(property: "id_genero", type: "integer", example: 1),
        new OA\Property(property: "nombre", type: "string", example: "Acción"),
    ]
)]
class Genero { public $dummy; }

// Creación (POST)
#[OA\Schema(
    schema: "GeneroCreate",
    type: "object",
    required: ["nombre"],
    properties: [
        new OA\Property(property: "nombre", type: "string", example: "Acción"),
    ]
)]
class GeneroCreate { public $dummy; }

// Actualización (PUT/PATCH)
#[OA\Schema(
    schema: "GeneroUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "nombre", type: "string", example: "Acción"),
    ]
)]
class GeneroUpdate { public $dummy; }