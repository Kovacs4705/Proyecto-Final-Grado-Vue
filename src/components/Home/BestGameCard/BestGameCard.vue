<!-- src/components/Home/BestGameCard.vue -->
<template>
  <a :href="link" target="_blank" class="card-link" :data-aos="aos" :data-aos-duration="duration"
    :data-aos-delay="delay">
    <div class="card">
      <!-- Portada -->
      <div class="wrapper">
        <img :src="img" alt="Portada del juego" class="cover-image" />
      </div>

      <!-- Imagen del título -->
      <img v-if="titleImg" :src="titleImg" alt="Título" class="title" />

      <!-- Imagen del personaje -->
      <img v-if="characterImg" :src="characterImg" alt="Personaje" class="character" />
    </div>
  </a>
</template>

<script setup>
const props = defineProps({
  /** URL al detalle del juego */
  link: {
    type: String,
    default: '#'
  },
  /** Portada del juego */
  img: {
    type: String,
    required: true
  },
  /** Imagen del título (png con texto) */
  titleImg: {
    type: String,
    default: ''
  },
  /** Imagen del personaje */
  characterImg: {
    type: String,
    default: ''
  },
  /** Animación AOS (fade-up, etc.) */
  aos: {
    type: String,
    default: 'fade-up'
  },
  /** Duración de la animación AOS en ms */
  duration: {
    type: [String, Number],
    default: 1200
  },
  /** Retardo de la animación AOS en ms */
  delay: {
    type: [String, Number],
    default: 0
  }
})
</script>

<style scoped>




/* * {
  box-sizing: border-box;
} */

/* body {
  width: 100vw;
  height: 100vh;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #191c29;
} */

.card {
  width: var(--card-width);
  height: var(--card-height);
  position: relative;
  display: flex;
  justify-content: center;
  align-items: flex-end;
  padding: 0 36px;
  perspective: 2500px;
  margin: 0 50px;
  margin-bottom: 50px;
  background-color: transparent !important;
}

.cover-image {
  width: 100%;
  height: 300px;   
  object-fit: fill;
}

.wrapper {
  transition: all 0.5s;
  position: absolute;
  width: 100%;
  z-index: -1;
}

.card:hover .wrapper {
  transform: perspective(900px) translateY(-5%) rotateX(25deg) translateZ(0);
  box-shadow: 2px 35px 32px -8px rgba(0, 0, 0, 0.75);
  -webkit-box-shadow: 2px 35px 32px -8px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 2px 35px 32px -8px rgba(0, 0, 0, 0.75);
}

.wrapper::before,
.wrapper::after {
  content: "";
  opacity: 0;
  width: 100%;
  height: 80px;
  transition: all 0.5s;
  position: absolute;
  left: 0;
}

.wrapper::before {
  top: 0;
  height: 100%;
  background-image: linear-gradient(to top,
      transparent 46%,
      rgba(12, 13, 19, 0.5) 68%,
      rgba(12, 13, 19) 97%);
}

/* Estado inicial: sin oscurecer */
.wrapper::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 0;                              /* sin altura */
  background-image: linear-gradient(
    to bottom,
    transparent 0%,
    rgba(12, 13, 19, 0.5) 50%,
    rgba(12, 13, 19, 0.8) 100%
  );
  opacity: 0;                             /* invisible */
  transition: height 0.4s ease, opacity 0.4s ease;
}

/* Al hacer hover: altura + opacidad máxima */
.card:hover .wrapper::after {
  height: 50%;                            /* oscurece mitad inferior */
  opacity: 1;                             /* visible */
}


.card:hover .wrapper::before,
.wrapper::after {
  opacity: 1;
}

.card:hover .wrapper::after {
  height: 120px;
}

.title {
  width: 100%;
  transition: transform 0.5s;
}

.card:hover .title {
  transform: translate3d(0%, -50px, 100px);
}

.character {
  width: 100%;
  opacity: 0;
  transition: all 0.5s;
  position: absolute;
  z-index: -1;
}

.card:hover .character {
  opacity: 1;
  transform: translate3d(0%, -30%, 100px);
}
</style>