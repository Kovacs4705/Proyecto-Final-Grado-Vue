<template>
  <div>
    <HeroCarousel :slides="heroSlides" />
    <BestGameCards :games="bestGames" />
    <LatestNews :news="latestNews" />
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useGamesStore } from '../stores/useGamesStore.js'
import { useNoticiasStore } from '../stores/useNoticiasStore.js'

import HeroCarousel from '../components/Home/HeroCarousel.vue'
import BestGameCards from '../components/Home/BestGameCards.vue'
import LatestNews from '../components/Home/LatestNews.vue'

// Stores
const gamesStore = useGamesStore()
const noticiasStore = useNoticiasStore()

// Cargar datos al montar
onMounted(() => {
  gamesStore.fetchGames({ pagina: 1, registrosPorPagina: 20 })
  noticiasStore.fetchNoticias({ pagina: 1, registrosPorPagina: 10 })
})

// Computed para los componentes
const heroSlides = computed(() =>
  (gamesStore.games || []).slice(0, 4).map(j => ({
    id: j.id_juego,
    img: j.juego_imagens?.find(img => img.categoria === 'horizontal')
      ? `data:image/jpeg;base64,${j.juego_imagens.find(img => img.categoria === 'horizontal').imagen}`
      : '/images/default.png'
  }))
)

const bestGames = computed(() =>
  (gamesStore.games || []).slice(0, 8).map(j => ({
    id: j.id_juego,
    img: j.juego_imagens?.find(img => img.categoria === 'vertical')
      ? `data:image/jpeg;base64,${j.juego_imagens.find(img => img.categoria === 'vertical').imagen}`
      : '/images/default.png',
    title: j.nombre,
    price: j.precio ? `${j.precio}€` : '',
    // Puedes agregar más campos si tu card los necesita
  }))
)

const latestNews = computed(() =>
  (noticiasStore.noticias || []).slice(0, 2).map(n => ({
    id: n.id,
    title: n.titulo,
    description: n.descripcion,
    image: n.portada
      ? `data:${n.mime_type_portada || "image/jpeg"};base64,${n.portada}`
      : "",
    body: n.cuerpo,
    lightbox: n.lightbox
      ? `data:${n.mime_type_lightbox || "image/jpeg"};base64,${n.lightbox}`
      : "",
  }))
)
</script>