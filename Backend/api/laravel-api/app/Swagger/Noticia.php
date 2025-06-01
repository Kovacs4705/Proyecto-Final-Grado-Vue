<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Respuesta
#[OA\Schema(
    schema: "Noticia",
    type: "object",
    properties: [
        new OA\Property(property: "id_noticia", type: "integer", example: 1),
        new OA\Property(property: "titulo", type: "string", example: "Título de la noticia"),
        new OA\Property(property: "imagen", type: "string", format: "byte", nullable: true, description: "Imagen en formato base64"),
        new OA\Property(property: "descripcion", type: "string", example: "Descripción corta"),
        new OA\Property(property: "cuerpo", type: "string", example: "Texto completo de la noticia"),
    ]
)]
class Noticia { public $dummy; }

// Creación (POST)
#[OA\Schema(
    schema: "NoticiaCreate",
    type: "object",
    required: ["titulo", "descripcion", "cuerpo"],
    properties: [
        new OA\Property(property: "titulo", type: "string", example: "Título de la noticia"),
        new OA\Property(property: "imagen", type: "string", format: "byte", nullable: true, description: "Imagen en formato base64"),
        new OA\Property(property: "descripcion", type: "string", example: "Descripción corta"),
        new OA\Property(property: "cuerpo", type: "string", example: "Texto completo de la noticia"),
    ]
)]
class NoticiaCreate { public $dummy; }

// Actualización (PUT/PATCH)
#[OA\Schema(
    schema: "NoticiaUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "titulo", type: "string", example: "Título de la noticia"),
        new OA\Property(property: "imagen", type: "string", format: "byte", nullable: true, description: "Imagen en formato base64"),
        new OA\Property(property: "descripcion", type: "string", example: "Descripción corta"),
        new OA\Property(property: "cuerpo", type: "string", example: "Texto completo de la noticia"),
    ]
)]
class NoticiaUpdate { public $dummy; }