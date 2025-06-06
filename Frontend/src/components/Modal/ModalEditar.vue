<template>
    <div v-if="visible" class="modal-backdrop" style="display: block; background-color: rgba(0, 0, 0, 0.6);">
        <div class="modal d-block" tabindex="-1" role="dialog" @click.self="onCancel" style="overflow-y: auto;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Modificar {{ entidadLabel }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" aria-label="Close"
                            @click="onCancel"></button>
                    </div>

                    <div class="modal-body">
                        <form @submit.prevent="onSubmit">
                            <!-- ⇨ JUEGOS ⇨ -->
                            <div v-if="entidad === 'juegos'">
                                <div class="mb-3">
                                    <label class="form-label">Nombre del juego</label>
                                    <input v-model="formJuego.nombre" type="text" class="form-control"
                                        placeholder="Ej: Super Juego" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Desarrollador</label>
                                    <input v-model="formJuego.desarrollador" type="text" class="form-control"
                                        placeholder="Ej: MiStudio" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Editor</label>
                                    <input v-model="formJuego.editor" type="text" class="form-control"
                                        placeholder="Ej: Grandes Juegos SA" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Fecha de lanzamiento</label>
                                    <input v-model="formJuego.fecha_lanzamiento" type="date" class="form-control"
                                        required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Precio</label>
                                    <input v-model.number="formJuego.precio" type="number" min="0" class="form-control"
                                        placeholder="Ej: 59.99" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Descuento (%)</label>
                                    <input v-model.number="formJuego.descuento" type="number" min="0" max="100"
                                        class="form-control" placeholder="Ej: 20" />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Género</label>
                                    <input v-model="formJuego.genero" type="text" class="form-control"
                                        placeholder="Ej: Acción, Aventura..." required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Plataforma</label>
                                    <input v-model="formJuego.plataforma" type="text" class="form-control"
                                        placeholder="Ej: PC / PS5 / Xbox" required />
                                </div>
                            </div>

                            <!-- ⇨ USUARIOS ⇨ -->
                            <div v-else-if="entidad === 'usuarios'">
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input v-model="formUsuario.nombre" type="text" class="form-control" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input v-model="formUsuario.email" type="email" class="form-control" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">DNI</label>
                                    <!-- Hacemos el campo readonly en lugar de editable -->
                                    <input v-model="formUsuario.dni_usuario" type="text" class="form-control"
                                        readonly />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rol</label>
                                    <select v-model="formUsuario.rol" class="form-select" required>
                                        <option value="usuario">Usuario</option>
                                        <option value="administrador">Administrador</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Saldo</label>
                                    <input v-model.number="formUsuario.saldo" type="number" min="0" class="form-control"
                                        required />
                                </div>
                            </div>

                            <!-- ⇨ GÉNEROS ⇨ -->
                            <div v-else-if="entidad === 'generos'">
                                <div class="mb-3">
                                    <label class="form-label">Nombre Género</label>
                                    <input v-model="formGenero.nombre" type="text" class="form-control" required />
                                </div>
                            </div>

                            <!-- ⇨ NOTICIAS ⇨ -->
                            <div v-else-if="entidad === 'noticias'">
                                <div class="mb-3">
                                    <label class="form-label">Título</label>
                                    <input v-model="formNoticia.titulo" type="text" class="form-control" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Imagen (URL o base64)</label>
                                    <input v-model="formNoticia.imagen" type="text" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Descripción (corta)</label>
                                    <textarea v-model="formNoticia.descripcion" class="form-control" rows="2"
                                        required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cuerpo (texto completo)</label>
                                    <textarea v-model="formNoticia.cuerpo" class="form-control" rows="4"
                                        required></textarea>
                                </div>
                            </div>

                            <!-- ⇨ IMÁGENES DE JUEGO ⇨ -->
                            <div v-else-if="entidad === 'juegoImagenes'">
                                <!-- Mostrar ID → sólo lectura -->
                                <div class="mb-3">
                                    <label class="form-label">ID Imagen</label>
                                    <input type="text" class="form-control" :value="formImagen.id_imagen" disabled />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ID Juego</label>
                                    <input v-model.number="formImagen.id_juego" type="number" class="form-control"
                                        required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Categoría</label>
                                    <select v-model="formImagen.categoria" class="form-select" required>
                                        <option value="horizontal">Horizontal</option>
                                        <option value="vertical">Vertical</option>
                                        <option value="personaje">Personaje</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Imagen (Base64)</label>
                                    <textarea v-model="formImagen.imagen" class="form-control" rows="3"
                                        placeholder="Cadena data:image/...;base64,…" required></textarea>
                                </div>
                            </div>

                            <!-- Bloque dinámico para cualquier entidad -->
                            <div v-else>
                                <div v-for="(valor, clave) in props.itemActual" :key="clave" class="mb-3">
                                    <label class="form-label">{{ clave }}</label>
                                    <input v-model="props.itemActual[clave]"
                                        :type="typeof valor === 'number' ? 'number' : 'text'" class="form-control"
                                        :readonly="clave === 'id' || clave === 'id_juego' || clave === 'dni_usuario'" />
                                </div>
                            </div>

                            <!-- Pie de modal con botones -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="onCancel">
                                    Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
                                    <span v-if="isSubmitting" class="spinner-border spinner-border-sm text-light"
                                        role="status"></span>
                                    <span v-else>Guardar cambios</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed, watch } from 'vue'
