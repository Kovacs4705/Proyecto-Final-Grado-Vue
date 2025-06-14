<template>
    <form @submit.prevent="onSubmit">
        <div class="mb-3">
            <label class="form-label">Título*</label>
            <input
                v-model="formNoticia.titulo"
                type="text"
                class="form-control"
                required
                @blur="validateTituloOnBlur"
            />
            <div
                v-if="noticiaErrors.titulo"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ noticiaErrors.titulo }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Portada (archivo)*</label>
            <div v-if="previewPortada" class="mb-2">
                <img
                    :src="previewPortada"
                    alt="Portada"
                    class="img-fluid rounded"
                    style="max-height: 150px; object-fit: cover"
                />
            </div>
            <input
                type="file"
                accept="image/*"
                class="form-control"
                @change="onFilePortadaChange"
            />
            <div
                v-if="noticiaErrors.portada"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ noticiaErrors.portada }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Lightbox (archivo)*</label>
            <div v-if="previewLightbox" class="mb-2">
                <img
                    :src="previewLightbox"
                    alt="Lightbox"
                    class="img-fluid rounded"
                    style="max-height: 150px; object-fit: cover"
                />
            </div>
            <input
                type="file"
                accept="image/*"
                class="form-control"
                @change="onFileLightboxChange"
            />
            <div
                v-if="noticiaErrors.lightbox"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ noticiaErrors.lightbox }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción (corta*)</label>
            <textarea
                v-model="formNoticia.descripcion"
                class="form-control"
                rows="2"
                required
                @blur="validateDescripcionOnBlur"
            ></textarea>
            <div
                v-if="noticiaErrors.descripcion"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ noticiaErrors.descripcion }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Cuerpo (texto completo)*</label>
            <textarea
                v-model="formNoticia.cuerpo"
                class="form-control"
                rows="4"
                required
                @blur="validateCuerpoOnBlur"
            ></textarea>
            <div
                v-if="noticiaErrors.cuerpo"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ noticiaErrors.cuerpo }}
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
import { useNoticiasStore } from "../../stores/useNoticiasStore.js";

const props = defineProps({
    itemActual: { type: Object, required: true },
});
const emit = defineEmits(["saved", "cancel"]);
const noticiasStore = useNoticiasStore();

const formNoticia = reactive({
    titulo: "",
    portada: "",
    lightbox: "",
    descripcion: "",
    cuerpo: "",
});

const noticiaErrors = reactive({
    titulo: null,
    descripcion: null,
    cuerpo: null,
    portada: null,
    lightbox: null,
});

const previewPortada = ref("");
const previewLightbox = ref("");
const isSubmitting = ref(false);

// Inicializar el formulario con los datos actuales
watch(
    () => props.itemActual,
    (nuevo) => {
        formNoticia.titulo = nuevo?.titulo || "";
        formNoticia.descripcion = nuevo?.descripcion || "";
        formNoticia.cuerpo = nuevo?.cuerpo || "";
        // Si ya hay imágenes, mostrarlas como preview
        previewPortada.value = nuevo?.portada
            ? `data:${nuevo.mime_type_portada || "image/jpeg"};base64,${
                  nuevo.portada
              }`
            : "";
        formNoticia.portada = previewPortada.value;
        previewLightbox.value = nuevo?.lightbox
            ? `data:${nuevo.mime_type_lightbox || "image/jpeg"};base64,${
                  nuevo.lightbox
              }`
            : "";
        formNoticia.lightbox = previewLightbox.value;
    },
    { immediate: true }
);

