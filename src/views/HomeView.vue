<template>

  <HeroCarousel :slides="heroSlides" />
  <BestGameCards :games="bestGames" />
  <NewsCard @open="openLightbox" />
  <Lightbox ref="lightbox" :items="newsData" @closed="onClose" />

</template>

<script setup>
import { ref } from 'vue'
import HeroCarousel from '../components/Home/HeroCarousel.vue'
import BestGameCards from '../components/Home/BestGameCards.vue'
import NewsCard from '../components/Home/NewsCard.vue'
import Lightbox from '../components/Home/Lightbox.vue'

const heroSlides = ref([
  { id: 1, img: '/images/stardewValleyPortada.png' },
  { id: 2, img: '/images/hadesPortada.jpg' },
  { id: 3, img: '/images/HollowKnightPortada.png' },
  { id: 4, img: '/images/balatroPortada.png' }
])

// Datos para “Mejores Juegos”
const bestGames = ref([
  {
    id: 1,
    img: '/images/Uncharted-portada.webp',
    characterImg: '/images/nathan3.png',
    aos: 'fade-up',
    duration: 1200,
    delay: 0
  },
  {
    id: 2,
    img: '/images/spiderman-portada.jpg',
    characterImg: '/images/spiderman-character.png',
    aos: 'fade-up',
    duration: 1200,
    delay: 200
  },
  {
    id: 3,
    img: '/images/ratchet-portada.png',
    characterImg: '/images/ratchet-character.png',
    aos: 'fade-up',
    duration: 1200,
    delay: 400
  },
  {
    id: 4,
    img: '/images/reddeadredemption2.png',
    characterImg: '/images/reddead-character.png',
    aos: 'fade-up',
    duration: 1200,
    delay: 600
  },
  {
    id: 5,
    img: '/images/clairobscur-portada.jpg',
    characterImg: '/images/clair-character.avif',
    aos: 'fade-up',
    duration: 1200,
    delay: 800
  },
  {
    id: 6,
    img: '/images/juego2.png',
    title: 'The Witcher 3: Wild Hunt',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 1000
  },
  {
    id: 7,
    img: '/images/juego3.png',
    title: 'The Witcher 3: Wild Hunt',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 1200
  },
  {
    id: 8,
    img: '/images/juego3.png',
    title: 'The Witcher 3: Wild Hunt',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 1400
  }
])

// datos de noticias para el lightbox…
const newsData = { /* … */ }
const lightbox = ref(null)
function openLightbox(id) { lightbox.value.open(id) }
function onClose() { /* … */ }
</script>