import { useGamesStore } from '../../stores/useGamesStore.js'
import { useUsersStore } from '../../stores/useUserStore.js'
import { useGenresStore } from '../../stores/useGenerosStore.js'
import { useNoticiasStore } from '../../stores/useNoticiasStore.js'
import { useJuegoImagenesStore } from '../../stores/useJuegoImagenesStore.js'

const props = defineProps({
    entidad: { type: String, required: true },
    visible: { type: Boolean, required: true },
    itemActual: { type: Object, required: true }  // Objeto a editar (juego, usuario, etc)
})
const emit = defineEmits(['saved', 'cancel'])

// ────────────────────────────────────────────────────────────
// 1) Instanciar cada store
// ────────────────────────────────────────────────────────────
const gamesStore = useGamesStore()
const usersStore = useUsersStore()
const genresStore = useGenresStore()
const noticiasStore = useNoticiasStore()
const juegoImagenesStore = useJuegoImagenesStore()

// ────────────────────────────────────────────────────────────
// 2) Formularios iniciales (reactive) para cada entidad
// ────────────────────────────────────────────────────────────
const formJuego = reactive({
    nombre: '',
    desarrollador: '',
    editor: '',
    fecha_lanzamiento: '',
    precio: null,
    descuento: 0,
    genero: '',
    plataforma: ''
})

const formUsuario = reactive({
    nombre: '',
    email: '',
    dni_usuario: '',
    rol: '',
    saldo: null
})

const formGenero = reactive({
    nombre: ''
})

const formNoticia = reactive({
    titulo: '',
    imagen: '',
    descripcion: '',
    cuerpo: ''
})

const formImagen = reactive({
    id_imagen: null,
    id_juego: null,
    categoria: '',
    imagen: ''  // aquí va la cadena Base64
})

// ────────────────────────────────────────────────────────────
// 3) Estado adicional
// ────────────────────────────────────────────────────────────
const isSubmitting = ref(false)

const entidadLabel = computed(() => {
    switch (props.entidad) {
        case 'juegos': return 'Juego'
        case 'usuarios': return 'Usuario'
        case 'generos': return 'Género'
        case 'noticias': return 'Noticia'
        case 'juegoImagenes': return 'Imagen de Juego'
        default: return ''
    }
})

// ────────────────────────────────────────────────────────────
// 4) Cuando cambie `itemActual` o el modal se abra, poblar el formulario
// ────────────────────────────────────────────────────────────
watch(
    () => [props.itemActual, props.visible],
    ([nuevoItem, estaVisible]) => {
        if (!estaVisible || !nuevoItem) return

        // Copiamos los valores en el formulario correspondiente
        if (props.entidad === 'juegos') {
            Object.assign(formJuego, {
                nombre: nuevoItem.nombre || '',
                desarrollador: nuevoItem.desarrollador || '',
                editor: nuevoItem.editor || '',
                fecha_lanzamiento: nuevoItem.fecha_lanzamiento?.split('T')[0] || '',
                precio: nuevoItem.precio || null,
                descuento: nuevoItem.descuento || 0,
                genero: nuevoItem.genero || '',
                plataforma: nuevoItem.plataforma || ''
            })
        }
        else if (props.entidad === 'usuarios') {
            Object.assign(formUsuario, {
                nombre: nuevoItem.nombre || '',
                email: nuevoItem.email || '',
                dni_usuario: nuevoItem.dni_usuario || '',
                rol: nuevoItem.rol || '',
                saldo: nuevoItem.saldo || 0
            })
        }
        else if (props.entidad === 'generos') {
            formGenero.nombre = nuevoItem.nombre || ''
        }
        else if (props.entidad === 'noticias') {
            Object.assign(formNoticia, {
                titulo: nuevoItem.titulo || '',
                imagen: nuevoItem.imagen || '',
                descripcion: nuevoItem.descripcion || '',
                cuerpo: nuevoItem.cuerpo || ''
            })
        }
        else if (props.entidad === 'juegoImagenes') {
            Object.assign(formImagen, {
                id_imagen: nuevoItem.id_imagen,
                id_juego: nuevoItem.id_juego,
                categoria: nuevoItem.categoria,
                // Ya que `nuevoItem.imagen` viene como Base64 (por el mutator del modelo),
                // lo ponemos directamente en el textarea.
                imagen: `data:${nuevoItem.mime_type || 'image/jpeg'};base64,${nuevoItem.imagen}`
            })
        }
    }
)

