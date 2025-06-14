<template>
    <form @submit.prevent="onSubmit">
        <div class="mb-3">
            <label class="form-label">Nombre del juego*</label>
            <input
                v-model="formJuego.nombre"
                type="text"
                class="form-control"
                placeholder="Ej: Super Juego"
                required
                @blur="validateNombreOnBlur"
            />
            <div
                v-if="juegoErrors.nombre"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.nombre }}
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Desarrollador*</label>
            <input
                v-model="formJuego.desarrollador"
                type="text"
                class="form-control"
                placeholder="Ej: MiStudio"
                required
                @blur="validateDesarrolladorOnBlur"
            />
            <div
                v-if="juegoErrors.desarrollador"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.desarrollador }}
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Editor*</label>
            <input
                v-model="formJuego.editor"
                type="text"
                class="form-control"
                placeholder="Ej: Grandes Juegos SA"
                required
                @blur="validateEditorOnBlur"
            />
            <div
                v-if="juegoErrors.editor"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.editor }}
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de lanzamiento*</label>
            <input
                v-model="formJuego.fecha_lanzamiento"
                type="date"
                class="form-control"
                required
                @blur="validateFechaOnBlur"
            />
            <div
                v-if="juegoErrors.fecha_lanzamiento"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.fecha_lanzamiento }}
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio*</label>
            <input
                v-model.number="formJuego.precio"
                type="number"
                min="0"
                class="form-control"
                placeholder="Ej: 59.99"
                required
                @blur="validatePrecioOnBlur"
            />
            <div
                v-if="juegoErrors.precio"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.precio }}
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Descuento</label>
            <input
                v-model.number="formJuego.descuento"
                type="number"
                min="0"
                max="100"
                class="form-control"
                placeholder="Ej: 20"
                @blur="validateDescuentoOnBlur"
            />
            <div
                v-if="juegoErrors.descuento"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.descuento }}
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Géneros*</label>
            <select
                v-model="selectedGenero"
                class="form-select"
                @change="onGeneroChange"
            >
                <option disabled value="">Selecciona un género...</option>
                <option
                    v-for="g in generosStore.genres"
                    :key="g.id_genero"
                    :value="g.id_genero"
                    :disabled="formJuego.generos.includes(g.id_genero)"
                >
                    {{ g.nombre }}
                </option>
            </select>
            <div class="form-text">
                Selecciona un género para añadirlo. Haz clic en un badge para
                quitarlo.
            </div>
            <div v-if="formJuego.generos.length" class="mt-2">
                <span
                    class="badge bg-success me-1"
                    v-for="id in formJuego.generos"
                    :key="id"
                    style="cursor: pointer"
                    @click="removeGenero(id)"
                    title="Quitar"
                >
                    {{
                        generosStore.genres.find((g) => g.id_genero === id)
                            ?.nombre || id
                    }}
                    &times;
                </span>
            </div>
            <div
                v-if="juegoErrors.generos"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.generos }}
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Plataforma*</label>
            <input
                v-model="formJuego.plataforma"
                type="text"
                class="form-control"
                placeholder="Ej: PC / PS5 / Xbox"
                required
                @blur="validatePlataformaOnBlur"
            />
            <div
                v-if="juegoErrors.plataforma"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.plataforma }}
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Imagen Horizontal*</label>
            <div v-if="previewHorizontal" class="mb-2">
                <img
                    :src="previewHorizontal"
                    alt="Horizontal"
                    class="img-fluid rounded"
                    style="max-height: 150px; object-fit: cover"
                />
            </div>
            <input
                type="file"
                accept="image/*"
                class="form-control"
                @change="onFileChange($event, 'horizontal')"
                required
            />
            <div
                v-if="juegoErrors.horizontal"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.horizontal }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Imagen Vertical*</label>
            <div v-if="previewVertical" class="mb-2">
                <img
                    :src="previewVertical"
                    alt="Vertical"
                    class="img-fluid rounded"
                    style="max-height: 150px; object-fit: cover"
                />
            </div>
            <input
                type="file"
                accept="image/*"
                class="form-control"
                @change="onFileChange($event, 'vertical')"
                required
            />
            <div
                v-if="juegoErrors.vertical"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.vertical }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Imagen Personaje*</label>
            <div v-if="previewPersonaje" class="mb-2">
                <img
                    :src="previewPersonaje"
                    alt="Personaje"
                    class="img-fluid rounded"
                    style="max-height: 150px; object-fit: cover"
                />
            </div>
            <input
                type="file"
                accept="image/*"
                class="form-control"
                @change="onFileChange($event, 'personaje')"
                required
            />
            <div
                v-if="juegoErrors.personaje"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ juegoErrors.personaje }}
            </div>
        </div>

        <div class="modal-footer">
            <button
                type="button"
                class="btn btn-secondary"
                @click="$emit('cancel')"
            >
                Cancelar
            </button>
            <button
                type="submit"
                class="btn btn-primary"
                :disabled="isSubmitting"
            >
                <span
                    v-if="isSubmitting"
                    class="spinner-border spinner-border-sm text-light"
                    role="status"
                ></span>
                <span v-else>Guardar</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref,onMounted, reactive } from "vue";
