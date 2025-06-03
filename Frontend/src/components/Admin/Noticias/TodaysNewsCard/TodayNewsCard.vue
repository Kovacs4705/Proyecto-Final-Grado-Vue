<template>
  <div class="todays-news-card mb-4">
    <div class="row align-items-center">
      <!-- Imagen de la noticia -->
      <div class="col-md-4">
        <img
          :src="image"
          alt="Imagen de la noticia"
          class="img-fluid rounded news-image"
          @click="openLightbox"
        />
      </div>

      <!-- Texto de la noticia (título, descripción, botón) -->
      <div class="col-md-8 text-start textoNoticia">
        <h3 class="news-title">{{ title }}</h3>
        <p class="news-description">{{ description }}</p>
        <button class="btn btn-success rounded-pill px-4" @click="openLightbox">
          Leer más
        </button>
      </div>
    </div>

    <!-- Lightbox: se muestra cuando isLightboxOpen == true -->
    <div class="lightbox" v-if="isLightboxOpen" @click.self="closeLightbox">
      <div class="lightbox-content">
        <span class="lightbox-close" @click="closeLightbox">&times;</span>
        <img :src="image" alt="Imagen ampliada" class="lightbox-img" />
        <div class="lightbox-text">
          <h3>{{ title }}</h3>
          <p>{{ description }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TodaysNewsCard',
  props: {
    title: {
      type: String,
      required: true
    },
    description: {
      type: String,
      required: true
    },
    image: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      isLightboxOpen: false
    };
  },
  methods: {
    openLightbox() {
      document.body.classList.add('no-scroll');
      this.isLightboxOpen = true;
    },
    closeLightbox() {
      document.body.classList.remove('no-scroll');
      this.isLightboxOpen = false;
    }
  }
};
</script>

<style scoped>
.todays-news-card {
  /* Separación inferior entre tarjetas */
  margin-bottom: 1.5rem;
}

/* Asegurarse de que la imagen ocupe todo el ancho del contenedor */
.news-image {
  width: 100%;
  cursor: pointer;
  transition: transform 0.3s ease;
}
.news-image:hover {
  transform: scale(1.02);
}

/* Título y descripción dentro de la tarjeta */
.news-title {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
  color: #ffffff;
}
.news-description {
  font-size: 1rem;
  color: #dddddd;
  margin-bottom: 1rem;
}

/* --------------------------------------------------------------------------
   ESTILOS LIGHTBOX
   -------------------------------------------------------------------------- */

/* Capa semitransparente que cubre toda la pantalla */
.lightbox {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.9);
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: auto;
}

/* Contenido del lightbox: imagen + texto + botón de cierre */
.lightbox-content {
  position: relative;
  max-width: 80%;
  max-height: 80%;
  background: transparent;
  color: white;
  text-align: center;
  padding: 1rem;
  overflow: auto;
  border-radius: 10px;
}

/* Imagen dentro del lightbox */
.lightbox-img {
  max-width: 100%;
  max-height: 60vh;
  border-radius: 10px;
  margin-bottom: 1rem;
}

/* Texto dentro del lightbox */
.lightbox-text h3 {
  margin-bottom: 0.5rem;
  font-size: 1.75rem;
  color: #ffffff;
}
.lightbox-text p {
  font-size: 1rem;
  line-height: 1.5;
  color: #cccccc;
}

/* Botón de cerrar (equis) */
.lightbox-close {
  position: absolute;
  top: 0.5rem;
  right: 1rem;
  font-size: 2rem;
  color: white;
  cursor: pointer;
  z-index: 10000;
  transition: color 0.2s ease;
}
.lightbox-close:hover {
  color: #39ff14;
}

/* Desactivar scroll del body cuando se abre el lightbox */
body.no-scroll {
  overflow: hidden;
}
</style>