// ────────────────────────────────────────────────────────────
// 5) Enviar formulario
// ────────────────────────────────────────────────────────────
async function onSubmit() {
    isSubmitting.value = true

    try {
        if (props.entidad === 'juegos') {
            // 5.1) Validar campos
            if (
                !formJuego.nombre ||
                !formJuego.desarrollador ||
                !formJuego.editor ||
                !formJuego.fecha_lanzamiento ||
                formJuego.precio === null ||
                !formJuego.genero ||
                !formJuego.plataforma
            ) {
                throw new Error('Completa todos los campos del juego.')
            }

            // 5.2) Llamar al store para actualizar
            const actualizado = await gamesStore.actualizarGame(
                props.itemActual.id_juego,
                {
                    nombre: formJuego.nombre,
                    desarrollador: formJuego.desarrollador,
                    editor: formJuego.editor,
                    fecha_lanzamiento: formJuego.fecha_lanzamiento,
                    precio: formJuego.precio,
                    descuento: formJuego.descuento,
                    genero: formJuego.genero,
                    plataforma: formJuego.plataforma
                }
            )
            if (!actualizado) {
                throw new Error(gamesStore.error || 'Error al actualizar el juego.')
            }
        }
        else if (props.entidad === 'usuarios') {
            if (
                !formUsuario.nombre ||
                !formUsuario.email ||
                !formUsuario.dni_usuario ||
                !formUsuario.rol ||
                formUsuario.saldo === null
            ) {
                throw new Error('Completa todos los campos del usuario.')
            }
            const actualizado = await usersStore.createUser
                ? await usersStore.updateUserByDni(props.itemActual.dni_usuario, {
                    nombre: formUsuario.nombre,
                    email: formUsuario.email,
                    dni_usuario: formUsuario.dni_usuario,
                    rol: formUsuario.rol,
                    saldo: formUsuario.saldo
                })
                : null
            if (!actualizado) {
                throw new Error(usersStore.error || 'Error al actualizar el usuario.')
            }
        }
        else if (props.entidad === 'generos') {
            if (!formGenero.nombre) {
                throw new Error('Completa el nombre del género.')
            }
            const actualizado = await genresStore.updateGenre(
                props.itemActual.id_genero,
                { nombre: formGenero.nombre }
            )
            if (!actualizado) {
                throw new Error(genresStore.error || 'Error al actualizar el género.')
            }
        }
        else if (props.entidad === 'noticias') {
            if (
                !formNoticia.titulo ||
                !formNoticia.descripcion ||
                !formNoticia.cuerpo
            ) {
                throw new Error('Completa todos los campos de la noticia.')
            }
            const actualizado = await noticiasStore.actualizarNoticia(
                props.itemActual.id_noticia,
                {
                    titulo: formNoticia.titulo,
                    imagen: formNoticia.imagen,
                    descripcion: formNoticia.descripcion,
                    cuerpo: formNoticia.cuerpo
                }
            )
            if (!actualizado) {
                throw new Error(noticiasStore.error || 'Error al actualizar la noticia.')
            }
        }
        else if (props.entidad === 'juegoImagenes') {
            // 5.3) Validar
            if (
                !formImagen.id_juego ||
                !formImagen.categoria ||
                !formImagen.imagen
            ) {
                throw new Error('Completa todos los campos de la imagen de juego.')
            }

            // Extraer sólo la cadena Base64 (sin el prefijo “data:image/...;base64,”)
            const blob64 = formImagen.imagen
            const payload = {
                id_juego: formImagen.id_juego,
                categoria: formImagen.categoria,
                // Como el backend espera “imagen” en Base64, mandamos directamente:
                imagen: blob64
            }

            const actualizado = await juegoImagenesStore.actualizarImagen(
                formImagen.id_imagen,
                payload
            )
            if (!actualizado) {
                throw new Error(juegoImagenesStore.error || 'Error al actualizar la imagen.')
            }
        }

        // 5.4) Emitir que ya se guardó
        emit('saved')
    }
    catch (err) {
        alert(err.message || 'Hubo un error al actualizar.')
    }
    finally {
        isSubmitting.value = false
    }
}

function onCancel() {
    emit('cancel')
}
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.modal .modal-dialog {
    margin-top: 3rem;
}

.modal-content {
    background-color: #1c1c1c;
    border: none;
}

.form-label {
    color: #ffffff;
}

.form-control,
.form-select {
    background-color: #2c2c2c;
    color: #ffffff;
    border: 1px solid #444;
}

.form-control:focus,
.form-select:focus {
    box-shadow: none;
    border-color: #42d54d;
}

.btn-primary {
    background-color: #42d54d;
    border-color: #42d54d;
}

.btn-secondary {
    background-color: #444;
    border-color: #666;
}

.btn-close-white {
    filter: invert(1);
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.modal-footer .btn {
    min-width: 80px;
}
</style>
