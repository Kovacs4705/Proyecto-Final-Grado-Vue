<!-- src/views/PanelControlView.vue -->
<template>
  <div class="container mt-4">
    <h1>Panel de Control</h1>
    <PanelControl @entity-selected="onEntitySelected" />

    <!-- Aquí luego mostrarás la lista correspondiente según la entidad seleccionada -->
    <div v-if="selectedEntity" class="mt-4">
      <h3>Entidad seleccionada: {{ selectedEntityLabel }}</h3>
      <!-- En este punto, harás el GET y mostrarás la tabla de la entidad -->
      <!-- Por ejemplo:
           <JuegosList v-if="selectedEntity === 'juegos'" />
           <UsuariosList v-else-if="selectedEntity === 'usuarios'" />
           ...etc.
      -->
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import PanelControl from '../components/Panel de Control/PanelControl.vue'

const selectedEntity = ref(null)

function onEntitySelected(name) {
  selectedEntity.value = name
}

// Para mostrar el label legible de la entidad seleccionada
const selectedEntityLabel = computed(() => {
  switch (selectedEntity.value) {
    case 'juegos':   return 'Juegos'
    case 'usuarios': return 'Usuarios'
    case 'generos':  return 'Géneros'
    case 'noticias': return 'Noticias'
    default:         return ''
  }
})
</script>

<style scoped>
/* Estilos opcionales */
</style>
