<template>
    <section class="hero-carousel mt-3">
        <div class="swiper-container hero-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="slide in slides" :key="slide.id">
                    <img :src="slide.img" alt="" class="img-fluid rounded" />
                </div>
            </div>
            <!-- Navegación -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>
</template>

<script setup>
import { onMounted } from 'vue'
import Swiper from 'swiper/bundle'
import 'swiper/css/bundle'

// Registrar módulos que usaremos
Swiper.use([Navigation, Autoplay])

// Definimos la lista de slides via props
const props = defineProps({
    slides: {
        type: Array,
        default: () => []
    }
})

onMounted(() => {
    new Swiper('.hero-swiper', {
        // Muestra 1.5 slides para ver parcialmente el siguiente
        slidesPerView: 1.5,
        spaceBetween: 10,
        centeredSlides: true,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false
        },
        navigation: {
            prevEl: '.hero-swiper .swiper-button-prev',
            nextEl: '.hero-swiper .swiper-button-next'
        }
    })
})
</script>

<style scoped>
.hero-carousel {
    width: 100%;
}

/* Contenedor del swiper */
.hero-swiper {
    width: 100%;
    overflow: hidden;
    box-sizing: border-box;
}

/* Cada slide */
.hero-swiper .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Imagen dentro de la slide */
.hero-swiper .swiper-slide img {
    width: 100%;
    border-radius: 10px;
    display: block;
}

/* Botones de navegación */
.hero-swiper .swiper-button-prev,
.hero-swiper .swiper-button-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: #39ff14;
    color: #000;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;
}

/* Posicionamiento de las flechas */
.hero-swiper .swiper-button-prev {
    left: 10px;
}

.hero-swiper .swiper-button-next {
    right: 10px;
}

/* Ocultar los pseudo-elementos por defecto de Swiper */
.hero-swiper .swiper-button-prev::after,
.hero-swiper .swiper-button-next::after {
    display: none;
}

/* Añadir iconos */
.hero-swiper .swiper-button-prev:before {
    content: '←';
    font-size: 20px;
}

.hero-swiper .swiper-button-next:before {
    content: '→';
    font-size: 20px;
}
</style>