<template>
  <div v-if="rol === 'admin'">
    <NavbarAdmin />
  </div>

  <div v-if="rol === 'usuario'">
    <NavbarUsuario />
  </div>

  <div v-else>
    <NavbarInvitado />
  </div>

  <div v-if="rol === 'admin'">
    <p>Admin</p>
    <HeroCarouselAdmin :slides="heroSlides" />
    <BestGameCardsAdmin :games="bestGames" />
    <LatestNewsAdmin />
  </div>
  
  <div v-if="rol === 'usuario'">
    <p>UUARIO</p>
    <HeroCarouselUsuario :slides="heroSlides" />
    <BestGameCardsuuario :games="bestGames" />
    <LatestNewsUsuario />
  </div>

  <div v-else>
    <p>Invitado</p>
    <HeroCarouselInvitado :slides="heroSlides" />
    <BestGameCardsInvitado :games="bestGames" />
    <LatestNewsInvitado />
  </div>

  <FooterGeneral />
</template>

<script setup>
import { ref,computed } from 'vue'
import { useLoginStore } from '../stores/useLoginStore.js'
import FooterGeneral from '../components/Footer.vue'
import NavbarAdmin from '../components/Admin/Navbar.vue'
import NavbarUsuario from '../components/Usuario/Navbar.vue'
import NavbarInvitado from '../components/Invitado/Navbar.vue'
import { useRoute } from 'vue-router'

import HeroCarouselAdmin from '../components/Admin/Home/HeroCarousel.vue'
import BestGameCardsAdmin from '../components/Admin/Home/BestGameCards.vue'
import LatestNewsAdmin from '../components/Admin/Home/LatestNews.vue'

import HeroCarouselUsuario from '../components/Usuario/Home/HeroCarousel.vue'
import BestGameCardsuuario from '../components/Usuario/Home/BestGameCards.vue'
import LatestNewsUsuario from '../components/Usuario/Home/LatestNews.vue'

import HeroCarouselInvitado from '../components/Invitado/Home/HeroCarousel.vue'
import BestGameCardsInvitado from '../components/Invitado/Home/BestGameCards.vue'
import LatestNewsInvitado from '../components/Invitado/Home/LatestNews.vue'



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
    title: 'Uncharted 4: A Thief’s End',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 0
  },
  {
    id: 2,
    img: '/images/spiderman-portada.jpg',
    characterImg: '/images/spiderman-character.png',
    title: 'Spider-Man Remastered',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 200
  },
  {
    id: 3,
    img: '/images/ratchet-portada.png',
    characterImg: '/images/ratchet-character.png',
    title: 'Ratchet & Clank: Rift Apart',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 400
  },
  {
    id: 4,
    img: '/images/reddeadredemption2.png',
    characterImg: '/images/reddead-character.png',
    title: 'Red Dead Redemption 2',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 600
  },
  {
    id: 5,
    img: '/images/clairobscur-portada.jpg',
    characterImg: '/images/clair-character.avif',
    title: 'Clair Obscur: Expedition 33',
    price: '49.99€',
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
  },
  {
    id: 9,
    img: '/images/Uncharted-portada.webp',
    characterImg: '/images/nathan3.png',
    aos: 'fade-up',
    duration: 1200,
    delay: 1600
  },
  {
    id: 10,
    img: '/images/spiderman-portada.jpg',
    characterImg: '/images/spiderman-character.png',
    aos: 'fade-up',
    duration: 1200,
    delay: 1800
  },
  {
    id: 11,
    img: '/images/ratchet-portada.png',
    characterImg: '/images/ratchet-character.png',
    aos: 'fade-up',
    duration: 1200,
    delay: 2000
  },
  {
    id: 12,
    img: '/images/reddeadredemption2.png',
    characterImg: '/images/reddead-character.png',
    aos: 'fade-up',
    duration: 1200,
    delay: 2200
  },
  {
    id: 13,
    img: '/images/clairobscur-portada.jpg',
    characterImg: '/images/clair-character.avif',
    aos: 'fade-up',
    duration: 1200,
    delay: 2400
  },
  {
    id: 14,
    img: '/images/ratchet-portada.png',
    characterImg: '/images/ratchet-character.png',
    aos: 'fade-up',
    duration: 1200,
    delay: 2600
  },
  {
    id: 15,
    img: '/images/Uncharted-portada.webp',
    characterImg: '/images/nathan3.png',
    title: 'Uncharted 4: A Thief’s End',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 2800
  },
  {
    id: 16,
    img: '/images/spiderman-portada.jpg',
    characterImg: '/images/spiderman-character.png',
    title: 'Spider-Man Remastered',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 3000
  },
  {
    id: 17,
    img: '/images/ratchet-portada.png',
    characterImg: '/images/ratchet-character.png',
    title: 'Ratchet & Clank: Rift Apart',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 3200
  },
  {
    id: 18,
    img: '/images/reddeadredemption2.png',
    characterImg: '/images/reddead-character.png',
    title: 'Red Dead Redemption 2',
    price: '39.99€',
    aos: 'fade-up',
    duration: 1200,
    delay: 3400
  },
])

// 1) Obtén la instancia del store
const loginStore = useLoginStore()

// 2) Crea una “propiedad computada” para el rol
//    Si user es null, rol será null, por lo que caerá en el v-else (invitado)
const rol = computed(() => loginStore.rol)

// datos de noticias para el lightbox…
const newsData = { /* … */ }
const lightbox = ref(null)
function openLightbox(id) { lightbox.value.open(id) }
function onClose() { /* … */ }
</script>