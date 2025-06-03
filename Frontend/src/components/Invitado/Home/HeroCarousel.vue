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
// Swiper.use([Navigation, Autoplay])

// Definimos la lista de slides via props
const props = defineProps({
    slides: {
        type: Array,
        default: () => []
    }
})
props.slides.forEach(slide => {
    console.log(slide.id, slide.img);
});



onMounted(() => {
    new Swiper('.hero-swiper', {
        // Muestra 1.5 slides para ver parcialmente el siguiente
        slidesPerView: 1.5,
        spaceBetween: 0,
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


/* Contenedor principal del swiper */
.hero-swiper {
  top: 10%;
  position: relative;
  display: block;
  margin: 0 auto;
  width: clamp(90%, 1600px, 100%);
  /* - En móviles: 90% del viewport
     - En pantallas medias: hasta 1600px
     - Jamás pasará de 100% del viewport */
  box-sizing: border-box;
}


/* Wrapper de slides */
.hero-swiper .swiper-wrapper {
  display: flex;
  transition: transform 0.5s ease;
}

/* Cada slide */
.hero-swiper .swiper-slide {
  width: auto;
  transition: transform 0.5s ease-in-out;
  transform-style: preserve-3d;
}

/* Imagen dentro de la slide */
.hero-swiper .swiper-slide img {
  width: 100%;
  border-radius: 10px;
  transition: transform 0.5s ease, opacity 0.5s ease;
}

/* Sombra verde fosforescente para la slide activa */
.hero-swiper .swiper-slide-active img {
  box-shadow: 5px 5px 15px #63B76980;
}

/* Efecto 3D */
.hero-swiper .swiper-slide {
  transform-origin: center;
}
.hero-swiper .swiper-slide-active {
  transform: scale(1) translateZ(0);
}
.hero-swiper .swiper-slide-next,
.hero-swiper .swiper-slide-prev {
  transform: scale(0.8) translateZ(-100px);
}
.hero-swiper .swiper-slide-next {
  transform: scale(0.8) translateZ(-100px) rotateY(-30deg);
}
.hero-swiper .swiper-slide-prev {
  transform: scale(0.8) translateZ(-100px) rotateY(30deg);
}

/* Botones de navegación */
.hero-swiper .swiper-button-prev,
.hero-swiper .swiper-button-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
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
    left: 10%;
}

.hero-swiper .swiper-button-next {
    right: 10%;
}

/* Ocultar los pseudo-elementos por defecto de Swiper */
.hero-swiper .swiper-button-prev::after,
.hero-swiper .swiper-button-next::after {
    display: none;
}

/* Añadir iconos */
.hero-swiper .swiper-button-prev:before {
    content: '←';
    font-size: 30px;
}

.hero-swiper .swiper-button-next:before {
    content: '→';
    font-size: 30px;
}
</style>
