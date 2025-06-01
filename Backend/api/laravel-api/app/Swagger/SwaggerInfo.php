<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Proyecto Final Grado API",
    version: "1.0.0",
    description: "Documentacion de la API para el Proyecto Final de Grado",
    contact: new OA\Contact(
         name: "Alejandro Solar, David Kovacs",
        email: "alejandrosolarruiz@gmail.com"
    )
)]
class SwaggerInfo { public $dummy; }