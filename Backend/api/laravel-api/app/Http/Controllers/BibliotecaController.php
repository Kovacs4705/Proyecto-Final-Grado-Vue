<?php

namespace App\Http\Controllers;

use App\Models\Biblioteca;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Biblioteca",
    description: "Operaciones relacionadas con la biblioteca de juegos"
)]
class BibliotecaController extends Controller
{
    #[OA\Get(
        path: "/api/biblioteca",
        summary: "Listar todos los juegos en la biblioteca",
        tags: ["Biblioteca"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de juegos en la biblioteca",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Biblioteca")
                )
            )
        ]
    )]
    public function index()
    {
        $biblioteca = Biblioteca::all();
        return response()->json($biblioteca);
    }

    #[OA\Post(
        path: "/api/biblioteca",
        summary: "Crear un nuevo juego en la biblioteca",
        tags: ["Biblioteca"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/BibliotecaCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Juego creado exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Biblioteca")
            )
        ]
    )]
    public function store(Request $request)
    {
        $juego = Biblioteca::create($request->all());
        return response()->json($juego, 201);
    }

    #[OA\Get(
        path: "/api/biblioteca/{id}",
        summary: "Obtener un juego por ID de la biblioteca",
        tags: ["Biblioteca"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del juego",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Juego encontrado",
                content: new OA\JsonContent(ref: "#/components/schemas/Biblioteca")
            ),
            new OA\Response(
                response: 404,
                description: "Juego no encontrado"
            )
        ]
    )]
    public function show(Biblioteca $juego)
    {
        return response()->json($juego);
    }

    #[OA\Put(
        path: "/api/biblioteca/{id}",
        summary: "Actualizar un juego existente en la biblioteca",
        tags: ["Biblioteca"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del juego",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/BibliotecaUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Juego actualizado exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Biblioteca")
            )
        ]
    )]
    public function update(Request $request, Biblioteca $juego)
    {
        $juego->update($request->all());
        return response()->json($juego);
    }

    #[OA\Delete(
        path: "/api/biblioteca/{id}",
        summary: "Eliminar un juego de la biblioteca",
        tags: ["Biblioteca"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del juego",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Juego eliminado correctamente",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Juego eliminado correctamente")
                    ]
                )
            )
        ]
    )]
    public function destroy(Biblioteca $juego)
    {
        $juego->delete();
        return response()->json(['message' => 'Juego eliminado correctamente']);
    }

    #[OA\Get(
        path: "/api/biblioteca/usuario/{dni_usuario}",
        summary: "Listar todos los juegos de la biblioteca de un usuario por DNI",
        tags: ["Biblioteca"],
        parameters: [
            new OA\Parameter(
                name: "dni_usuario",
                in: "path",
                required: true,
                description: "DNI del usuario",
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de juegos en la biblioteca del usuario",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Juego")
                )
            )
        ]
    )]
    public function getBibliotecaByIdUsuario($dni_usuario)
    {
        $juegos = \App\Models\Juego::whereIn(
            'id_juego',
            Biblioteca::where('dni_usuario', $dni_usuario)->pluck('id_juego')
        )->get();

        return response()->json($juegos);
    }
}