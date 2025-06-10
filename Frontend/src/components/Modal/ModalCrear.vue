<template>
    <div v-if="visible" class="modal-backdrop" style="display: block">
        <div class="modal d-block" tabindex="-1" role="dialog" @click.self="cancel" style="overflow-y: auto">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear {{ entidadLabel }}</h5>
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

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Imagen Horizontal</label>
                                    <div v-if="previewHorizontal" class="mb-2">
                                        <img :src="previewHorizontal" alt="Horizontal" class="img-fluid rounded"
                                            style="max-height: 150px; object-fit: cover;" />
                                    </div>
                                    <input type="file" accept="image/*" class="form-control"
                                        @change="onFileChange($event, 'horizontal')" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Imagen Vertical</label>
                                    <div v-if="previewVertical" class="mb-2">
                                        <img :src="previewVertical" alt="Vertical" class="img-fluid rounded"
                                            style="max-height: 150px; object-fit: cover;" />
                                    </div>
                                    <input type="file" accept="image/*" class="form-control"
                                        @change="onFileChange($event, 'vertical')" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Imagen Personaje</label>
                                    <div v-if="previewPersonaje" class="mb-2">
                                        <img :src="previewPersonaje" alt="Personaje" class="img-fluid rounded"
                                            style="max-height: 150px; object-fit: cover;" />
                                    </div>
                                    <input type="file" accept="image/*" class="form-control"
                                        @change="onFileChange($event, 'personaje')" required />
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
                                        <option value="administrador">
                                            Administrador
                                        </option>
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
                                    <input v-model="formGenero.nombre" type="text" class="form-control"
                                        placeholder="Ej: Acción" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Imagen de Género</label>
                                    <div v-if="previewGenero" class="mb-2">
                                        <img :src="previewGenero" alt="Imagen género" class="img-fluid rounded"
                                            style="max-height: 200px; object-fit: cover;" />
                                    </div>
                                    <input type="file" accept="image/*" class="form-control"
                                        @change="onFileGeneroChange" required />
                                    <div v-if="fileGenero" class="mt-2 text-white">
                                        ⚙️ Archivo seleccionado: {{ fileGenero.name }}
                                    </div>
                                </div>
                            </div>

                            <!-- ⇨ NOTICIAS ⇨ -->
                            <div v-else-if="entidad === 'noticias'">
                                <div class="mb-3">
                                    <label class="form-label">Título</label>
                                    <input v-model="formNoticia.titulo" type="text" class="form-control" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Portada (archivo)</label>
                                    <div v-if="formNoticia.portada" class="mb-2">
                                        <img :src="formNoticia.portada" alt="Portada" class="img-fluid rounded"
                                            style="max-height: 150px; object-fit: cover;" />
                                    </div>
                                    <input type="file" accept="image/*" class="form-control"
                                        @change="onFilePortadaChange" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lightbox (archivo)</label>
                                    <div v-if="formNoticia.lightbox" class="mb-2">
                                        <img :src="formNoticia.lightbox" alt="Lightbox" class="img-fluid rounded"
                                            style="max-height: 150px; object-fit: cover;" />
                                    </div>
                                    <input type="file" accept="image/*" class="form-control"
                                        @change="onFileLightboxChange" required />
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
import { ref, reactive, computed, watch } from "vue";
import { useGamesStore } from "../../stores/useGamesStore.js";
import { useUsersStore } from "../../stores/useUserStore.js";
import { useGenerosStore } from "../../stores/useGenerosStore.js";
import { useNoticiasStore } from "../../stores/useNoticiasStore.js";
import { useJuegoImagenesStore } from "../../stores/useJuegoImagenesStore.js";

const props = defineProps({
    entidad: { type: String, required: true },
    visible: { type: Boolean, required: true },
});
const emit = defineEmits(["saved", "cancel"]);

const gamesStore = useGamesStore();
const usersStore = useUsersStore();
const genresStore = useGenerosStore();
const noticiasStore = useNoticiasStore();
const juegoImagenesStore = useJuegoImagenesStore();

const formJuego = reactive({
    nombre: "",
    desarrollador: "",
    editor: "",
    fecha_lanzamiento: "",
    precio: null,
    descuento: 0,
    genero: "",
    plataforma: "",
});

const formUsuario = reactive({
    nombre: "",
    email: "",
    dni_usuario: "",
    rol: "",
    saldo: null,
    contrasena: "",
});

const formGenero = reactive({
    nombre: "",
    imagen: "" // base64
});

