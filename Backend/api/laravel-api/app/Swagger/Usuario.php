<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

// Esquema para respuesta (GET, PUT, etc.)
#[OA\Schema(
    schema: "Usuario",
    type: "object",
    properties: [
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "nombre", type: "string", example: "Luis Fernández"),
        new OA\Property(property: "email", type: "string", format: "email", example: "luis.fernandez@example.com"),
        new OA\Property(property: "contraseña", type: "string", example: "password1"),
        new OA\Property(property: "saldo", type: "number", format: "float", example: 50.00),
        new OA\Property(property: "avatar", type: "string", nullable: true, example: null),
        new OA\Property(property: "fecha_registro", type: "string", format: "date-time", example: "2025-03-20 14:07:08"),
        new OA\Property(property: "rol", type: "string", enum: ["usuario", "administrador"], example: "usuario"),
    ]
)]
class Usuario { public $dummy; }

// Esquema para creación (POST)
#[OA\Schema(
    schema: "UsuarioCreate",
    type: "object",
    required: ["dni_usuario", "nombre", "email", "contraseña"],
    properties: [
        new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
        new OA\Property(property: "nombre", type: "string", example: "Luis Fernández"),
        new OA\Property(property: "email", type: "string", format: "email", example: "luis.fernandez@example.com"),
        new OA\Property(property: "contraseña", type: "string", example: "password1"),
        new OA\Property(property: "saldo", type: "number", format: "float", example: 50.00),
        new OA\Property(property: "avatar", type: "string", nullable: true, example: null),
        new OA\Property(property: "rol", type: "string", enum: ["usuario", "administrador"], example: "usuario"),
    ]
)]
class UsuarioCreate { public $dummy; }

// Esquema para actualización (PUT/PATCH)
#[OA\Schema(
    schema: "UsuarioUpdate",
    type: "object",
    properties: [
        new OA\Property(property: "nombre", type: "string", example: "Luis Fernández"),
        new OA\Property(property: "email", type: "string", format: "email", example: "luis.fernandez@example.com"),
        new OA\Property(property: "contraseña", type: "string", example: "password1"),
        new OA\Property(property: "saldo", type: "number", format: "float", example: 50.00),
        new OA\Property(property: "avatar", type: "string", nullable: true, example: null),
        new OA\Property(property: "rol", type: "string", enum: ["usuario", "administrador"], example: "usuario"),
    ]
)]
class UsuarioUpdate { public $dummy; }