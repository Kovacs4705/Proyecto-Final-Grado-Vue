<!-- src/components/CreateModal.vue -->
<template>
  <teleport to="body">
    <div
      v-if="visible"
      ref="backdrop"
      class="modal-backdrop"
      @click.self="onCancel"
    >
      <div ref="container" class="modal-container">
        <div class="modal-header">
          <h5 class="modal-title">Crear {{ labelEntidad }}</h5>
        </div>
        <div class="modal-body">
          <form @submit.prevent="onSubmit">
            <!-- ⇨ JUEGOS ⇨ -->
            <div v-if="entidad === 'juegos'">
              <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input
                  v-model="form.nombre"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Desarrollador</label>
                <input
                  v-model="form.desarrollador"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Editor</label>
                <input
                  v-model="form.editor"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Fecha Lanzamiento</label>
                <input
                  v-model="form.fecha_lanzamiento"
                  type="date"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Precio</label>
                <input
                  v-model="form.precio"
                  type="number"
                  min="0"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Descuento (%)</label>
                <input
                  v-model="form.descuento"
                  type="number"
                  min="0"
                  max="100"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Género</label>
                <input
                  v-model="form.genero"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Plataforma</label>
                <input
                  v-model="form.plataforma"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
            </div>

            <!-- ⇨ USUARIOS ⇨ -->
            <div v-else-if="entidad === 'usuarios'">
              <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input
                  v-model="form.nombre"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                  v-model="form.email"
                  type="email"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">DNI</label>
                <input
                  v-model="form.dni_usuario"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Rol</label>
                <select v-model="form.rol" class="form-select" required>
                  <option value="usuario">Usuario</option>
                  <option value="administrador">Administrador</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Saldo</label>
                <input
                  v-model="form.saldo"
                  type="number"
                  min="0"
                  class="form-control"
                  required
                />
              </div>
            </div>

            <!-- ⇨ GÉNEROS ⇨ -->
            <div v-else-if="entidad === 'generos'">
              <div class="mb-3">
                <label class="form-label">Nombre Género</label>
                <input
                  v-model="form.nombre"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
            </div>

            <!-- ⇨ NOTICIAS ⇨ -->
            <div v-else-if="entidad === 'noticias'">
              <div class="mb-3">
                <label class="form-label">Título</label>
                <input
                  v-model="form.titulo"
                  type="text"
                  class="form-control"
                  required
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Imagen (URL o base64)</label>
                <input
                  v-model="form.imagen"
                  type="text"
                  class="form-control"
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Descripción (corta)</label>
                <textarea
                  v-model="form.descripcion"
                  class="form-control"
                  rows="2"
                  required
                ></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Cuerpo (texto completo)</label>
                <textarea
                  v-model="form.cuerpo"
                  class="form-control"
                  rows="4"
                  required
                ></textarea>
              </div>
            </div>

            <!-- Pie de modal con botones -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="onCancel">
                Cancelar
              </button>
              <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
                <span
                  v-if="isSubmitting"
                  class="spinner-border spinner-border-sm text-light"
                  role="status"
                ></span>
                <span v-else>Guardar</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </teleport>
</template>

<script setup>
import { reactive, ref, watch } from 'vue'
import { defineProps, defineEmits } from 'vue'
import { useGamesStore } from '../../stores/useGamesStore.js'
import { useUsersStore } from '../../stores/useUserStore.js'
import { useGenerosStore } from '../../stores/useGenerosStore.js'
import { useNoticiasStore } from '../../stores/useNoticiasStore.js'

const props = defineProps({
  entidad:   { type: String, required: true },
  visible:   { type: Boolean, default: false }
})
const emit = defineEmits(['saved', 'cancel'])

// Stores para crear cada entidad
const gamesStore    = useGamesStore()
const usersStore    = useUsersStore()
const genresStore   = useGenerosStore()
const noticiasStore = useNoticiasStore()

// Estado de envío
const isSubmitting = ref(false)

// Etiqueta según entidad
const labelEntidad = {
  juegos: 'Juegos',
  usuarios: 'Usuarios',
  generos: 'Géneros',
  noticias: 'Noticias'
}[props.entidad]

