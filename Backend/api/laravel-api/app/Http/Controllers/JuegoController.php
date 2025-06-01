<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Juego",
    description: "Operaciones relacionadas con los juegos"
)]
class JuegoController extends Controller
{
    #[OA\Get(
        path: "/api/juegos",
        summary: "Listar todos los juegos",
        tags: ["Juego"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de juegos",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Juego")
                )
            )
        ]
    )]
    public function index()
    {
        $juegos = Juego::all();
        return response()->json($juegos);
    }

    #[OA\Post(
        path: "/api/juegos",
        summary: "Crear un nuevo juego",
        tags: ["Juego"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/JuegoCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Juego creado exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Juego")
            )
        ]
    )]
    public function store(Request $request)
    {
        $juego = Juego::create($request->all());
        return response()->json($juego, 201);
    }

    #[OA\Get(
        path: "/api/juegos/{id}",
        summary: "Obtener un juego por ID",
        tags: ["Juego"],
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
                content: new OA\JsonContent(ref: "#/components/schemas/Juego")
            ),
            new OA\Response(
                response: 404,
                description: "Juego no encontrado"
            )
        ]
    )]
    public function show(Juego $juego)
    {
        return response()->json($juego);
    }

    #[OA\Put(
        path: "/api/juegos/{id}",
        summary: "Actualizar un juego existente",
        tags: ["Juego"],
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
            content: new OA\JsonContent(ref: "#/components/schemas/JuegoUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Juego actualizado exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Juego")
            ),
            new OA\Response(
                response: 404,
                description: "Juego no encontrado"
            )
        ]
    )]
    public function update(Request $request, Juego $juego)
    {
        $juego->update($request->all());
        return response()->json($juego);
    }

    #[OA\Delete(
        path: "/api/juegos/{id}",
        summary: "Eliminar un juego",
        tags: ["Juego"],
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
            ),
            new OA\Response(
                response: 404,
                description: "Juego no encontrado"
            )
        ]
    )]
    public function destroy(Juego $juego)
    {
        $juego->delete();
        return response()->json(['message' => 'Juego eliminado correctamente']);
    }

    #[OA\Get(
        path: "/api/juegos-destacados",
        summary: "Listar los 10 primeros juegos destacados",
        tags: ["Juego"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de juegos destacados",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Juego")
                )
            )
        ]
    )]
    public function listarDestacados()
    {
        $juegos = Juego::limit(10)->get();
        return response()->json($juegos);
    }

    #[OA\Get(
        path: "/api/juegos/buscarPorParametro",
        summary: "Buscar juegos por nombre o género",
        tags: ["Juego"],
        parameters: [
            new OA\Parameter(
                name: "parametro",
                in: "query",
                required: true,
                description: "Texto a buscar en el nombre del juego o en el nombre del género",
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de juegos encontrados",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Juego")
                )
            )
        ]
    )]
    public function buscarPorParametro(Request $request)
    {
        $parametro = $request->query('parametro');

        $juegos = Juego::where('nombre', 'like', "%$parametro%")
            ->orWhereHas('generos', function ($query) use ($parametro) {
                $query->where('nombre', 'like', "%$parametro%");
            })
            ->get();

        return response()->json($juegos);
    }
}