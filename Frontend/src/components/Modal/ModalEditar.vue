<template>
  <div v-if="visible" class="modal-backdrop" style="display: block; background-color: rgba(0, 0, 0, 0.6);">
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
            <form @submit.prevent="onSubmit">
              <!-- ⇨ JUEGOS ⇨ -->
              <div v-if="entidad === 'juegos'">
                <div class="mb-3">
                  <label class="form-label">Nombre del juego</label>
                  <input v-model="formJuego.nombre" type="text" class="form-control" placeholder="Ej: Super Juego"
                    required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Desarrollador</label>
                  <input v-model="formJuego.desarrollador" type="text" class="form-control" placeholder="Ej: MiStudio"
                    required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Editor</label>
                  <input v-model="formJuego.editor" type="text" class="form-control" placeholder="Ej: Grandes Juegos SA"
                    required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Fecha de lanzamiento</label>
                  <input v-model="formJuego.fecha_lanzamiento" type="date" class="form-control" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Precio</label>
                  <input v-model.number="formJuego.precio" type="number" min="0" class="form-control"
                    placeholder="Ej: 59.99" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Descuento (%)</label>
                  <input v-model.number="formJuego.descuento" type="number" min="0" max="100" class="form-control"
                    placeholder="Ej: 20" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Géneros</label>
                  <select v-model="selectedGenero" class="form-select" @change="onGeneroChange">
                    <option disabled value="">Selecciona un género...</option>
                    <option v-for="g in generosStore.genres" :key="g.id_genero" :value="g.id_genero"
                      :disabled="formJuego.generos.includes(g.id_genero)">
                      {{ g.nombre }}
                    </option>
                  </select>
                  <div class="form-text">Selecciona un género para añadirlo. Haz clic en un badge para quitarlo.</div>
                  <div v-if="formJuego.generos.length" class="mt-2">
                    <span class="badge bg-success me-1" v-for="id in formJuego.generos" :key="id" style="cursor:pointer"
                      @click="removeGenero(id)" title="Quitar">
                      {{generosStore.genres.find(g => g.id_genero === id)?.nombre || id}} &times;
                    </span>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Plataforma</label>
                  <input v-model="formJuego.plataforma" type="text" class="form-control"
                    placeholder="Ej: PC / PS5 / Xbox" required />
                </div>

                <!-- IMAGEN HORIZONTAL -->
                <div class="mb-4">
                  <label class="form-label fw-bold">Imagen Horizontal</label>
                  <div v-if="formImagenH.previewUrl" class="mb-2">
                    <img :src="formImagenH.previewUrl" alt="Horizontal actual" class="img-fluid rounded"
                      style="max-height: 150px; object-fit: cover;" />
                  </div>
                  <input type="file" accept="image/*" class="form-control" @change="onFileHChange" />
                  <div v-if="formImagenH.newFile" class="mt-1 text-white small">
                    ★ Nuevo archivo: {{ formImagenH.newFile.name }}
                  </div>
                </div>
                <!-- IMAGEN VERTICAL -->
                <div class="mb-4">
                  <label class="form-label fw-bold">Imagen Vertical</label>
                  <div v-if="formImagenV.previewUrl" class="mb-2">
                    <img :src="formImagenV.previewUrl" alt="Vertical actual" class="img-fluid rounded"
                      style="max-height: 150px; object-fit: cover;" />
                  </div>
                  <input type="file" accept="image/*" class="form-control" @change="onFileVChange" />
                  <div v-if="formImagenV.newFile" class="mt-1 text-white small">
                    ★ Nuevo archivo: {{ formImagenV.newFile.name }}
                  </div>
                </div>
                <!-- IMAGEN PERSONAJE -->
                <div class="mb-4">
                  <label class="form-label fw-bold">Imagen Personaje</label>
                  <div v-if="formImagenP.previewUrl" class="mb-2">
                    <img :src="formImagenP.previewUrl" alt="Personaje actual" class="img-fluid rounded"
                      style="max-height: 150px; object-fit: cover;" />
                  </div>
                  <input type="file" accept="image/*" class="form-control" @change="onFilePChange" />
                  <div v-if="formImagenP.newFile" class="mt-1 text-white small">
                    ★ Nuevo archivo: {{ formImagenP.newFile.name }}
                  </div>
                </div>
              </div>

              <!-- ⇨ USUARIOS ⇨ -->
              <div v-else-if="entidad === 'usuarios'">
                <div class="mb-3">
                  <label class="form-label">Nombre</label>
                  <input v-model="formUsuario.nombre" type="text" class="form-control" required />
                </div>
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input v-model="formUsuario.email" type="email" class="form-control" required />
                </div>
                <div class="mb-3">
                  <label class="form-label">DNI</label>
                  <!-- Hacemos el campo readonly en lugar de editable -->
                  <input v-model="formUsuario.dni_usuario" type="text" class="form-control" readonly />
                </div>
                <div class="mb-3">
                  <label class="form-label">Rol</label>
                  <select v-model="formUsuario.rol" class="form-select" required>
                    <option value="usuario">Usuario</option>
                    <option value="administrador">Administrador</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Saldo</label>
                  <input v-model.number="formUsuario.saldo" type="number" min="0" class="form-control" required />
                </div>
              </div>

              <!-- ⇨ GÉNEROS ⇨ -->
              <div v-else-if="entidad === 'generos'">
                <div class="mb-3">
                  <label class="form-label">Nombre Género</label>
                  <input v-model="formGenero.nombre" type="text" class="form-control" required />
                </div>
                <div v-if="urlImagenActual" class="mb-2">
                  <img :src="urlImagenActual" alt="Imagen actual de género" class="img-fluid rounded"
                    style="max-height: 200px; object-fit: cover;" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Cambiar Imagen de Género</label>
                  <input type="file" accept="image/*" class="form-control" @change="onFileGeneroChange" />
                  <div v-if="fileGenero" class="mt-2 text-white">
                    ⚙️ Archivo seleccionado: {{ fileGenero.name }}
                  </div>
                </div>
              </div>
              <!-- ⇨ NOTICIAS ⇨ -->
              <div v-else-if="entidad === 'noticias'">
                <div class="mb-3">
                  <label class="form-label">Título</label>
                  <input v-model="formNoticia.titulo" type="text" class="form-control" required />
                </div>
                <!-- PORTADA -->
                <div class="mb-3">
                  <label class="form-label">Cambiar Portada</label>
                  <div v-if="formNoticia.portada" class="mb-2">
                    <img :src="formNoticia.portada" alt="Portada actual" class="img-fluid rounded"
                      style="max-height: 150px; object-fit: cover;" />
                  </div>
                  <input type="file" accept="image/*" class="form-control" @change="onFilePortadaChange" />
                </div>
                <!-- LIGHTBOX -->
                <div class="mb-3">
                  <label class="form-label">Cambiar Lightbox</label>
                  <div v-if="formNoticia.lightbox" class="mb-2">
                    <img :src="formNoticia.lightbox" alt="Lightbox actual" class="img-fluid rounded"
                      style="max-height: 150px; object-fit: cover;" />
                  </div>
                  <input type="file" accept="image/*" class="form-control" @change="onFileLightboxChange" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Descripción (corta)</label>
                  <textarea v-model="formNoticia.descripcion" class="form-control" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label">Cuerpo (texto completo)</label>
                  <textarea v-model="formNoticia.cuerpo" class="form-control" rows="4" required></textarea>
                </div>
              </div>

              <!-- Bloque dinámico para cualquier entidad -->
              <div v-else>
                <div v-for="(valor, clave) in props.itemActual" :key="clave" class="mb-3">
                  <label class="form-label">{{ clave }}</label>
                  <input v-model="props.itemActual[clave]" :type="typeof valor === 'number' ? 'number' : 'text'"
                    class="form-control"
                    :readonly="clave === 'id' || clave === 'id_juego' || clave === 'dni_usuario'" />
                </div>
              </div>

              <!-- Pie de modal con botones -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="onCancel">Cancelar</button>
                <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
                  <span v-if="isSubmitting" class="spinner-border spinner-border-sm text-light" role="status"></span>
                  <span v-else>Guardar cambios</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, reactive, computed, watch } from 'vue'
