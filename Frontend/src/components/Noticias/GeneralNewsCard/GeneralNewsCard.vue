<template>
  <div class="general-news-card">
    <!-- Imagen de la noticia (al hacer clic, abre el lightbox) -->
    <img
      :src="image"
      alt="Imagen Noticia"
      class="img-fluid rounded news-image"
      @click="openLightbox"
    />

    <!-- Título y descripción -->
    <h4 class="news-title">{{ title }}</h4>
    <p class="news-description">{{ description }}</p>

    <!-- Lightbox -->
    <div class="lightbox" v-if="isLightboxOpen" @click.self="closeLightbox">
      <div class="lightbox-content">
        <span class="lightbox-close" @click="closeLightbox">&times;</span>
        <img :src="image" alt="Imagen ampliada" class="lightbox-img" />
        <div class="lightbox-text">
          <h4>{{ title }}</h4>
          <p>{{ description }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "GeneralNewsCard",
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
      document.body.classList.add("no-scroll");
      this.isLightboxOpen = true;
    },
    closeLightbox() {
      document.body.classList.remove("no-scroll");
      this.isLightboxOpen = false;
    }
  }
};
</script>

<style scoped>
.general-news-card {
  text-align: left;
  margin-bottom: 2rem;
}

/* Imagen de la noticia */
.news-image {
  width: 80%;
  cursor: pointer;
  transition: transform 0.3s ease;
  display: block;
  margin-bottom: 0.5rem;
}
.news-image:hover {
  transform: scale(1.02);
}

/* Título */
.news-title {
  font-size: 1.25rem;
  color: #ffffff;
  margin-bottom: 0.5rem;
}

/* Descripción */
.news-description {
  font-size: 0.95rem;
  color: #cccccc;
  line-height: 1.4;
  margin-bottom: 1rem;
}

/* --------------------------------------------------------------------------
   ESTILOS LIGHTBOX (idénticos a los usados en TodaysNewsCard)
   -------------------------------------------------------------------------- */

/* Overlay oscuro */
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

/* Contenido centrado del lightbox */
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

/* Imagen ampliada dentro del lightbox */
.lightbox-img {
  max-width: 100%;
  max-height: 60vh;
  border-radius: 10px;
  margin-bottom: 1rem;
}

/* Título y descripción dentro del lightbox */
.lightbox-text h4 {
  font-size: 1.5rem;
  color: #ffffff;
  margin-bottom: 0.5rem;
}
.lightbox-text p {
  font-size: 1rem;
  color: #dddddd;
  line-height: 1.5;
}

/* Botón de cierre (equis) */
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

/* Evitar scroll de la página cuando el lightbox está abierto */
body.no-scroll {
  overflow: hidden;
}
</style>
