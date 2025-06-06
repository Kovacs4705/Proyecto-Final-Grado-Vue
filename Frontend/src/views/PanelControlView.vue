<!-- src/views/PanelControlView.vue -->
<template>
  <div class="container mt-4">
    <!-- 1) Título -->
    <h1 class="panel-header">Panel de Control</h1>

    <!-- 2) Tarjetas de entidades -->
    <PanelControl @entity-selected="onEntitySelected" />

    <!-- 3) Sección que muestra la tabla según entidad seleccionada -->
    <div v-if="selectedEntity" class="mt-5">
      <!-- 3.1) Botón “Crear” -->
      <button class="btn btn-success mb-4 create-btn" @click="openCreateModal">
        Crear {{ selectedEntityLabel }}
      </button>

      <!-- 3.2) Spinners condicionales -->
      <div v-if="selectedEntity === 'juegos' && gamesStore.isLoadingList" class="text-center my-4">
        <span class="spinner-border text-light" role="status"></span>
        <span class="ms-2 text-light">Cargando juegos…</span>
      </div>

      <div v-else-if="selectedEntity === 'usuarios' && usersStore.isLoadingList" class="text-center my-4">
        <span class="spinner-border text-light" role="status"></span>
        <span class="ms-2 text-light">Cargando usuarios…</span>
      </div>

      <div v-else-if="selectedEntity === 'generos' && genresStore.isLoadingList" class="text-center my-4">
        <span class="spinner-border text-light" role="status"></span>
        <span class="ms-2 text-light">Cargando géneros…</span>
      </div>

      <div v-else-if="selectedEntity === 'noticias' && noticiasStore.isLoadingList" class="text-center my-4">
        <span class="spinner-border text-light" role="status"></span>
        <span class="ms-2 text-light">Cargando noticias…</span>
      </div>

      <!-- 3.3) Tabla de JUEGOS -->
      <div v-if="selectedEntity === 'juegos'" class="table-responsive">
        <table class="table table-dark table-striped align-middle">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Desarrollador</th>
              <th scope="col">Editor</th>
              <th scope="col">Fecha Lanz.</th>
              <th scope="col">Precio</th>
              <th scope="col">Descuento (%)</th>
              <th scope="col">Género</th>
              <th scope="col">Plataforma</th>
              <th scope="col" class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="gamesStore.games.length === 0 && !gamesStore.isLoadingList">
              <td colspan="10" class="text-center text-muted">
                No hay juegos disponibles.
              </td>
            </tr>
            <tr v-for="(juego, index) in gamesStore.games" :key="juego.id_juego">
              <th scope="row">{{ index + 1 }}</th>
              <td>{{ juego.nombre }}</td>
              <td>{{ juego.desarrollador }}</td>
              <td>{{ juego.editor }}</td>
              <td>{{ formatoFecha(juego.fecha_lanzamiento) }}</td>
              <td>{{ juego.precio }}</td>
              <td>{{ juego.descuento }}</td>
              <td>{{ juego.genero }}</td>
              <td>{{ juego.plataforma }}</td>
              <td class="text-center">
                <button class="btn btn-sm btn-outline-warning me-2" @click="onEditClick(juego)">
                  Modificar
                </button>
                <button class="btn btn-sm btn-outline-danger" @click="openConfirmModal(juego)"
                  :disabled="deletingId === juego.id_juego">
                  <template v-if="deletingId === juego.id_juego">
                    <span class="spinner-border spinner-border-sm text-light" role="status"></span>
                  </template>
                  <template v-else>Eliminar</template>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- 3.4) Tabla de USUARIOS -->
      <div v-else-if="selectedEntity === 'usuarios'" class="table-responsive">
        <table class="table table-dark table-striped align-middle">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Email</th>
              <th scope="col">DNI</th>
              <th scope="col">Rol</th>
              <th scope="col">Saldo</th>
              <th scope="col" class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="usersStore.users.length === 0 && !usersStore.isLoadingList">
              <td colspan="7" class="text-center text-muted">
                No hay usuarios disponibles.
              </td>
            </tr>
            <tr v-for="(usuario, index) in usersStore.users" :key="usuario.dni_usuario">
              <th scope="row">{{ index + 1 }}</th>
              <td>{{ usuario.nombre }}</td>
              <td>{{ usuario.email }}</td>
              <td>{{ usuario.dni_usuario }}</td>
              <td>{{ usuario.rol }}</td>
              <td>{{ usuario.saldo }}</td>
              <td class="text-center">
                <button class="btn btn-sm btn-outline-warning me-2" @click="onEditClick(usuario)">
                  Modificar
                </button>
                <button class="btn btn-sm btn-outline-danger" @click="openConfirmModal(usuario)"
                  :disabled="deletingId === usuario.dni_usuario">
                  <template v-if="deletingId === usuario.dni_usuario">
                    <span class="spinner-border spinner-border-sm text-light" role="status"></span>
                  </template>
                  <template v-else>Eliminar</template>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- 3.5) Tabla de GÉNEROS -->
      <div v-else-if="selectedEntity === 'generos'" class="table-responsive">
        <table class="table table-dark table-striped align-middle">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col" class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="genresStore.genres.length === 0 && !genresStore.isLoadingList">
              <td colspan="3" class="text-center text-muted">
                No hay géneros disponibles.
              </td>
            </tr>
            <tr v-for="(genre, index) in genresStore.genres" :key="genre.id_genero">
              <th scope="row">{{ index + 1 }}</th>
              <td>{{ genre.nombre }}</td>
              <td class="text-center">
                <button class="btn btn-sm btn-outline-warning me-2" @click="onEditClick(genre)">
                  Modificar
                </button>
                <button class="btn btn-sm btn-outline-danger" @click="openConfirmModal(genre)"
                  :disabled="deletingId === genre.id_genero">
                  <template v-if="deletingId === genre.id_genero">
                    <span class="spinner-border spinner-border-sm text-light" role="status"></span>
                  </template>
                  <template v-else>Eliminar</template>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- 3.6) Tabla de NOTICIAS (sin mostrar el id_noticia) -->
      <div v-else-if="selectedEntity === 'noticias'" class="table-responsive">
        <table class="table table-dark table-striped align-middle">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Título</th>
              <th scope="col">Fecha Creación</th>
              <th scope="col">Fecha Modificación</th>
              <th scope="col" class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <!-- Si no hay noticias y no está cargando -->
            <tr v-if="noticiasStore.noticias.length === 0 && !noticiasStore.isLoadingList">
              <td colspan="5" class="text-center text-muted">
                No hay noticias disponibles.
              </td>
            </tr>
            <!-- Recorremos cada noticia -->
            <tr v-for="(noticia, index) in noticiasStore.noticias" :key="noticia.id_noticia">
              <th scope="row">{{ index + 1 }}</th>
              <td>{{ noticia.titulo }}</td>
              <td>{{ formatoFecha(noticia.created_at) }}</td>
              <td>{{ formatoFecha(noticia.updated_at) }}</td>
              <td class="text-center">
                <button class="btn btn-sm btn-outline-warning me-2" @click="onEditClick(noticia)">
                  Modificar
                </button>
                <button class="btn btn-sm btn-outline-danger" @click="openConfirmModal(noticia)"
                  :disabled="deletingId === noticia.id_noticia">
                  <template v-if="deletingId === noticia.id_noticia">
                    <span class="spinner-border spinner-border-sm text-light" role="status"></span>
                  </template>
                  <template v-else>Eliminar</template>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <CreateModal v-if="showCreateModal" :entidad="selectedEntity" :visible="showCreateModal" @saved="onCreated"
      @cancel="onCancelCreate" />

    <!-- 4) Modal de confirmación (teleport a <body> para que quede por encima) -->
    <ConfirmModal :visible="showConfirmModal" :isProcessing="isDeleting" @confirm="confirmDeletion"
      @cancel="cancelDeletion" />
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useGamesStore } from '../stores/useGamesStore.js'
import { useUsersStore } from '../stores/useUserStore.js'
import { useGenerosStore } from '../stores/useGenerosStore.js'
import { useNoticiasStore } from '../stores/useNoticiasStore.js'
import PanelControl from '../components/Panel de Control/PanelControl.vue'
import ConfirmModal from '../components/Modal/ModalEliminar.vue'
import CreateModal from '../components/Modal/ModalCrear.vue'