import { useGamesStore } from '../../stores/useGamesStore.js'
import { useUsersStore } from '../../stores/useUserStore.js'
import { useGenerosStore } from '../../stores/useGenerosStore.js'
import { useNoticiasStore } from '../../stores/useNoticiasStore.js'
import { useJuegoImagenesStore } from '../../stores/useJuegoImagenesStore.js'

const props = defineProps({
  entidad: { type: String, required: true },
  visible: { type: Boolean, required: true },
  itemActual: { type: Object, required: true }  // Objeto a editar (juego, usuario, etc)
})
const emit = defineEmits(['saved', 'cancel'])

// ────────────────────────────────────────────────────────────
// 1) Instanciar cada store
// ────────────────────────────────────────────────────────────
const gamesStore = useGamesStore()
const usersStore = useUsersStore()
const generosStore = useGenerosStore()
const noticiasStore = useNoticiasStore()
const juegoImagenesStore = useJuegoImagenesStore()

// ────────────────────────────────────────────────────────────
// 2) Formularios iniciales (reactive) para cada entidad
// ────────────────────────────────────────────────────────────
const formJuego = reactive({
  nombre: '',
  desarrollador: '',
  editor: '',
  fecha_lanzamiento: '',
  precio: null,
  descuento: 0,
  generos: [],
  plataforma: ''
})

