<template>

    <HeroCarousel :slides="heroSlides" />
    <BestGameCards />
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

// datos de noticias para el lightbox…
const newsData = { /* … */ }
const lightbox = ref(null)
function openLightbox(id) { lightbox.value.open(id) }
function onClose() { /* … */ }
</script>