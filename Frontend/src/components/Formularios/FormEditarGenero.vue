<template>
    <form @submit.prevent="onSubmit">
        <div class="mb-3">
            <label class="form-label">Nombre Género*</label>
            <input
                v-model="formGenero.nombre"
                type="text"
                class="form-control"
                placeholder="Ej: Acción"
                required
                @blur="validateNombreOnBlur"
            />
            <div
                v-if="generoErrors.nombre"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ generoErrors.nombre }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Imagen de Género*</label>
            <div v-if="previewGenero" class="mb-2">
                <img
                    :src="previewGenero"
                    alt="Imagen género"
                    class="img-fluid rounded"
                    style="max-height: 200px; object-fit: cover"
                />
            </div>
            <input
                type="file"
                accept="image/*"
                class="form-control"
                @change="onFileGeneroChange"
            />
            <div
                v-if="generoErrors.imagen"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ generoErrors.imagen }}
            </div>
            <div v-if="fileGenero" class="mt-2 text-white">
                ⚙️ Archivo seleccionado: {{ fileGenero.name }}
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
                <span v-else>Guardar cambios</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, reactive, watch } from "vue";
import { useGenerosStore } from "../../stores/useGenerosStore.js";

const props = defineProps({
    itemActual: { type: Object, required: true }
});
const emit = defineEmits(["saved", "cancel"]);
const generosStore = useGenerosStore();

const formGenero = reactive({
    nombre: "",
    imagen: ""
});

const generoErrors = reactive({
    nombre: null,
    imagen: null
});

const fileGenero = ref(null);
const previewGenero = ref("");
const isSubmitting = ref(false);

// Inicializar el formulario cuando cambia el itemActual
watch(
    () => props.itemActual,
    (nuevo) => {
        formGenero.nombre = nuevo?.nombre || "";
        formGenero.imagen = nuevo?.imagen || "";
        fileGenero.value = null;
        // Mostrar la imagen actual si existe
        if (nuevo?.imagen) {
            previewGenero.value = `data:${nuevo.mime_type || "image/jpeg"};base64,${nuevo.imagen}`;
        } else {
            previewGenero.value = "";
        }
    },
    { immediate: true }
);

function validateNombreOnBlur() {
    if (!formGenero.nombre.trim()) {
        generoErrors.nombre = "El nombre del género es obligatorio.";
    } else {
        generoErrors.nombre = null;
    }
}

function validateImagenOnBlur() {
    if (!formGenero.imagen) {
        generoErrors.imagen = "Debes seleccionar una imagen para el género.";
    } else {
        generoErrors.imagen = null;
    }
}

function validateAllGeneroFields() {
    let valid = true;
    if (!formGenero.nombre.trim()) {
        generoErrors.nombre = "El nombre del género es obligatorio.";
        valid = false;
    } else {
        generoErrors.nombre = null;
    }
    if (!formGenero.imagen) {
        generoErrors.imagen = "Debes seleccionar una imagen para el género.";
        valid = false;
    } else {
        generoErrors.imagen = null;
    }
    return valid;
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

function isValidImageFile(file) {
    if (!file) return false;
    if (file.type && file.type.startsWith("image/")) return true;
    const validExtensions = [".jpg", ".jpeg", ".png", ".gif", ".bmp", ".webp"];
    const name = file.name ? file.name.toLowerCase() : "";
    return validExtensions.some(ext => name.endsWith(ext));
}

async function onFileGeneroChange(event) {
    const file = event.target.files[0] || null;
    fileGenero.value = file;
    if (!file) {
        // Si no se selecciona archivo, mantenemos la imagen actual
        previewGenero.value = props.itemActual?.imagen
            ? `data:${props.itemActual.mime_type || "image/jpeg"};base64,${props.itemActual.imagen}`
            : "";
        return;
    }
    if (!isValidImageFile(file)) {
        generoErrors.imagen = "El archivo seleccionado no es una imagen válida.";
        formGenero.imagen = "";
        previewGenero.value = "";
        fileGenero.value = null;
        return;
    } else {
        generoErrors.imagen = null;
    }
    const base64 = await fileToBase64(file);
    formGenero.imagen = dataUrlToBase64(base64);
    previewGenero.value = base64;
    validateImagenOnBlur();
}

async function onSubmit() {
    isSubmitting.value = true;
    try {
        const valid = validateAllGeneroFields();
        if (!valid) {
            throw new Error("Revisa los campos del formulario.");
        }
        const payload = {
            nombre: formGenero.nombre.trim(),
            imagen: formGenero.imagen
        };
        const actualizado = await generosStore.updateGenre(props.itemActual.id_genero, payload);
        if (!actualizado) {
            throw new Error(generosStore.error || "Error al actualizar el género.");
        }
        emit("saved");
    } catch (err) {
        alert(err.message || "Hubo un error al guardar.");
    } finally {
        isSubmitting.value = false;
    }
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