const selectedGenero = ref('')

function removeGenero(id) {
  formJuego.generos = formJuego.generos.filter(gid => gid !== id)
}

function onGeneroChange() {
  if (
    selectedGenero.value &&
    !formJuego.generos.includes(selectedGenero.value)
  ) {
    formJuego.generos.push(selectedGenero.value)
  }
  selectedGenero.value = ''
}

// Tres objetos reactivos para las 3 categorías de imagen de juego:
const formImagenH = reactive({
  id_imagen: null,
  previewUrl: '',
  newFile: null,
  base64: ''
})
const formImagenV = reactive({
  id_imagen: null,
  previewUrl: '',
  newFile: null,
  base64: ''
})
const formImagenP = reactive({
  id_imagen: null,
  previewUrl: '',
  newFile: null,
  base64: ''
})

const formUsuario = reactive({
  nombre: '',
  email: '',
  dni_usuario: '',
  rol: '',
  saldo: null
})

const formGenero = reactive({
  nombre: '',
  imagen: '' // base64
})

// Para mostrar la imagen actual del género (longblob → URL.createObjectURL):
const urlImagenActual = ref('')

// Para almacenar el nuevo File de género (si el usuario elige subir uno nuevo)
const fileGenero = ref(null)

const formNoticia = reactive({
  titulo: '',
  portada: '',    // Base64 data URL (o cadena vacía)
  lightbox: '',
  descripcion: '',
  cuerpo: ''
})
// Para detectar si el usuario escogió un archivo nuevo en noticias:
const filePortada = ref(null)
const fileLightbox = ref(null)

const formImagen = reactive({
  id_imagen: null,
  id_juego: null,
  categoria: '',
  imagen: ''  // aquí va la cadena Base64
})

// ────────────────────────────────────────────────────────────
// 3) Estado adicional
// ────────────────────────────────────────────────────────────
const isSubmitting = ref(false)

const entidadLabel = computed(() => {
  switch (props.entidad) {
    case 'juegos': return 'Juego'
    case 'usuarios': return 'Usuario'
    case 'generos': return 'Género'
    case 'noticias': return 'Noticia'
    case 'juegoImagenes': return 'Imagen de Juego'
    default: return ''
  }
})

