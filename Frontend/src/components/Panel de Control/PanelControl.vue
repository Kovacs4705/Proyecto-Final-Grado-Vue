<!-- src/components/EntitiesList.vue -->
<template>
  <div class="container mt-5">
    <!-- Título principal con fondo y padding -->
    <!-- <h2 class="text-white mb-4 entity-header text-start">
      Seleccione una entidad para gestionar:
    </h2> -->
    <div class="row">
      <div
        class="col-6 col-md-4 col-lg-3 mb-4"
        v-for="entity in entities"
        :key="entity.id"
      >
        <div
          class="card entity-card h-100"
          @click="selectEntity(entity.name)"
        >
          <div class="card-body d-flex flex-column justify-content-center">
            <i :class="entity.icon" class="entity-icon mb-3"></i>
            <!-- Título de cada tarjeta, alineado a la izquierda -->
            <h5 class="card-title mb-0 entity-title text-start">
              {{ entity.label }}
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineEmits } from 'vue'

// Emitimos el nombre de la entidad seleccionada
const emit = defineEmits(['entity-selected'])

// Definimos las entidades disponibles y sus iconos FontAwesome
const entities = [
  { id: 1, name: 'juegos',   label: 'Juegos',   icon: 'fas fa-gamepad' },
  { id: 2, name: 'usuarios', label: 'Usuarios', icon: 'fas fa-users' },
  { id: 3, name: 'generos',  label: 'Géneros',  icon: 'fas fa-tags' },
  { id: 4, name: 'noticias', label: 'Noticias', icon: 'fas fa-newspaper' },
]

function selectEntity(name) {
  // Emitimos el evento para que el padre lo capture
  emit('entity-selected', name)
}
</script>

<style scoped>
/* Estilos generales del contenedor */
.container {
  /* Fondo oscuro y texto claro */
  color: #ffffff;
}

/* Encabezado principal con fondo y padding */
.entity-header {
  font-family: 'Oswald', sans-serif;
  font-size: 1.75rem;
  letter-spacing: 0.5px;
  color: #42d54d; /* verde fosforescente */
  background-color: rgba(66, 213, 77, 0.1);
  padding: 0.5rem 1rem;
  border-radius: 4px;
  display: inline-block;
  text-align: left;
}

/* Tarjeta de cada entidad */
.entity-card {
  background-color: #1c1c1c;
  border: 1px solid #2c2c2c;
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  cursor: pointer;
  padding: 1rem;
}

.entity-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
  border-color: #42d54d; /* verde fosforescente acorde al proyecto */
}

.entity-icon {
  font-size: 2.5rem;
  color: #42d54d;
}

/* Título en cada tarjeta, alineado a la izquierda */
.entity-title {
  font-family: 'Oswald', sans-serif;
  font-size: 1.1rem;
  color: #ffffff;
}

/* Asegura que la tarjeta ocupe toda la altura del contenedor padre */
.h-100 {
  height: 100%;
}
</style>