const API_URL = import.meta.env.VITE_API_URL_REAL

// 1) Estados reactivas
const selectedEntity = ref(null)       // “juegos”, “usuarios”, “generos”, “noticias”
const deletingId = ref(null)           // id_juego, dni_usuario, id_genero, id_noticia
const showConfirmModal = ref(false)    // controla visibilidad del modal
const itemToDelete = ref(null)         // almacena el objeto a eliminar
const showCreateModal = ref(false)    // controla visibilidad del modal de creación

// 2) Instanciamos los stores
const gamesStore = useGamesStore()
const usersStore = useUsersStore()
const genresStore = useGenerosStore()
const noticiasStore = useNoticiasStore()

// 3) Computed: true cuando se está eliminando algo
const isDeleting = computed(() => deletingId.value !== null)

// 4) Computed: si alguna entidad está cargando
const isLoading = computed(() => {
  if (selectedEntity.value === 'juegos') return gamesStore.isLoadingList
  if (selectedEntity.value === 'usuarios') return usersStore.isLoadingList
  if (selectedEntity.value === 'generos') return genresStore.isLoadingList
  if (selectedEntity.value === 'noticias') return noticiasStore.isLoadingList
  return false
})

// 5) Watcher: carga la lista adecuada cuando cambie la entidad
watch(selectedEntity, async (newEntity) => {
  if (newEntity === 'juegos') {
    await gamesStore.fetchGames({ pagina: 1, registrosPorPagina: 1000 })
  } else if (newEntity === 'usuarios') {
    await usersStore.fetchUsers({ pagina: 1, registrosPorPagina: 1000 })
  } else if (newEntity === 'generos') {
    await genresStore.fetchGenres({ pagina: 1, registrosPorPagina: 1000 })
  } else if (newEntity === 'noticias') {
    await noticiasStore.fetchNoticias({ pagina: 1, registrosPorPagina: 1000 })
  }
})

