<!-- src/components/Home/BestGameCard.vue -->
<template>
    <div class="best-game-card" :data-aos="aos" :data-aos-duration="duration" :data-aos-delay="delay">
        <img :src="img" alt="" class="best-game-img" />
        <div class="best-game-info">
            <h5 class="best-game-title">{{ title }}</h5>
            <p class="best-game-price">{{ price }}</p>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    /** URL de la imagen del juego */
    img: {
        type: String,
        required: true
    },
    /** Título del juego */
    title: {
        type: String,
        default: ''
    },
    /** Precio o texto descriptivo */
    price: {
        type: String,
        default: ''
    },
    /** Animación AOS (fade-up, etc.) */
    aos: {
        type: String,
        default: 'fade-up'
    },
    /** Duración de la animación AOS en milisegundos */
    duration: {
        type: Number,
        default: 1200
    },
    /** Retardo de la animación AOS en milisegundos */
    delay: {
        type: Number,
        default: 0
    }
})
</script>

<style scoped>
.best-game-card {
    border-radius: 15px;
    overflow: hidden;
    width: 100%;
}

/* Imagen del juego */
.best-game-img {
    display: block;
    width: 100%;
}

/* Contenedor inferior con degradado */
.best-game-info {
    background:
        linear-gradient(180deg,
            #243953 0%,
            rgba(10, 10, 10, 0.95) 67%,
            rgba(23, 23, 23, 0.91) 100%);
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.29);
    border-radius: 0 0 15px 15px;
    opacity: 0.5;
    padding: 10px;
    text-align: center;
    color: white;
}

/* Título del juego */
.best-game-title {
    margin: 0 0 0.5rem;
    font-size: 1rem;
    font-weight: bold;
}

/* Precio o subtítulo */
.best-game-price {
    margin: 0;
    font-size: 0.9rem;
    color: #39ff14;
}
</style>