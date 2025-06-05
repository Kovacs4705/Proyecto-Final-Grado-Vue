<!-- src/views/PanelControlView.vue -->
<template>
  <div class="container mt-4">
    <!-- Título "Panel de Control" con línea verde debajo de un tercio de su ancho -->
    <h1 class="panel-header">Panel de Control</h1>

    <!-- Lista de tarjetas con las entidades -->
    <PanelControl @entity-selected="onEntitySelected" />

    <!-- Sección de gestión de la entidad seleccionada -->
    <div v-if="selectedEntity" class="mt-5">
      <!-- Botón general de crear -->
      <button
        class="btn btn-success mb-4 create-btn"
        @click="onCreateClick"
      >
        Crear {{ selectedEntityLabel }}
      </button>

      <!-- Cabecera de tabla -->
      <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col" class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in items" :key="index">
              <th scope="row">{{ index + 1 }}</th>
              <td>{{ item }}</td>
              <td class="text-center">
                <button
                  class="btn btn-sm btn-outline-warning me-2"
                  @click="onEditClick(item)"
                >
                  Modificar
                </button>
                <button
                  class="btn btn-sm btn-outline-danger"
                  @click="onDeleteClick(item)"
                >
                  Eliminar
                </button>
              </td>
            </tr>
            <tr v-if="items.length === 0">
              <td colspan="3" class="text-center text-muted">
                No hay registros disponibles.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import PanelControl from '../components/Panel de Control/PanelControl.vue'

// Estado para la entidad seleccionada
const selectedEntity = ref(null)

// Función que recibe el nombre de la entidad desde el componente hijo
function onEntitySelected(name) {
  selectedEntity.value = name
}

// Texto legible de la entidad seleccionada
const selectedEntityLabel = computed(() => {
  switch (selectedEntity.value) {
    case 'juegos':   return 'Juegos'
    case 'usuarios': return 'Usuarios'
    case 'generos':  return 'Géneros'
    case 'noticias': return 'Noticias'
    default:         return ''
  }
})

// Mock de datos para cada entidad (solo de ejemplo, sin conexión a API)
const items = computed(() => {
  switch (selectedEntity.value) {
    case 'juegos':
      return ['The Witcher 3', 'Uncharted 4', 'Cyberpunk 2077']
    case 'usuarios':
      return ['Juan Pérez', 'María García', 'Luis Martínez']
    case 'generos':
      return ['Aventura', 'RPG', 'Acción']
    case 'noticias':
      return ['Lanzamiento de nuevo DLC', 'Evento de verano', 'Mantenimiento programado']
    default:
      return []
  }
})

// Stubs de eventos para crear, editar y eliminar
function onCreateClick() {
  alert(`Crear nuevo registro en "${selectedEntityLabel.value}"`)
}
function onEditClick(item) {
  alert(`Modificar "${item}" en "${selectedEntityLabel.value}"`)
}
function onDeleteClick(item) {
  alert(`Eliminar "${item}" de "${selectedEntityLabel.value}"`)
}
</script>

<style scoped>
/* Encabezado "Panel de Control" */
.panel-header {
  font-family: 'Oswald', sans-serif;
  font-size: 2rem;
  color: #ffffff;
  margin-bottom: 1rem;
  padding-bottom: 0.25rem;
  text-align: left;
  display: inline-block;
  position: relative;
}
/* Línea verde debajo ocupando 1/3 del ancho del texto */
.panel-header::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 33%;
  height: 4px;
  background-color: #42d54d;
}

/* Botón "Crear" alineado a la izquierda y con estilo */
.create-btn {
  font-family: 'Oswald', sans-serif;
}

/* Estilos de la tabla oscura */
.table-dark {
  background-color: #1c1c1c;
  border: 1px solid #2c2c2c;
}
.table-striped > tbody > tr:nth-of-type(odd) {
  background-color: rgba(66, 213, 77, 0.05); /* verde muy tenue en filas impares */
}

/* Botones de acción en cada fila */
.btn-outline-warning {
  border-color: #f0ad4e;
  color: #f0ad4e;
}
.btn-outline-warning:hover {
  background-color: #f0ad4e;
  color: #1c1c1c;
}

.btn-outline-danger {
  border-color: #d9534f;
  color: #d9534f;
}
.btn-outline-danger:hover {
  background-color: #d9534f;
  color: #1c1c1c;
}
</style>