// 6) Función que captura la entidad desde <PanelControl>
function onEntitySelected(name) {
  selectedEntity.value = name
}

// 7) Computed: etiqueta legible según entidad
const selectedEntityLabel = computed(() => {
  switch (selectedEntity.value) {
    case 'juegos': return 'Juegos'
    case 'usuarios': return 'Usuarios'
    case 'generos': return 'Géneros'
    case 'noticias': return 'Noticias'
    default: return ''
  }
})

// 8) Formatear fecha a “YYYY-MM-DD”
function formatoFecha(fechaIso) {
  if (!fechaIso) return ''
  return fechaIso.split('T')[0]
}

// 9) CREAR
function openCreateModal() {
  if (!selectedEntity.value) return
  // 1) Desplazar la ventana hasta arriba
  window.scrollTo({ top: 0, behavior: 'smooth' })
  // 2) Abrir el modal
  showCreateModal.value = true
}

function onCancelCreate() {
  showCreateModal.value = false
}
async function onCreated() {
  showCreateModal.value = false
  // Recarga la lista de la entidad recién creada
  if (selectedEntity.value === 'juegos') {
    await gamesStore.fetchGames({ pagina: 1, registrosPorPagina: 1000 })
  } else if (selectedEntity.value === 'usuarios') {
    await usersStore.fetchUsers({ pagina: 1, registrosPorPagina: 1000 })
  } else if (selectedEntity.value === 'generos') {
    await genresStore.fetchGenres({ pagina: 1, registrosPorPagina: 1000 })
  } else if (selectedEntity.value === 'noticias') {
    await noticiasStore.fetchNoticias({ pagina: 1, registrosPorPagina: 1000 })
  }
}
function onEditClick(item) {
  if (selectedEntity.value === 'juegos') {
    alert(`Modificar juego: "${item.nombre}" (ID: ${item.id_juego})`)
  } else if (selectedEntity.value === 'usuarios') {
    alert(`Modificar usuario: "${item.nombre}" (DNI: ${item.dni_usuario})`)
  } else if (selectedEntity.value === 'generos') {
    alert(`Modificar género: "${item.nombre}" (ID: ${item.id_genero})`)
  } else if (selectedEntity.value === 'noticias') {
    alert(`Modificar noticia: "${item.titulo}" (ID: ${item.id_noticia})`)
  }
}

