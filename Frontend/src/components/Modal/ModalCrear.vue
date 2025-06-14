<template>
    <div v-if="visible" class="modal-backdrop" style="display: block">
        <div
            class="modal d-block"
            tabindex="-1"
            role="dialog"
            @click.self="cancel"
            style="overflow-y: auto"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear {{ entidadLabel }}</h5>
                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            aria-label="Close"
                            @click="cancel"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <component
                            :is="currentFormComponent"
                            @saved="emit('saved')"
                            @cancel="cancel"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import FormCrearJuego from "../Formularios/FormCrearJuego.vue";
import FormCrearUsuario from "../Formularios/FormCrearUsuario.vue";
import FormCrearGenero from "../Formularios/FormCrearGenero.vue";
import FormCrearNoticia from "../Formularios/FormCrearNoticia.vue";

const props = defineProps({
    entidad: { type: String, required: true },
    visible: { type: Boolean, required: true },
});
const emit = defineEmits(["saved", "cancel"]);

const entidadLabel = computed(() => {
    if (props.entidad === "juegos") return "Juego";
    if (props.entidad === "usuarios") return "Usuario";
    if (props.entidad === "generos") return "Género";
    if (props.entidad === "noticias") return "Noticia";
    return "";
});

const currentFormComponent = computed(() => {
    switch (props.entidad) {
        case "juegos":
            return FormCrearJuego;
        case "usuarios":
            return FormCrearUsuario;
        case "generos":
            return FormCrearGenero;
        case "noticias":
            return FormCrearNoticia;
        default:
            return null;
    }
});

function cancel() {
    emit("cancel");
}
</script>