import { useGamesStore } from "../../stores/useGamesStore.js";
import { useGenerosStore } from "../../stores/useGenerosStore.js";

const emit = defineEmits(["saved", "cancel"]);
const gamesStore = useGamesStore();
const generosStore = useGenerosStore();

const formJuego = reactive({
    nombre: "",
    desarrollador: "",
    editor: "",
    fecha_lanzamiento: "",
    precio: null,
    descuento: 0,
    generos: [],
    plataforma: "",
});

const previewHorizontal = ref("");
const previewVertical = ref("");
const previewPersonaje = ref("");
const base64Horizontal = ref("");
const base64Vertical = ref("");
const base64Personaje = ref("");
const isSubmitting = ref(false);
const selectedGenero = ref("");


const juegoErrors = reactive({
    nombre: null,
    desarrollador: null,
    editor: null,
    fecha_lanzamiento: null,
    precio: null,
    descuento: null,
    generos: null,
    plataforma: null,
    horizontal: null,
    vertical: null,
    personaje: null,
});

function validateNombreOnBlur() {
    juegoErrors.nombre = !formJuego.nombre.trim()
        ? "El nombre es obligatorio."
        : null;
}
function validateDesarrolladorOnBlur() {
    juegoErrors.desarrollador = !formJuego.desarrollador.trim()
        ? "El desarrollador es obligatorio."
        : null;
}
function validateEditorOnBlur() {
    juegoErrors.editor = !formJuego.editor.trim()
        ? "El editor es obligatorio."
        : null;
}
function validateFechaOnBlur() {
    juegoErrors.fecha_lanzamiento = !formJuego.fecha_lanzamiento
        ? "La fecha es obligatoria."
        : null;
}
function validatePrecioOnBlur() {
    juegoErrors.precio =
        formJuego.precio === null || formJuego.precio === ""
            ? "El precio es obligatorio."
            : null;
}
function validateDescuentoOnBlur() {
    if (formJuego.descuento > formJuego.precio) {
        juegoErrors.descuento =
            "El descuento no puede ser mayor que el precio.";
    } else if (formJuego.descuento < 0 || formJuego.descuento > 100) {
        juegoErrors.descuento = "El descuento debe estar entre 0 y 100.";
    } else {
        juegoErrors.descuento = null;
    }
}

function validateGeneroOnBlur() {
    juegoErrors.generos = !formJuego.generos.length
        ? "Debes seleccionar al menos un género."
        : null;
}

function onGeneroChange() {
    if (
        selectedGenero.value &&
        !formJuego.generos.includes(selectedGenero.value)
    ) {
        formJuego.generos.push(selectedGenero.value);
    }
    selectedGenero.value = "";
}

function removeGenero(id) {
    formJuego.generos = formJuego.generos.filter((gid) => gid !== id);
}

function validatePlataformaOnBlur() {
    juegoErrors.plataforma = !formJuego.plataforma.trim()
        ? "La plataforma es obligatoria."
        : null;
}

function isValidImageFile(file) {
    if (!file) return false;
    if (file.type && file.type.startsWith("image/")) return true;
    const validExtensions = [".jpg", ".jpeg", ".png", ".gif", ".bmp", ".webp"];
    const name = file.name ? file.name.toLowerCase() : "";
    return validExtensions.some((ext) => name.endsWith(ext));
}

async function onFileChange(event, categoria) {
    const file = event.target.files[0] || null;
    if (!file) {
        if (categoria === "horizontal") {
            previewHorizontal.value = "";
            base64Horizontal.value = "";
            juegoErrors.horizontal = "Selecciona una imagen horizontal.";
        } else if (categoria === "vertical") {
            previewVertical.value = "";
            base64Vertical.value = "";
            juegoErrors.vertical = "Selecciona una imagen vertical.";
        } else if (categoria === "personaje") {
            previewPersonaje.value = "";
            base64Personaje.value = "";
            juegoErrors.personaje = "Selecciona una imagen de personaje.";
        }
        return;
    }
    if (!isValidImageFile(file)) {
        if (categoria === "horizontal") {
            juegoErrors.horizontal =
                "El archivo seleccionado no es una imagen válida.";
            previewHorizontal.value = "";
            base64Horizontal.value = "";
        } else if (categoria === "vertical") {
            juegoErrors.vertical =
                "El archivo seleccionado no es una imagen válida.";
            previewVertical.value = "";
            base64Vertical.value = "";
        } else if (categoria === "personaje") {
            juegoErrors.personaje =
                "El archivo seleccionado no es una imagen válida.";
            previewPersonaje.value = "";
            base64Personaje.value = "";
        }
        return;
    } else {
        if (categoria === "horizontal") juegoErrors.horizontal = null;
        if (categoria === "vertical") juegoErrors.vertical = null;
        if (categoria === "personaje") juegoErrors.personaje = null;
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

function fileToBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.onerror = (error) => reject(error);
        reader.readAsDataURL(file);
    });
}