const formNoticia = reactive({
    titulo: "",
    portada: "",
    lightbox: "",
    descripcion: "",
    cuerpo: "",
});

const fileGenero = ref(null);
const previewGenero = ref("");
const previewHorizontal = ref("");
const previewVertical = ref("");
const previewPersonaje = ref("");
const base64Horizontal = ref("");
const base64Vertical = ref("");
const base64Personaje = ref("");

// ──────────────────────────────────────────────────────────────
// 3) ESTADO ADICIONAL
// ──────────────────────────────────────────────────────────────
const isSubmitting = ref(false);
const entidadLabel = computed(() => {
    if (props.entidad === "juegos") return "Juego";
    if (props.entidad === "usuarios") return "Usuario";
    if (props.entidad === "generos") return "Género";
    if (props.entidad === "noticias") return "Noticia";
    return "";
});

// ──────────────────────────────────────────────────────────────
// 4) LIMPIAR CAMPOS CUANDO CAMBIE LA ENTIDAD
// ──────────────────────────────────────────────────────────────
watch(
    () => props.entidad,
    () => {
        Object.keys(formJuego).forEach(
            (k) => (formJuego[k] = typeof formJuego[k] === "string" ? "" : null)
        );
        Object.keys(formUsuario).forEach(
            (k) => (formUsuario[k] = typeof formUsuario[k] === "string" ? "" : null)
        );
        Object.keys(formGenero).forEach(
            (k) => (formGenero[k] = typeof formGenero[k] === "string" ? "" : null)
        );
        Object.keys(formNoticia).forEach(
            (k) => (formNoticia[k] = typeof formNoticia[k] === "string" ? "" : null)
        );
        fileGenero.value = null;
        previewGenero.value = "";
        previewHorizontal.value = "";
        previewVertical.value = "";
        previewPersonaje.value = "";
        base64Horizontal.value = "";
        base64Vertical.value = "";
        base64Personaje.value = "";
    }
);

// ──────────────────────────────────────────────────────────────
// 5) MANEJO DE CAMBIO DE ARCHIVO Y PREVIEW
// ──────────────────────────────────────────────────────────────
function fileToBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.onerror = (error) => reject(error);
        reader.readAsDataURL(file);
    });
}

async function onFileChange(event, categoria) {
    const file = event.target.files[0] || null;
    if (!file) {
        if (categoria === "horizontal") {
            previewHorizontal.value = "";
            base64Horizontal.value = "";
        } else if (categoria === "vertical") {
            previewVertical.value = "";
            base64Vertical.value = "";
        } else if (categoria === "personaje") {
            previewPersonaje.value = "";
            base64Personaje.value = "";
        }
        return;
    }
    const base64 = await fileToBase64(file);
    if (categoria === "horizontal") {
        previewHorizontal.value = base64;
        base64Horizontal.value = dataUrlToBase64(base64);
    } else if (categoria === "vertical") {
        previewVertical.value = base64;
        base64Vertical.value = dataUrlToBase64(base64);
    } else if (categoria === "personaje") {
        previewPersonaje.value = base64;
        base64Personaje.value = dataUrlToBase64(base64);
    }
}

async function onFileGeneroChange(event) {
    const file = event.target.files[0] || null;
    fileGenero.value = file;
    if (!file) {
        formGenero.imagen = "";
        previewGenero.value = "";
        return;
    }
    const base64 = await fileToBase64(file);
    formGenero.imagen = dataUrlToBase64(base64);
    previewGenero.value = base64;
}

async function onFilePortadaChange(event) {
    const file = event.target.files[0];
    if (!file) {
        formNoticia.portada = "";
        return;
    }
    const base64 = await fileToBase64(file);
    formNoticia.portada = base64;
}

async function onFileLightboxChange(event) {
    const file = event.target.files[0];
    if (!file) {
        formNoticia.lightbox = "";
        return;
    }
    const base64 = await fileToBase64(file);
    formNoticia.lightbox = base64;
}

function dataUrlToBase64(dataUrl) {
    if (!dataUrl) return "";
    const parts = dataUrl.split(",");
    return parts.length > 1 ? parts[1] : dataUrl;
}

