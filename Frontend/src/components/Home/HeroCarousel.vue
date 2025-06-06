<template>
  <section class="hero-carousel mt-3">
    <!-- 
      Ponemos ref="swiperContainer" para referenciar directamente este div en vez 
      de seleccionar por clase. Así evitamos problemas de timing con querySelector.
    -->
    <div ref="swiperContainer" class="swiper hero-swiper">
      <div class="swiper-wrapper">
        <div
          class="swiper-slide"
          v-for="slide in slides"
          :key="slide.id"
        >
          <img
            :src="slide.img"
            alt=""
            class="img-fluid rounded"
          />
        </div>
      </div>
      <!-- Botones de navegación (Swiper buscará estos elementos) -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, nextTick } from 'vue'
import Swiper from 'swiper/bundle'
import 'swiper/css/bundle'



// Definimos la prop “slides”
const props = defineProps({
  slides: {
    type: Array,
    default: () => []
  }
})

// Referencia al contenedor para inicializar Swiper en él
const swiperContainer = ref(null)
// Referencia para guardar la instancia y no volver a crearla
let swiperInstance = null

/**
 * Función que crea la instancia de Swiper, pero solo si aún no existe
 */
function crearSwiper() {
  if (swiperInstance) return
  // swiperContainer.value es el <div class="swiper hero-swiper">
  swiperInstance = new Swiper(swiperContainer.value, {
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
}

// Cuando cambie el array de slides (por ejemplo al cargarse desde la store),
// esperamos un nextTick para que Vue haya renderizado esos <div class="swiper-slide">,
// y luego creamos Swiper (solo una vez).
watch(
  () => props.slides,
  async (nuevasSlides) => {
    if (nuevasSlides.length > 0) {
      // Esperamos a que el DOM actualice las <swiper-slide>
      await nextTick()
      crearSwiper()
    }
  },
  { immediate: true } // también disparar al montar si ya había slides
)
</script>

<style scoped>
/* Contenedor principal del swiper */
.hero-swiper {
  position: relative;
  margin: 0 auto;
  top: 10%;
  width: clamp(90%, 1600px, 100%);
  box-sizing: border-box;
}

/* Cada slide: solo definimos transform-origin para el efecto 3D.
   No forzamos display/transition aquí, Swiper lo controla internamente. */
.hero-swiper .swiper-slide {
  transform-origin: center;
}

/* Imagen dentro de la slide */
.hero-swiper .swiper-slide img {
  width: 100%;
  border-radius: 10px;
  transition: transform 0.5s ease, opacity 0.5s ease;
}

/* Sombra verde fosforescente para la slide activa */
.hero-swiper .swiper-slide-active img {
  box-shadow: 5px 5px 15px #63b76980;
}

/* Efecto 3D */
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

/* Iconos personalizados para las flechas */
.hero-swiper .swiper-button-prev:before {
  content: '←';
  font-size: 30px;
}
.hero-swiper .swiper-button-next:before {
  content: '→';
  font-size: 30px;
}
</style>
