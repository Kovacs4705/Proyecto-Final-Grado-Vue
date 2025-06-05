<!-- src/components/EntitiesList.vue -->
<template>
  <div class="container mt-4">
    <h2 class="mb-3">Seleccione una entidad para gestionar:</h2>
    <ul class="list-group">
      <li
        class="list-group-item list-group-item-action"
        v-for="entity in entities"
        :key="entity.id"
        @click="selectEntity(entity.name)"
      >
        {{ entity.label }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { defineEmits } from 'vue'

// Emitimos el nombre de la entidad seleccionada
const emit = defineEmits(['entity-selected'])

// Definimos las entidades disponibles
const entities = [
  { id: 1, name: 'juegos',   label: 'Juegos' },
  { id: 2, name: 'usuarios', label: 'Usuarios' },
  { id: 3, name: 'generos',  label: 'Géneros' },
  { id: 4, name: 'noticias', label: 'Noticias' },
]

function selectEntity(name) {
  // Emitimos el evento para que el padre (PanelControlView.vue) lo capture
  emit('entity-selected', name)
}
</script>

<style scoped>
.list-group-item {
  cursor: pointer;
}
.list-group-item:hover {
  background-color: #f0f0f0;
}
</style>
