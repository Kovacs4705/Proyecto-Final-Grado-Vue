<?php


namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

#[OA\Tag(
    name: "Usuario",
    description: "Operaciones relacionadas con los usuarios"
)]
class UsuarioController extends Controller
{
    #[OA\Get(
        path: "/api/usuarios",
        summary: "Listar todos los usuarios",
        tags: ["Usuario"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de usuarios",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Usuario")
                )
            )
        ]
    )]
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    #[OA\Post(
        path: "/api/usuarios",
        summary: "Crear un nuevo usuario de cualquier tipo",
        tags: ["Usuario"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/UsuarioCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Usuario creado exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Usuario")
            )
        ]
    )]
    public function store(Request $request)
    {
        $data = $request->all();

        if (isset($data['contraseña'])) {
            $data['contraseña'] = bcrypt($data['contraseña']);
        }
        $data['fecha_registro'] = now();
        $usuario = Usuario::create($data);
        return response()->json($usuario, 201);
    }

    #[OA\Post(
        path: "/api/registrar-usuario",
        summary: "Registrar un nuevo usuario de tipo usuario",
        tags: ["Usuario"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["dni_usuario", "nombre", "email", "contraseña"],
                properties: [
                    new OA\Property(property: "dni_usuario", type: "string", example: "12345678A"),
                    new OA\Property(property: "nombre", type: "string", example: "Juan Pérez"),
                    new OA\Property(property: "email", type: "string", example: "juan@email.com"),
                    new OA\Property(property: "contraseña", type: "string", example: "secreto123")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Usuario registrado correctamente"
            ),
            new OA\Response(
                response: 422,
                description: "Datos inválidos"
            )
        ]
    )]
    public function registrarUsuario(Request $request)
    {
        try {
            $validated = $request->validate([
                'dni_usuario' => 'required|string|unique:usuario,dni_usuario',
                'nombre' => 'required|string|unique:usuario,nombre',
                'email' => 'required|email|unique:usuario,email',
                'contraseña' => 'required|string',
                'saldo' => 'nullable|numeric',
                'avatar' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            // Personaliza los mensajes de error para email y dni_usuario
            $errors = $e->errors();
            $customMessage = 'Datos inválidos.';
            if (isset($errors['dni_usuario'])) {
                $customMessage = 'El DNI ya está registrado.';
            } elseif (isset($errors['email'])) {
                $customMessage = 'El correo electrónico ya está registrado.';
            }
            return response()->json([
                'message' => $customMessage,
                'errors' => $errors
            ], 422);
        }

        $validated['contraseña'] = bcrypt($validated['contraseña']);

        $usuario = new Usuario($validated);
        $usuario->rol = 'usuario';
        $usuario->fecha_registro = now();
        $usuario->saldo = $request->input('saldo', 0);
        $usuario->avatar = $request->input('avatar', null);
        $usuario->save();

        return response()->json($usuario, 201);
    }

    #[OA\Get(
        path: "/api/usuarios/{id}",
        summary: "Obtener un usuario por ID",
        tags: ["Usuario"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del usuario",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Usuario encontrado",
                content: new OA\JsonContent(ref: "#/components/schemas/Usuario")
            ),
            new OA\Response(
                response: 404,
                description: "Usuario no encontrado"
            )
        ]
    )]
    public function show($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        return response()->json($usuario);
    }

    #[OA\Put(
        path: "/api/usuarios/{dni_usuario}",
        summary: "Actualizar un usuario por DNI",
        tags: ["Usuario"],
        parameters: [
            new OA\Parameter(
                name: "dni_usuario",
                in: "path",
                required: true,
                description: "DNI del usuario",
                schema: new OA\Schema(type: "string")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/UsuarioUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Usuario actualizado correctamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Usuario")
            ),
            new OA\Response(
                response: 404,
                description: "Usuario no encontrado"
            )
        ]
    )]
    public function update(Request $request, $dni_usuario)
    {
        $usuario = Usuario::where('dni_usuario', $dni_usuario)->first();
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string',
                'email' => 'sometimes|email|unique:usuario,email,' . $usuario->dni_usuario . ',dni_usuario',
                'contraseña' => 'sometimes|string',
                'saldo' => 'nullable|numeric',
                'avatar' => 'nullable|string',
                'rol' => 'sometimes|string',
            ]);
        } catch (ValidationException $e) {
            // Devuelve un mensaje claro para el frontend
            return response()->json([
                'message' => 'No se puede actualizar el usuario. El email ya está en uso.',
                'errors' => $e->errors()
            ], 422);
        }

        if (isset($validated['contraseña'])) {
            $validated['contraseña'] = bcrypt($validated['contraseña']);
        }

        $usuario->update($validated);

        return response()->json($usuario);
    }

    #[OA\Delete(
        path: "/api/usuarios/{dni_usuario}",
        summary: "Eliminar un usuario por DNI",
        tags: ["Usuario"],
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
                description: "Usuario eliminado correctamente",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Usuario eliminado correctamente")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Usuario no encontrado"
            )
        ]
    )]
    public function destroy($dni_usuario)
    {
        $usuario = Usuario::where('dni_usuario', $dni_usuario)->first();
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }



    #[OA\Post(
        path: "/api/login",
        summary: "Login de usuario",
        tags: ["Usuario"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "contraseña"],
                properties: [
                    new OA\Property(property: "email", type: "string", example: "usuario@email.com"),
                    new OA\Property(property: "contraseña", type: "string", example: "secreto123")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Login exitoso",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Login exitoso"),
                        new OA\Property(property: "usuario", ref: "#/components/schemas/Usuario")
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Credenciales incorrectas",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Credenciales incorrectas")
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Datos inválidos"
            )
        ]
    )]
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'contraseña' => 'required|string',
        ]);

        $usuario = Usuario::where('email', $validated['email'])->first();

        if (!$usuario || !Hash::check($validated['contraseña'], $usuario->contraseña)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        return response()->json([
            'message' => 'Login exitoso',
            'logeado' => true,
            'usuario' => $usuario
        ]);
    }
}
