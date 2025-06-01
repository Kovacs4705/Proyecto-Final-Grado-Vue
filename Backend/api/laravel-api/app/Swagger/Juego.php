<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Esquema para respuesta (GET, PUT, etc.)
#[OA\Schema(
    schema: "Juego",
    type: "object",
    properties: [
        new OA\Property(property: "id_juego", type: "integer", example: 1),
        new OA\Property(property: "nombre", type: "string", example: "CyberQuest"),
        new OA\Property(property: "desarrollador", type: "string", example: "TechSoft"),
        new OA\Property(property: "editor", type: "string", example: "GameHouse"),
        new OA\Property(property: "fecha_lanzamiento", type: "string", format: "date", example: "2023-06-15"),
        new OA\Property(property: "precio", type: "number", format: "float", example: 49.99),
        new OA\Property(property: "descuento", type: "number", format: "float", example: 10.00),
    ]
)]
class Juego { public $dummy; }

// Esquema para creación (POST)
#[OA\Schema(
    schema: "JuegoCreate",
    type: "object",
    required: ["nombre", "precio"],
    properties: [
        new OA\Property(property: "nombre", type: "string", example: "CyberQuest"),
        new OA\Property(property: "desarrollador", type: "string", example: "TechSoft"),
        new OA\Property(property: "editor", type: "string", example: "GameHouse"),
        new OA\Property(property: "fecha_lanzamiento", type: "string", format: "date", example: "2023-06-15"),
        new OA\Property(property: "precio", type: "number", format: "float", example: 49.99),
        new OA\Property(property: "descuento", type: "number", format: "float", example: 10.00),
    ]
)]
class JuegoCreate { public $dummy; }

// Esquema para actualización (PUT/PATCH)
#[OA\Schema(
    schema: "JuegoUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "nombre", type: "string", example: "CyberQuest"),
        new OA\Property(property: "desarrollador", type: "string", example: "TechSoft"),
        new OA\Property(property: "editor", type: "string", example: "GameHouse"),
        new OA\Property(property: "fecha_lanzamiento", type: "string", format: "date", example: "2023-06-15"),
        new OA\Property(property: "precio", type: "number", format: "float", example: 49.99),
        new OA\Property(property: "descuento", type: "number", format: "float", example: 10.00),
    ]
)]
class JuegoUpdate { public $dummy; }