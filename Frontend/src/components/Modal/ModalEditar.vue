<template>
  <div v-if="visible" class="modal-backdrop" style="display: block; background-color: rgba(0,0,0,0.6);">
    <div class="modal d-block" tabindex="-1" role="dialog" @click.self="onCancel" style="overflow-y: auto;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header">
            <h5 class="modal-title">
              Modificar {{ entidadLabel }}
            </h5>
            <button type="button" class="btn-close btn-close-white" aria-label="Close" @click="onCancel"></button>
          </div>
          <div class="modal-body">
            <component
              :is="currentFormComponent"
              :item-actual="itemActual"
              @saved="emit('saved')"
              @cancel="onCancel"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import FormEditarJuego from "../Formularios/FormEditarJuego.vue";
import FormEditarUsuario from "../Formularios/FormEditarUsuario.vue";
import FormEditarGenero from "../Formularios/FormEditarGenero.vue";
import FormEditarNoticia from "../Formularios/FormEditarNoticia.vue";

const props = defineProps({
  entidad: { type: String, required: true },
  visible: { type: Boolean, required: true },
  itemActual: { type: Object, required: true }
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
      return FormEditarJuego;
    case "usuarios":
      return FormEditarUsuario;
    case "generos":
      return FormEditarGenero;
    case "noticias":
      return FormEditarNoticia;
    default:
      return null;
  }
});

function onCancel() {
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