function dataUrlToBase64(dataUrl) {
    if (!dataUrl) return "";
    const parts = dataUrl.split(",");
    return parts.length > 1 ? parts[1] : dataUrl;
}

function validateAllJuegoFields() {
    let valid = true;
    if (!formJuego.nombre.trim()) {
        juegoErrors.nombre = "El nombre es obligatorio.";
        valid = false;
    } else {
        juegoErrors.nombre = null;
    }
    if (!formJuego.desarrollador.trim()) {
        juegoErrors.desarrollador = "El desarrollador es obligatorio.";
        valid = false;
    } else {
        juegoErrors.desarrollador = null;
    }
    if (!formJuego.editor.trim()) {
        juegoErrors.editor = "El editor es obligatorio.";
        valid = false;
    } else {
        juegoErrors.editor = null;
    }
    if (!formJuego.fecha_lanzamiento) {
        juegoErrors.fecha_lanzamiento = "La fecha es obligatoria.";
        valid = false;
    } else {
        juegoErrors.fecha_lanzamiento = null;
    }
    if (formJuego.precio === null || formJuego.precio === "") {
        juegoErrors.precio = "El precio es obligatorio.";
        valid = false;
    } else {
        juegoErrors.precio = null;
    }
    if (formJuego.descuento > formJuego.precio) {
        juegoErrors.descuento =
            "El descuento no puede ser mayor que el precio.";
        valid = false;
    } else if (formJuego.descuento < 0 || formJuego.descuento > 100) {
        juegoErrors.descuento = "El descuento debe estar entre 0 y 100.";
        valid = false;
    } else {
        juegoErrors.descuento = null;
    }
    if (!formJuego.generos.length) {
        juegoErrors.generos = "Debes seleccionar al menos un género.";
        valid = false;
    } else {
        juegoErrors.generos = null;
    }
    if (!formJuego.plataforma.trim()) {
        juegoErrors.plataforma = "La plataforma es obligatoria.";
        valid = false;
    } else {
        juegoErrors.plataforma = null;
    }
    if (!base64Horizontal.value) {
        juegoErrors.horizontal = "Selecciona una imagen horizontal.";
        valid = false;
    } else {
        juegoErrors.horizontal = null;
    }
    if (!base64Vertical.value) {
        juegoErrors.vertical = "Selecciona una imagen vertical.";
        valid = false;
    } else {
        juegoErrors.vertical = null;
    }
    if (!base64Personaje.value) {
        juegoErrors.personaje = "Selecciona una imagen de personaje.";
        valid = false;
    } else {
        juegoErrors.personaje = null;
    }
    return valid;
}

async function onSubmit() {
    isSubmitting.value = true;
    try {
        const valid = validateAllJuegoFields();
        if (!valid) {
            throw new Error("Revisa los campos del formulario.");
        }
        // 1. Crear el juego (sin imágenes)
        const payload = {
            ...formJuego,
            // NO incluyas 'imagenes'
        };
        const nuevoJuego = await gamesStore.crearGame(payload);
        if (!nuevoJuego || !nuevoJuego.id_juego) {
            throw new Error(gamesStore.error || "Error al crear el juego");
        }

        // 2. Subir imágenes por separado
        const subirImagen = async (categoria, base64) => {
            await fetch(`${import.meta.env.VITE_API_URL_REAL}/juego-imagenes`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id_juego: nuevoJuego.id_juego,
                    categoria,
                    imagen: base64,
                }),
            });
        };

        await subirImagen("horizontal", base64Horizontal.value);
        await subirImagen("vertical", base64Vertical.value);
        await subirImagen("personaje", base64Personaje.value);

        emit("saved");
    } catch (err) {
        alert(err.message || "Hubo un error al guardar.");
    } finally {
        isSubmitting.value = false;
    }
}

onMounted(() => {
    if (!generosStore.genres.length) {
        generosStore.fetchGenres && generosStore.fetchGenres({ pagina: 1, registrosPorPagina: 100 });
    }
});


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

.form-control::placeholder {
    color: #8f8f8f;
    opacity: 1;
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