// ────────────────────────────────────────────────────────────
// 4) Cuando cambie `itemActual` o el modal se abra, poblar el formulario
// ────────────────────────────────────────────────────────────
watch(
  () => [props.itemActual, props.visible],
  ([nuevoItem, estaVisible]) => {
    if (!estaVisible || !nuevoItem) return

    if (props.entidad === 'juegos') {
      Object.assign(formJuego, {
        nombre: nuevoItem.nombre || '',
        desarrollador: nuevoItem.desarrollador || '',
        editor: nuevoItem.editor || '',
        fecha_lanzamiento: nuevoItem.fecha_lanzamiento?.split('T')[0] || '',
        precio: nuevoItem.precio ?? null,
        descuento: nuevoItem.descuento ?? 0,
        generos: (nuevoItem.generos || []).map(g => g.id_genero), // <-- array de IDs
        plataforma: nuevoItem.plataforma || ''
      })

      // Reiniciar cada objeto de imagen
      formImagenH.id_imagen = null
      formImagenH.previewUrl = ''
      formImagenH.newFile = null
      formImagenH.base64 = ''
      formImagenV.id_imagen = null
      formImagenV.previewUrl = ''
      formImagenV.newFile = null
      formImagenV.base64 = ''
      formImagenP.id_imagen = null
      formImagenP.previewUrl = ''
      formImagenP.newFile = null
      formImagenP.base64 = ''

      // Llenar formImagenH/V/P buscando en nuevoItem.imagenes
      for (const img of (nuevoItem.imagenes || [])) {
        const dataUrl = img.imagen
          ? `data:${img.mime_type || 'image/jpeg'};base64,${img.imagen}`
          : ''
        if (img.categoria === 'horizontal') {
          formImagenH.id_imagen = img.id_imagen
          formImagenH.previewUrl = dataUrl
          formImagenH.base64 = img.imagen || ''
        }
        else if (img.categoria === 'vertical') {
          formImagenV.id_imagen = img.id_imagen
          formImagenV.previewUrl = dataUrl
          formImagenV.base64 = img.imagen || ''
        }
        else if (img.categoria === 'personaje') {
          formImagenP.id_imagen = img.id_imagen
          formImagenP.previewUrl = dataUrl
          formImagenP.base64 = img.imagen || ''
        }
      }
    }
    else if (props.entidad === 'usuarios') {
      Object.assign(formUsuario, {
        nombre: nuevoItem.nombre || '',
        email: nuevoItem.email || '',
        dni_usuario: nuevoItem.dni_usuario || '',
        rol: nuevoItem.rol || '',
        saldo: nuevoItem.saldo ?? 0
      })
    }
    else if (props.entidad === 'generos') {
      formGenero.nombre = nuevoItem.nombre || ''
      if (typeof nuevoItem.imagen === 'string' && nuevoItem.imagen.length > 0) {
        formGenero.imagen = nuevoItem.imagen
        // Usa image/jpeg por defecto si no hay mime_type
        urlImagenActual.value = `data:${nuevoItem.mime_type || 'image/jpeg'};base64,${nuevoItem.imagen}`
        console.log('Imagen de género cargada:', urlImagenActual.value);

      } else {
        urlImagenActual.value = ''
        formGenero.imagen = ''
      }
      fileGenero.value = null
    }
    else if (props.entidad === 'noticias') {
      formNoticia.titulo = nuevoItem.titulo || ''
      formNoticia.descripcion = nuevoItem.descripcion || ''
      formNoticia.cuerpo = nuevoItem.cuerpo || ''
      if (nuevoItem.portada) {
        formNoticia.portada = `data:${nuevoItem.mime_type_portada || 'image/jpeg'};base64,${nuevoItem.portada}`
      } else {
        formNoticia.portada = ''
      }
      if (nuevoItem.lightbox) {
        formNoticia.lightbox = `data:${nuevoItem.mime_type_lightbox || 'image/jpeg'};base64,${nuevoItem.lightbox}`
      } else {
        formNoticia.lightbox = ''
      }
      filePortada.value = null
      fileLightbox.value = null
    }
    else if (props.entidad === 'juegoImagenes') {
      Object.assign(formImagen, {
        id_imagen: nuevoItem.id_imagen,
        id_juego: nuevoItem.id_juego,
        categoria: nuevoItem.categoria,
        imagen: nuevoItem.imagen
          ? `data:${nuevoItem.mime_type || 'image/jpeg'};base64,${nuevoItem.imagen}`
          : ''
      })
    }
  }
)

// ────────────────────────────────────────────────────────────
// Utilidad para extraer base64 puro
// ────────────────────────────────────────────────────────────
function dataUrlToBase64(dataUrl) {
  if (!dataUrl) return ''
  const parts = dataUrl.split(',')
  return parts.length > 1 ? parts[1] : dataUrl
}

// ────────────────────────────────────────────────────────────
// 5) Funciones para manejar nuevos archivos de “Juego”
// ────────────────────────────────────────────────────────────
function fileToBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader()
    reader.onload = () => resolve(reader.result)
    reader.onerror = err => reject(err)
    reader.readAsDataURL(file)
  })
}

