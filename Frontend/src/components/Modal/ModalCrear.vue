<!-- src/components/Modal/ModalCrear.vue -->

<template>
    <div v-if="visible" class="modal-backdrop" style="display: block;">
        <div class="modal d-block" tabindex="-1" role="dialog" @click.self="cancel" style="overflow-y: auto;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Crear {{ entidadLabel }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" aria-label="Close"
                            @click="cancel"></button>
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

                                <!-- ————————— INICIO: tres inputs para las imágenes ————————— -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Imagen Horizontal</label>
                                    <input ref="inputHorizontal" type="file" accept="image/*" class="form-control"
                                        @change="onFileChange($event, 'horizontal')" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Imagen Vertical</label>
                                    <input ref="inputVertical" type="file" accept="image/*" class="form-control"
                                        @change="onFileChange($event, 'vertical')" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Imagen Personaje</label>
                                    <input ref="inputPersonaje" type="file" accept="image/*" class="form-control"
                                        @change="onFileChange($event, 'personaje')" required />
                                </div>
                                <!-- ————————— FIN: tres inputs para las imágenes ————————— -->
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
                                    <label class="form-label">Contraseña</label>
                                    <input v-model="formUsuario.contrasena" type="password" class="form-control"
                                        placeholder="Escribe una contraseña" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">DNI</label>
                                    <input v-model="formUsuario.dni_usuario" type="text" class="form-control"
                                        required />
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

                            <!-- Pie de modal con botones -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cancel">
                                    Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
                                    <span v-if="isSubmitting" class="spinner-border spinner-border-sm text-light"
                                        role="status"></span>
                                    <span v-else>Guardar</span>
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
import { useGenerosStore } from '../../stores/useGenerosStore.js'
import { useNoticiasStore } from '../../stores/useNoticiasStore.js'
import { useJuegoImagenesStore } from '../../stores/useJuegoImagenesStore.js'

const props = defineProps({
    entidad: { type: String, required: true },
    visible: { type: Boolean, required: true }
})
const emit = defineEmits(['saved', 'cancel'])

// Stores para crear cada entidad
const gamesStore    = useGamesStore()
const usersStore    = useUsersStore()
const genresStore   = useGenerosStore()
const noticiasStore = useNoticiasStore()
const juegoImagenesStore = useJuegoImagenesStore()

// ──────────────────────────────────────────────────────────────────────────────
// 2) FORMULARIO PARA CADA ENTIDAD
// ──────────────────────────────────────────────────────────────────────────────

// 2.1) Estado del formulario de “Juegos”
const formJuego = reactive({
    nombre: '',
    desarrollador: '',
    editor: '',
    fecha_lanzamiento: '',
    precio: null,
    descuento: 0,
    genero: '',        // ingresado manualmente
    plataforma: ''
})

// 2.2) Estado del formulario de “Usuarios”
const formUsuario = reactive({
    nombre: '',
    email: '',
    dni_usuario: '',
    rol: '',
    saldo: null,
    contrasena: ''     // campo para la contraseña
})

// 2.3) Estado del formulario de “Géneros”
const formGenero = reactive({
    nombre: ''
})

// 2.4) Estado del formulario de “Noticias”
const formNoticia = reactive({
    titulo: '',
    imagen: '',
    descripcion: '',
    cuerpo: ''
})

// 2.5) Archivos para imágenes de “Juegos”
const archivosImagen = reactive({
    horizontal: null,
    vertical: null,
    personaje: null
})

// ──────────────────────────────────────────────────────────────────────────────
// 3) ESTADO ADICIONAL
// ──────────────────────────────────────────────────────────────────────────────
const isSubmitting = ref(false)
const entidadLabel = computed(() => {
    if (props.entidad === 'juegos') return 'Juego'
    if (props.entidad === 'usuarios') return 'Usuario'
    if (props.entidad === 'generos') return 'Género'
    if (props.entidad === 'noticias') return 'Noticia'
    return ''
})

// ──────────────────────────────────────────────────────────────────────────────
// 4) LIMPIAR CAMPOS CUANDO CAMBIE LA ENTIDAD
// ──────────────────────────────────────────────────────────────────────────────
watch(
    () => props.entidad,
    () => {
        Object.keys(formJuego).forEach((k) => formJuego[k] = typeof formJuego[k] === 'string' ? '' : null)
        Object.keys(formUsuario).forEach((k) => formUsuario[k] = typeof formUsuario[k] === 'string' ? '' : null)
        Object.keys(formGenero).forEach((k) => formGenero[k] = typeof formGenero[k] === 'string' ? '' : null)
        Object.keys(formNoticia).forEach((k) => formNoticia[k] = typeof formNoticia[k] === 'string' ? '' : null)
        archivosImagen.horizontal = archivosImagen.vertical = archivosImagen.personaje = null
    }
)

// ──────────────────────────────────────────────────────────────────────────────
// 5) MANEJO DE CAMBIO DE ARCHIVO (solo para “Juegos”)
// ──────────────────────────────────────────────────────────────────────────────
function onFileChange(event, categoria) {
    archivosImagen[categoria] = event.target.files[0] || null
}