// 10) Abrir modal de confirmación y guardar el objeto a eliminar
function openConfirmModal(item) {
  itemToDelete.value = item
  showConfirmModal.value = true
}

// 11) Confirmar borrado según entidad
async function confirmDeletion() {
  if (!itemToDelete.value) return

  if (selectedEntity.value === 'juegos') {
    deletingId.value = itemToDelete.value.id_juego
    const result = await gamesStore.eliminarGame(itemToDelete.value.id_juego)
    if (result) {
      await gamesStore.fetchGames({ pagina: 1, registrosPorPagina: 1000 })
    } else {
      alert(`Error al eliminar juego: ${gamesStore.error}`)
    }
  }
  else if (selectedEntity.value === 'usuarios') {
    deletingId.value = itemToDelete.value.dni_usuario
    const result = await usersStore.deleteUser(itemToDelete.value.dni_usuario)
    if (result) {
      await usersStore.fetchUsers({ pagina: 1, registrosPorPagina: 1000 })
    } else {
      alert(`Error al eliminar usuario: ${usersStore.error}`)
    }
  }
  else if (selectedEntity.value === 'generos') {
    deletingId.value = itemToDelete.value.id_genero
    const result = await genresStore.deleteGenre(itemToDelete.value.id_genero)
    if (result) {
      await genresStore.fetchGenres({ pagina: 1, registrosPorPagina: 1000 })
    } else {
      alert(`Error al eliminar género: ${genresStore.error}`)
    }
  }
  else if (selectedEntity.value === 'noticias') {
    deletingId.value = itemToDelete.value.id_noticia
    const result = await noticiasStore.eliminarNoticia(itemToDelete.value.id_noticia)
    if (result) {
      await noticiasStore.fetchNoticias({ pagina: 1, registrosPorPagina: 1000 })
    } else {
      alert(`Error al eliminar noticia: ${noticiasStore.error}`)
    }
  }

  // Limpiar y cerrar modal
  deletingId.value = null
  itemToDelete.value = null
  showConfirmModal.value = false
}

// 12) Cancelar borrado
function cancelDeletion() {
  showConfirmModal.value = false
  itemToDelete.value = null
}
</script>

<style scoped>
/* ================================== */
/*      Estilos generales del Panel    */
/* ================================== */
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

.panel-header::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 33%;
  height: 4px;
  background-color: #42d54d;
}

.create-btn {
  font-family: 'Oswald', sans-serif;
}

/* ================================== */
/*       Estilos de las tablas         */
/* ================================== */
.table-dark {
  background-color: #1c1c1c;
  border: 1px solid #2c2c2c;
}

.table-striped>tbody>tr:nth-of-type(odd) {
  background-color: rgba(66, 213, 77, 0.05);
}

/* ================================== */
/*      Botones de acción              */
/* ================================== */
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

/* ================================== */
/*     Spinner centrado                */
/* ================================== */
.text-center {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