// Formulario reactivo con todos los campos posibles
const form = reactive({
  nombre:             '',
  desarrollador:      '',
  editor:             '',
  fecha_lanzamiento:  '',
  precio:             null,
  descuento:          null,
  genero:             '',
  plataforma:         '',
  email:              '',
  dni_usuario:        '',
  rol:                '',
  saldo:              null,
  titulo:             '',
  imagen:             '',
  descripcion:        '',
  cuerpo:             ''
})

// Resetear formulario cuando cambie la entidad
watch(
  () => props.entidad,
  () => {
    Object.keys(form).forEach((key) => {
      if (typeof form[key] === 'string') form[key] = ''
      else form[key] = null
    })
  }
)

// Bloquear/desbloquear scroll del body cuando el modal se abra/cierre
watch(
  () => props.visible,
  (vis) => {
    if (vis) {
      document.body.classList.add('no-scroll')
    } else {
      document.body.classList.remove('no-scroll')
    }
  }
)

// Envío del formulario
async function onSubmit() {
  isSubmitting.value = true
  try {
    if (props.entidad === 'juegos') {
      const payload = {
        nombre:            form.nombre,
        desarrollador:     form.desarrollador,
        editor:            form.editor,
        fecha_lanzamiento: form.fecha_lanzamiento,
        precio:            form.precio,
        descuento:         form.descuento,
        genero:            form.genero,
        plataforma:        form.plataforma
      }
      const nueva = await gamesStore.crearGame(payload)
      if (!nueva) throw new Error(gamesStore.error)
    }
    else if (props.entidad === 'usuarios') {
      const payload = {
        nombre:      form.nombre,
        email:       form.email,
        contrasena:  'dummy123', // puedes pedir otra vez la contraseña si hace falta
        dni_usuario: form.dni_usuario,
        rol:         form.rol,
        saldo:       form.saldo
      }
      const nuevo = await usersStore.createUser(payload)
      if (!nuevo) throw new Error(usersStore.error)
    }
    else if (props.entidad === 'generos') {
      const payload = { nombre: form.nombre }
      const nuevo = await genresStore.createGenre(payload)
      if (!nuevo) throw new Error(genresStore.error)
    }
    else if (props.entidad === 'noticias') {
      const payload = {
        titulo:      form.titulo,
        imagen:      form.imagen,
        descripcion: form.descripcion,
        cuerpo:      form.cuerpo
      }
      const nueva = await noticiasStore.crearNoticia(payload)
      if (!nueva) throw new Error(noticiasStore.error)
    }

    // Avisamos al padre de que se guardó
    emit('saved')
  } catch (err) {
    alert(err.message || 'Hubo un problema al crear')
  } finally {
    isSubmitting.value = false
  }
}

function onCancel() {
  emit('cancel')
}
</script>

<style>
/* 1) Evitar scroll en el body cuando el modal esté abierto */
body.no-scroll {
  overflow: hidden;
}

/* 2) Backdrop fijo para cubrir siempre toda la ventana visible */
.modal-backdrop {
  position: fixed; /* FIJO en la pantalla */
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;      /* centra verticalmente */
  justify-content: center;  /* centra horizontalmente */
  z-index: 1050;
}

/* 3) Contenedor del modal: lo limitamos en altura y permitimos scroll interno */
.modal-container {
  background-color: #1c1c1c;
  color: #fff;
  border-radius: 0.3rem;
  width: 90%;
  max-width: 500px;
  max-height: 80vh;   /* ocupa como máximo el 80% de la altura de la ventana */
  display: flex;
  flex-direction: column;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
}

/* 4) Header */
.modal-header {
  padding: 1rem;
  border-bottom: 1px solid #333;
}
.modal-title {
  margin: 0;
  font-family: 'Oswald', sans-serif;
  font-size: 1.25rem;
}

/* 5) Body con scroll interno si el formulario ocupa mucha altura */
.modal-body {
  padding: 1rem;
  overflow-y: auto;
  flex: 1; /* ocupa todo el espacio sobrante entre header y footer */
}

/* 6) Footer con botones */
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