// ──────────────────────────────────────────────────────────────────────────────
// 6) UTILITY: convertir un File a Base64 (promesa)
// ──────────────────────────────────────────────────────────────────────────────
function fileToBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader()
        reader.onload = () => resolve(reader.result)   // reader.result es un data:url (base64)
        reader.onerror = (error) => reject(error)
        reader.readAsDataURL(file)
    })
}

// ──────────────────────────────────────────────────────────────────────────────
// 7) ENVIAR FORMULARIO PARA CUALQUIER ENTIDAD
// ──────────────────────────────────────────────────────────────────────────────
async function onSubmit() {
    isSubmitting.value = true

    try {
        if (props.entidad === 'juegos') {
            // 7.1) Validar campos de “Juegos”
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
            if (
                !archivosImagen.horizontal ||
                !archivosImagen.vertical ||
                !archivosImagen.personaje
            ) {
                throw new Error('Selecciona las 3 imágenes: horizontal, vertical y personaje.')
            }

            // 7.2) Crear el juego (solo campos de texto)
            const nuevoJuego = await gamesStore.crearGame({ ...formJuego })
            if (!nuevoJuego || !nuevoJuego.id_juego) {
                throw new Error(gamesStore.error || 'Error al crear el juego')
            }
            const idNuevoJuego = nuevoJuego.id_juego

            // 7.3) Convertir cada archivo a Base64 y enviarlo como JSON
            async function subirImagenBase64(file, descripcion) {
                // 1) Convertir File a Base64
                const base64 = await fileToBase64(file)
                // 2) Construir payload JSON
                const payload = {
                    id_juego: idNuevoJuego,
                    categoria: descripcion,
                    imagen: base64   // enviamos la cadena completa de Base64
                }
                // 3) Llamar al store para enviar JSON
                const resultado = await juegoImagenesStore.subirImagen(payload)
                if (!resultado) {
                    console.error('Falló subida de imagen:', juegoImagenesStore.error)
                    throw new Error(juegoImagenesStore.error || 'Error en subirImagen')
                }
                return resultado
            }

            // Subir las tres imágenes
            await subirImagenBase64(archivosImagen.horizontal, 'horizontal')
            await subirImagenBase64(archivosImagen.vertical, 'vertical')
            await subirImagenBase64(archivosImagen.personaje, 'personaje')

        } else if (props.entidad === 'usuarios') {
            // 7.4) Validar y crear “Usuario”
            if (
                !formUsuario.nombre ||
                !formUsuario.email ||
                !formUsuario.dni_usuario ||
                !formUsuario.rol ||
                formUsuario.saldo === null
            ) {
                throw new Error('Completa todos los campos del usuario.')
            }
            const nuevoUsuario = await usersStore.createUser({
                nombre: formUsuario.nombre,
                email: formUsuario.email,
                contraseña: formUsuario.contrasena,    // ← enviamos la clave con tilde
                dni_usuario: formUsuario.dni_usuario,
                rol: formUsuario.rol,
                saldo: formUsuario.saldo
            })
            if (!nuevoUsuario) {
                throw new Error(usersStore.error || 'Error al crear usuario')
            }

        } else if (props.entidad === 'generos') {
            // 7.5) Validar y crear “Género”
            if (!formGenero.nombre) {
                throw new Error('Completa el nombre del género.')
            }
            const nuevoGenero = await genresStore.createGenre({ nombre: formGenero.nombre })
            if (!nuevoGenero) {
                throw new Error(genresStore.error || 'Error al crear género')
            }

        } else if (props.entidad === 'noticias') {
            // 7.6) Validar y crear “Noticia”
            if (
                !formNoticia.titulo ||
                !formNoticia.descripcion ||
                !formNoticia.cuerpo
            ) {
                throw new Error('Completa todos los campos de la noticia.')
            }
            const nuevaNoticia = await noticiasStore.crearNoticia({
                titulo: formNoticia.titulo,
                imagen: formNoticia.imagen,   // aquí podrías enviar también un Base64 si quieres
                descripcion: formNoticia.descripcion,
                cuerpo: formNoticia.cuerpo
            })
            if (!nuevaNoticia) {
                throw new Error(noticiasStore.error || 'Error al crear noticia')
            }
        }

        // 7.7) Emitir “saved” para que el padre recargue la lista
        emit('saved')

    } catch (err) {
        console.error('Error en onSubmit:', err)
        alert(err.message || 'Hubo un error al guardar.')
    } finally {
        isSubmitting.value = false
    }
}

// ──────────────────────────────────────────────────────────────────────────────
// 8) Cancelar: limpiar formularios y emitir evento
// ──────────────────────────────────────────────────────────────────────────────
function cancel() {
    Object.keys(formJuego).forEach((k) => formJuego[k] = typeof formJuego[k] === 'string' ? '' : null)
    Object.keys(formUsuario).forEach((k) => formUsuario[k] = typeof formUsuario[k] === 'string' ? '' : null)
    Object.keys(formGenero).forEach((k) => formGenero[k] = typeof formGenero[k] === 'string' ? '' : null)
    Object.keys(formNoticia).forEach((k) => formNoticia[k] = typeof formNoticia[k] === 'string' ? '' : null)
    archivosImagen.horizontal = archivosImagen.vertical = archivosImagen.personaje = null

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
    background-color: rgba(0, 0, 0, 0.6);
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