async function onFileHChange(event) {
  const file = event.target.files[0] || null
  if (!file) {
    formImagenH.newFile = null
    formImagenH.base64 = ''
    return
  }
  formImagenH.newFile = file
  const base64 = await fileToBase64(file)
  formImagenH.previewUrl = base64
  formImagenH.base64 = dataUrlToBase64(base64)
}

async function onFileVChange(event) {
  const file = event.target.files[0] || null
  if (!file) {
    formImagenV.newFile = null
    formImagenV.base64 = ''
    return
  }
  formImagenV.newFile = file
  const base64 = await fileToBase64(file)
  formImagenV.previewUrl = base64
  formImagenV.base64 = dataUrlToBase64(base64)
}

async function onFilePChange(event) {
  const file = event.target.files[0] || null
  if (!file) {
    formImagenP.newFile = null
    formImagenP.base64 = ''
    return
  }
  formImagenP.newFile = file
  const base64 = await fileToBase64(file)
  formImagenP.previewUrl = base64
  formImagenP.base64 = dataUrlToBase64(base64)
}

async function onFileGeneroChange(event) {
  const file = event.target.files[0] || null
  fileGenero.value = file
  if (!file) {
    formGenero.imagen = ''
    return
  }
  const base64 = await fileToBase64(file)
  formGenero.imagen = dataUrlToBase64(base64)
  urlImagenActual.value = base64
}

async function onFilePortadaChange(event) {
  const file = event.target.files[0]
  if (!file) {
    filePortada.value = null
    formNoticia.portada = ''
    return
  }
  filePortada.value = file
  const base64 = await fileToBase64(file)
  formNoticia.portada = base64
}

async function onFileLightboxChange(event) {
  const file = event.target.files[0]
  if (!file) {
    fileLightbox.value = null
    formNoticia.lightbox = ''
    return
  }
  fileLightbox.value = file
  const base64 = await fileToBase64(file)
  formNoticia.lightbox = base64
}

