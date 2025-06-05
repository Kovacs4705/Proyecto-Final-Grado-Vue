<!-- src/views/NoticiasView.vue -->
<template>
  <!-- Sección Noticias de Hoy -->
   <div class="container mt-3">
     <section class="section-todays-news">
       <TodaysNews :featured-news="noticiasStore.featuredNews" :small-news="noticiasStore.smallNews" />
     </section>
   </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import AOS from 'aos'
import 'aos/dist/aos.css'
import { useNoticiasStore } from '../stores/useNoticiasStore.js'
import TodaysNews from '../components/Noticias/TodaysNews.vue'

const noticiasStore = useNoticiasStore()

// Cargar noticias al montar el componente
onMounted(() => {
  AOS.init()
  noticiasStore.fetchNoticias({ pagina: 1, registrosPorPagina: 9 })
})

// Computed para featured y small news
const featuredNews = computed(() => noticiasStore.featuredNews)
const smallNews = computed(() => noticiasStore.smallNews)
</script>

<style scoped>
.noticias-view {
  max-width: 1200px;
  margin: 0 auto;
  padding-bottom: 4rem;
}

/* Separador */
.separator {
  border: none;
  height: 1px;
  background-color: rgba(255, 255, 255, 0.2);
}

/* Título sección Noticias Generales */
.general-title {
  font-family: "Oswald", sans-serif;
  font-size: 2rem;
  color: #ffffff;
  position: relative;
}

.general-title::after {
  content: "";
  position: absolute;
  bottom: -8px;
  left: 50%;
  transform: translateX(-50%);
  width: 6%;
  height: 3px;
  background-color: #39ff14;
}

/* Ajustes de responsive para cards */
.section-general-news .col-md-4 {
  margin-bottom: 2rem;
}

/* Margen superior para Noticias de Hoy */
.section-todays-news {
  margin-top: 2rem;
}

/* Colocar espacio debajo de cada tarjeta */
.general-news-card {
  background-color: transparent;
}
</style>
