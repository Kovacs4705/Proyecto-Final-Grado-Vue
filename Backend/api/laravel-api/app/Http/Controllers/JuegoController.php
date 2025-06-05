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
        summary: "Listar todos los juegos con sus imágenes y categorías (paginado, solo listado)",
        tags: ["Juego"],
        parameters: [
            new OA\Parameter(
                name: "pagina",
                in: "query",
                required: false,
                description: "Número de página",
                schema: new OA\Schema(type: "integer", default: 1)
            ),
            new OA\Parameter(
                name: "registrosPorPagina",
                in: "query",
                required: false,
                description: "Cantidad de registros por página",
                schema: new OA\Schema(type: "integer", default: 10)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de juegos con imágenes (solo listado, sin metadatos de paginación)",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        allOf: [
                            new OA\Schema(ref: "#/components/schemas/Juego"),
                            new OA\Schema(
                                properties: [
                                    new OA\Property(
                                        property: "juego_imagens",
                                        type: "array",
                                        items: new OA\Items(ref: "#/components/schemas/JuegoImagen")
                                    )
                                ]
                            )
                        ]
                    )
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $pagina = $request->query('pagina', 1);
        $registrosPorPagina = $request->query('registrosPorPagina', 10);

        $juegos = Juego::with('juego_imagens')->paginate($registrosPorPagina, ['*'], 'page', $pagina);

        // Solo retorna el listado (array de juegos)
        return response()->json($juegos->items());
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
        summary: "Obtener un juego por ID con sus imágenes y categorías",
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
                description: "Juego encontrado con imágenes",
                content: new OA\JsonContent(
                    allOf: [
                        new OA\Schema(ref: "#/components/schemas/Juego"),
                        new OA\Schema(
                            properties: [
                                new OA\Property(
                                    property: "juego_imagens",
                                    type: "array",
                                    items: new OA\Items(ref: "#/components/schemas/JuegoImagen")
                                )
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Juego no encontrado"
            )
        ]
    )]
    public function show(Juego $juego)
    {
        $juego->load('juego_imagens');
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

    #[OA\Get(
        path: "/api/juegos/filtrar",
        summary: "Filtrar juegos por nombre, género y/o plataforma",
        tags: ["Juego"],
        parameters: [
            new OA\Parameter(
                name: "nombre",
                in: "query",
                required: false,
                description: "Filtrar por nombre del juego",
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "genero",
                in: "query",
                required: false,
                description: "Filtrar por género",
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "plataforma",
                in: "query",
                required: false,
                description: "Filtrar por plataforma",
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de juegos filtrados",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Juego")
                )
            )
        ]
    )]
    public function filtrar(Request $request)
    {
        $query = Juego::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('genero')) {
            $query->where('genero', 'like', '%' . $request->genero . '%');
        }
        if ($request->filled('plataforma')) {
            $query->where('plataforma', 'like', '%' . $request->plataforma . '%');
        }

        $juegos = $query->with('juego_imagens')->get();

        return response()->json($juegos);
    }
}