// ────────────────────────────────────────────────────────────
// 7) Enviar formulario
// ────────────────────────────────────────────────────────────
async function onSubmit() {
  isSubmitting.value = true

  try {
    if (props.entidad === 'juegos') {
      if (
        !formJuego.nombre.trim() ||
        !formJuego.desarrollador.trim() ||
        !formJuego.editor.trim() ||
        !formJuego.fecha_lanzamiento ||
        formJuego.precio === null ||
        !formJuego.generos.length ||
        !formJuego.plataforma.trim()
      ) {
        throw new Error('Completa todos los campos del juego.')
      }

      // Actualizar datos de texto del juego
      const actualizadoJuego = await gamesStore.actualizarGame(
        props.itemActual.id_juego,
        {
          nombre: formJuego.nombre.trim(),
          desarrollador: formJuego.desarrollador.trim(),
          editor: formJuego.editor.trim(),
          fecha_lanzamiento: formJuego.fecha_lanzamiento,
          precio: formJuego.precio,
          descuento: formJuego.descuento,
          generos: formJuego.generos, // <-- array de IDs
          plataforma: formJuego.plataforma.trim()
        }
      )
      if (!actualizadoJuego) {
        throw new Error(gamesStore.error || 'Error al actualizar el juego.')
      }

      // HORIZONTAL
      if (formImagenH.newFile instanceof File) {
        const payload = {
          id_juego: props.itemActual.id_juego,
          categoria: 'horizontal',
          imagen: formImagenH.base64
        }
        // Eliminar TODAS las imágenes antiguas de esta categoría
        const anteriores = (props.itemActual.imagenes || []).filter(img => img.categoria === 'horizontal')
        console.log(anteriores);

        for (const anterior of anteriores) {
          if (anterior.id_imagen) {
            await juegoImagenesStore.eliminarImagen(anterior.id_imagen)
          }
        }
        // Subir la nueva imagen
        const resH = await juegoImagenesStore.subirImagen(payload)
        if (!resH) {
          throw new Error(juegoImagenesStore.error || 'Error al crear imagen horizontal.')
        }
      }

      // VERTICAL
      if (formImagenV.newFile instanceof File) {
        const payload = {
          id_juego: props.itemActual.id_juego,
          categoria: 'vertical',
          imagen: formImagenV.base64
        }
        const anteriores = (props.itemActual.imagenes || []).filter(img => img.categoria === 'vertical')
        for (const anterior of anteriores) {
          if (anterior.id_imagen) {
            await juegoImagenesStore.eliminarImagen(anterior.id_imagen)
          }
        }
        const resV = await juegoImagenesStore.subirImagen(payload)
        if (!resV) {
          throw new Error(juegoImagenesStore.error || 'Error al crear imagen vertical.')
        }
      }

      // PERSONAJE
      if (formImagenP.newFile instanceof File) {
        const payload = {
          id_juego: props.itemActual.id_juego,
          categoria: 'personaje',
          imagen: formImagenP.base64
        }
        const anteriores = (props.itemActual.imagenes || []).filter(img => img.categoria === 'personaje')
        for (const anterior of anteriores) {
          if (anterior.id_imagen) {
            await juegoImagenesStore.eliminarImagen(anterior.id_imagen)
          }
        }
        const resP = await juegoImagenesStore.subirImagen(payload)
        if (!resP) {
          throw new Error(juegoImagenesStore.error || 'Error al crear imagen de personaje.')
        }
      }
    }
    else if (props.entidad === 'usuarios') {
      if (
        !formUsuario.nombre.trim() ||
        !formUsuario.email.trim() ||
        !formUsuario.dni_usuario.trim() ||
        !formUsuario.rol.trim() ||
        formUsuario.saldo === null
      ) {
        throw new Error('Completa todos los campos del usuario.')
      }
      const actualizado = await usersStore.updateUserByDni(
        props.itemActual.dni_usuario,
        {
          nombre: formUsuario.nombre.trim(),
          email: formUsuario.email.trim(),
          dni_usuario: formUsuario.dni_usuario.trim(),
          rol: formUsuario.rol.trim(),
          saldo: formUsuario.saldo
        }
      )
      if (!actualizado) {
        throw new Error(usersStore.error || 'Error al actualizar el usuario.')
      }
    }
    else if (props.entidad === 'generos') {
      if (!formGenero.nombre.trim() || !formGenero.imagen) {
        throw new Error('Completa el nombre y la imagen del género.')
      }
      const payload = {
        nombre: formGenero.nombre.trim(),
        imagen: formGenero.imagen
      }
      const respuesta = await generosStore.updateGenre(
        props.itemActual.id_genero,
        payload
      )
      if (!respuesta) {
        throw new Error(generosStore.error || 'Error al actualizar el género.')
      }
    }
    else if (props.entidad === 'noticias') {
      if (
        !formNoticia.titulo.trim() ||
        !formNoticia.descripcion.trim() ||
        !formNoticia.cuerpo.trim()
      ) {
        throw new Error('Completa todos los campos de la noticia.')
      }
      if (!formNoticia.portada) {
        throw new Error('Debe existir una portada (o seleccione una nueva).')
      }
      if (!formNoticia.lightbox) {
        throw new Error('Debe existir un lightbox (o seleccione uno nuevo).')
      }
      const payload = {
        titulo: formNoticia.titulo.trim(),
        portada: dataUrlToBase64(formNoticia.portada),
        lightbox: dataUrlToBase64(formNoticia.lightbox),
        descripcion: formNoticia.descripcion.trim(),
        cuerpo: formNoticia.cuerpo.trim()
      }
      const actualizado = await noticiasStore.actualizarNoticia(
        props.itemActual.id_noticia,
        payload
      )
      if (!actualizado) {
        throw new Error(noticiasStore.error || 'Error al actualizar la noticia.')
      }
    }
    else if (props.entidad === 'juegoImagenes') {
      if (
        !formImagen.id_juego ||
        !formImagen.categoria.trim() ||
        !formImagen.imagen.trim()
      ) {
        throw new Error('Completa todos los campos de la imagen de juego.')
      }
      const payload = {
        id_juego: formImagen.id_juego,
        categoria: formImagen.categoria.trim(),
        imagen: dataUrlToBase64(formImagen.imagen)
      }
      const actualizado = await juegoImagenesStore.actualizarImagen(
        formImagen.id_imagen,
        payload
      )
      if (!actualizado) {
        throw new Error(juegoImagenesStore.error || 'Error al actualizar la imagen.')
      }
    }

    emit('saved')
  }
  catch (err) {
    alert(err.message || 'Hubo un error al actualizar.')
  }
  finally {
    isSubmitting.value = false
  }
}

function onCancel() {
  emit('cancel')
}
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
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
