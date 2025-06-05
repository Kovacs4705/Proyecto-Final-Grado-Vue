<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Models\Noticia;


#[OA\Tag(
    name: "Noticia",
    description: "Operaciones relacionadas con las noticias"
)]
class NoticiaController extends Controller
{
    #[OA\Get(
        path: "/api/noticias",
        summary: "Listar todas las noticias paginadas (solo listado)",
        tags: ["Noticia"],
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
                description: "Lista de noticias (solo listado, sin metadatos de paginación)",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Noticia")
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $pagina = $request->query('pagina', 1);
        $registrosPorPagina = $request->query('registrosPorPagina', 10);

        $noticias = Noticia::paginate($registrosPorPagina, ['*'], 'page', $pagina);

        // Solo retorna el listado (array de noticias)
        return response()->json($noticias->items());
    }

    #[OA\Post(
        path: "/api/noticias",
        summary: "Crear una nueva noticia",
        tags: ["Noticia"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/NoticiaCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Noticia creada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Noticia")
            )
        ]
    )]
    public function store(Request $request)
    {
        $noticia = Noticia::create($request->all());
        return response()->json($noticia, 201);
    }

    #[OA\Get(
        path: "/api/noticias/{id}",
        summary: "Obtener una noticia por ID",
        tags: ["Noticia"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la noticia",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Noticia encontrada",
                content: new OA\JsonContent(ref: "#/components/schemas/Noticia")
            ),
            new OA\Response(
                response: 404,
                description: "Noticia no encontrada"
            )
        ]
    )]
    public function show($id)
    {
        $noticia = Noticia::find($id);
        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }
        return response()->json($noticia);
    }

    #[OA\Put(
        path: "/api/noticias/{id}",
        summary: "Actualizar una noticia existente",
        tags: ["Noticia"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la noticia",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/NoticiaUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Noticia actualizada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Noticia")
            ),
            new OA\Response(
                response: 404,
                description: "Noticia no encontrada"
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        $noticia = Noticia::find($id);
        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }
        $noticia->update($request->all());
        return response()->json($noticia);
    }

    #[OA\Delete(
        path: "/api/noticias/{id}",
        summary: "Eliminar una noticia",
        tags: ["Noticia"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la noticia",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Noticia eliminada correctamente",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Noticia eliminada correctamente")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Noticia no encontrada"
            )
        ]
    )]
    public function destroy($id)
    {
        $noticia = Noticia::find($id);
        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }
        $noticia->delete();
        return response()->json(['message' => 'Noticia eliminada correctamente']);
    }
}
