<template>
    <Navbar />
    <HeroCarousel :slides="heroSlides" />
    <BestGameCards />
    <NewsCard @open="openLightbox" />
    <Lightbox ref="lightbox" :items="newsData" @closed="onClose" />
    <Footer />

</template>

<script setup>
    import { ref } from 'vue'
    import Navbar from '../components/Navbar.vue'
    import Footer from '../components/Footer.vue'
    import HeroCarousel from '../components/Home/HeroCarousel.vue'
    import BestGameCards from '../components/Home/BestGameCards.vue'
    import NewsCard from '../components/Home/NewsCard.vue'
    import Lightbox from '../components/Home/Lightbox.vue'

    const heroSlides = ref([
        { id: 1, img: '/src/assets/images/stardewValleyPortada.png' },
        { id: 2, img: '/src/assets/images/hadesPortada.jpg' },
        { id: 3, img: '/src/assets/images/HollowKnightPortada.png' },
        { id: 4, img: '/src/assets/images/balatroPortada.png' }
    ])

    // datos de noticias para el lightbox…
    const newsData = { /* … */ }
    const lightbox = ref(null)
    function openLightbox(id) { lightbox.value.open(id) }
    function onClose() { /* … */ }
</script>