// ──────────────────────────────────────────────────────────────
// 7) ENVIAR FORMULARIO PARA CUALQUIER ENTIDAD
// ──────────────────────────────────────────────────────────────
async function onSubmit() {
    isSubmitting.value = true;

    try {
        if (props.entidad === "juegos") {
            if (
                !formJuego.nombre ||
                !formJuego.desarrollador ||
                !formJuego.editor ||
                !formJuego.fecha_lanzamiento ||
                formJuego.precio === null ||
                !formJuego.genero ||
                !formJuego.plataforma
            ) {
                throw new Error("Completa todos los campos del juego.");
            }
            if (
                !base64Horizontal.value ||
                !base64Vertical.value ||
                !base64Personaje.value
            ) {
                throw new Error(
                    "Selecciona las 3 imágenes: horizontal, vertical y personaje."
                );
            }

            // Crear el juego (solo campos de texto)
            const payload = {
                ...formJuego,
                imagenes: [
                    { categoria: "horizontal", imagen: base64Horizontal.value },
                    { categoria: "vertical", imagen: base64Vertical.value },
                    { categoria: "personaje", imagen: base64Personaje.value }
                ]
            };
            const nuevoJuego = await gamesStore.crearGame(payload);
            if (!nuevoJuego || !nuevoJuego.id_juego) {
                throw new Error(gamesStore.error || "Error al crear el juego");
            }
        } else if (props.entidad === "usuarios") {
            if (
                !formUsuario.nombre ||
                !formUsuario.email ||
                !formUsuario.dni_usuario ||
                !formUsuario.rol ||
                formUsuario.saldo === null
            ) {
                throw new Error("Completa todos los campos del usuario.");
            }
            const nuevoUsuario = await usersStore.createUser({
                nombre: formUsuario.nombre,
                email: formUsuario.email,
                contraseña: formUsuario.contrasena,
                dni_usuario: formUsuario.dni_usuario,
                rol: formUsuario.rol,
                saldo: formUsuario.saldo,
            });
            if (!nuevoUsuario) {
                throw new Error(usersStore.error || "Error al crear usuario");
            }
        } else if (props.entidad === "generos") {
            if (!formGenero.nombre) {
                throw new Error("Completa el nombre del género.");
            }
            if (!formGenero.imagen) {
                throw new Error("Debes seleccionar una imagen para el género.");
            }
            const payload = {
                nombre: formGenero.nombre.trim(),
                imagen: formGenero.imagen,
            };

            const creado = await genresStore.createGenre(payload);
            if (!creado) {
                throw new Error(
                    genresStore.error || "Error al crear el género."
                );
            }
        } else if (props.entidad === "noticias") {
            if (
                !formNoticia.titulo ||
                !formNoticia.descripcion ||
                !formNoticia.cuerpo
            ) {
                throw new Error("Completa todos los campos de la noticia.");
            }
            if (!formNoticia.portada) {
                throw new Error("Selecciona un archivo para la portada.");
            }
            if (!formNoticia.lightbox) {
                throw new Error("Selecciona un archivo para el lightbox.");
            }
            const payload = {
                titulo: formNoticia.titulo,
                portada: dataUrlToBase64(formNoticia.portada),
                lightbox: dataUrlToBase64(formNoticia.lightbox),
                descripcion: formNoticia.descripcion,
                cuerpo: formNoticia.cuerpo,
            };
            const nueva = await noticiasStore.crearNoticiaConArchivoJSON(
                payload
            );
            if (!nueva) {
                throw new Error(
                    noticiasStore.error || "Error al crear noticia"
                );
            }
        }

        emit("saved");
    } catch (err) {
        console.error("Error en onSubmit:", err);
        alert(err.message || "Hubo un error al guardar.");
    } finally {
        isSubmitting.value = false;
    }
}

// ──────────────────────────────────────────────────────────────
// 8) Cancelar: limpiar formularios y emitir evento
// ──────────────────────────────────────────────────────────────
function cancel() {
    Object.keys(formJuego).forEach(
        (k) => (formJuego[k] = typeof formJuego[k] === "string" ? "" : null)
    );
    Object.keys(formUsuario).forEach(
        (k) => (formUsuario[k] = typeof formUsuario[k] === "string" ? "" : null)
    );
    Object.keys(formGenero).forEach(
        (k) => (formGenero[k] = typeof formGenero[k] === "string" ? "" : null)
    );
    Object.keys(formNoticia).forEach(
        (k) => (formNoticia[k] = typeof formNoticia[k] === "string" ? "" : null)
    );
    fileGenero.value = null;
    previewGenero.value = "";
    previewHorizontal.value = "";
    previewVertical.value = "";
    previewPersonaje.value = "";
    base64Horizontal.value = "";
    base64Vertical.value = "";
    base64Personaje.value = "";

    emit("cancel");
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
