<!-- src/components/ConfirmModal.vue -->
<template>
  <!-- Teleport al body para que esté sobre todo -->
  <teleport to="body">
    <div
      v-if="visible"
      ref="backdrop"
      class="modal-backdrop"
      @click.self="onCancel"
    >
      <div ref="container" class="modal-container">
        <div class="modal-header">
          <h5 class="modal-title">
            ¿Estás seguro que quieres eliminar este elemento?
          </h5>
        </div>
        <div class="modal-body">
          <p>Este cambio no se podrá deshacer</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" @click="onCancel">Cancelar</button>
          <button
            class="btn btn-danger"
            :disabled="isProcessing"
            @click="onConfirm"
          >
            <template v-if="isProcessing">
              <span
                class="spinner-border spinner-border-sm text-light"
                role="status"
              ></span>
              <span class="ms-1">Eliminando...</span>
            </template>
            <template v-else>Eliminar</template>
          </button>
        </div>
      </div>
    </div>
  </teleport>
</template>

<script setup>
import { ref, watch, nextTick } from 'vue'
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  visible: { type: Boolean, default: false },
  isProcessing: { type: Boolean, default: false },
})

const emit = defineEmits(['confirm', 'cancel'])

const backdrop = ref(null)
const container = ref(null)

function onConfirm() {
  emit('confirm')
}

function onCancel() {
  emit('cancel')
}

// Al cambiar `visible`, anclamos la posición al scroll actual
watch(
  () => props.visible,
  async (vis) => {
    if (vis) {
      document.body.classList.add('no-scroll')
      await nextTick()
      const y = window.scrollY
      if (backdrop.value) {
        backdrop.value.style.top = `${y}px`
      }

    } else {
      document.body.classList.remove('no-scroll')
      // Limpiamos estilos
      if (backdrop.value) {
        backdrop.value.style.top = null
      }
    }
  }
)
</script>

<style>
/* Evitar scroll en el body cuando modal está abierto */
body.no-scroll {
  overflow: hidden;
}

/* Fondo semitransparente que cubre la “ventana virtual” */
.modal-backdrop {
  position: absolute;    /* no fixed, sino absolute con top = scrollY */
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;      /* centra verticalmente en la ventana visible */
  justify-content: center;  /* centra horizontalmente */
  z-index: 1050;
}

/* Contenedor del modal centrado */
.modal-container {
  background-color: #1c1c1c;
  color: #fff;
  border-radius: 0.3rem;
  width: 90%;
  max-width: 400px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
}

/* Encabezado */
.modal-header {
  padding: 1rem;
  border-bottom: 1px solid #333;
}

/* Título */
.modal-title {
  margin: 0;
  font-family: 'Oswald', sans-serif;
  font-size: 1.25rem;
}

/* Cuerpo */
.modal-body {
  padding: 1rem;
  font-size: 0.95rem;
}

/* Pie de modal con botones */
.modal-footer {
  padding: 0.75rem 1rem;
  display: flex;
  justify-content: flex-end;
  gap: 0.5rem;
  border-top: 1px solid #333;
}

.modal-footer .btn {
  min-width: 80px;
}
</style>