function validateTituloOnBlur() {
    noticiaErrors.titulo = !formNoticia.titulo.trim()
        ? "El título es obligatorio."
        : null;
}
function validateDescripcionOnBlur() {
    noticiaErrors.descripcion = !formNoticia.descripcion.trim()
        ? "La descripción es obligatoria."
        : null;
}
function validateCuerpoOnBlur() {
    noticiaErrors.cuerpo = !formNoticia.cuerpo.trim()
        ? "El cuerpo de la noticia es obligatorio."
        : null;
}
function validatePortadaOnBlur() {
    noticiaErrors.portada = !formNoticia.portada
        ? "Selecciona una imagen para la portada."
        : null;
}
function validateLightboxOnBlur() {
    noticiaErrors.lightbox = !formNoticia.lightbox
        ? "Selecciona una imagen para el lightbox."
        : null;
}
function isValidImageFile(file) {
    if (!file) return false;
    if (file.type && file.type.startsWith("image/")) return true;
    const validExtensions = [".jpg", ".jpeg", ".png", ".gif", ".bmp", ".webp"];
    const name = file.name ? file.name.toLowerCase() : "";
    return validExtensions.some((ext) => name.endsWith(ext));
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
async function onFilePortadaChange(event) {
    const file = event.target.files[0];
    if (!file) {
        formNoticia.portada = "";
        previewPortada.value = "";
        validatePortadaOnBlur();
        return;
    }
    if (!isValidImageFile(file)) {
        noticiaErrors.portada =
            "El archivo seleccionado no es una imagen válida.";
        formNoticia.portada = "";
        previewPortada.value = "";
        return;
    } else {
        noticiaErrors.portada = null;
    }
    const base64 = await fileToBase64(file);
    formNoticia.portada = base64;
    previewPortada.value = base64;
    validatePortadaOnBlur();
}
async function onFileLightboxChange(event) {
    const file = event.target.files[0];
    if (!file) {
        formNoticia.lightbox = "";
        previewLightbox.value = "";
        validateLightboxOnBlur();
        return;
    }
    if (!isValidImageFile(file)) {
        noticiaErrors.lightbox =
            "El archivo seleccionado no es una imagen válida.";
        formNoticia.lightbox = "";
        previewLightbox.value = "";
        return;
    } else {
        noticiaErrors.lightbox = null;
    }
    const base64 = await fileToBase64(file);
    formNoticia.lightbox = base64;
    previewLightbox.value = base64;
    validateLightboxOnBlur();
}
function validateAllNoticiaFields() {
    let valid = true;
    if (!formNoticia.titulo.trim()) {
        noticiaErrors.titulo = "El título es obligatorio.";
        valid = false;
    } else {
        noticiaErrors.titulo = null;
    }
    if (!formNoticia.descripcion.trim()) {
        noticiaErrors.descripcion = "La descripción es obligatoria.";
        valid = false;
    } else {
        noticiaErrors.descripcion = null;
    }
    if (!formNoticia.cuerpo.trim()) {
        noticiaErrors.cuerpo = "El cuerpo de la noticia es obligatorio.";
        valid = false;
    } else {
        noticiaErrors.cuerpo = null;
    }
    if (!formNoticia.portada) {
        noticiaErrors.portada = "Selecciona una imagen para la portada.";
        valid = false;
    } else {
        noticiaErrors.portada = null;
    }
    if (!formNoticia.lightbox) {
        noticiaErrors.lightbox = "Selecciona una imagen para el lightbox.";
        valid = false;
    } else {
        noticiaErrors.lightbox = null;
    }
    return valid;
}
async function onSubmit() {
    isSubmitting.value = true;
    try {
        const valid = validateAllNoticiaFields();
        if (!valid) {
            throw new Error("Revisa los campos del formulario.");
        }
        const payload = {
            titulo: formNoticia.titulo,
            portada: dataUrlToBase64(formNoticia.portada),
            lightbox: dataUrlToBase64(formNoticia.lightbox),
            descripcion: formNoticia.descripcion,
            cuerpo: formNoticia.cuerpo,
        };
        const actualizado = await noticiasStore.actualizarNoticia(
            props.itemActual.id_noticia,
            payload
        );
        if (!actualizado) {
            throw new Error(
                noticiasStore.error || "Error al actualizar la noticia"
            );
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
