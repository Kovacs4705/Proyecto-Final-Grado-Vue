<!-- src/components/Home/BestGameCard.vue -->
<template>
    <div class="card card-custom-width" :data-aos="aos" :data-aos-duration="duration" :data-aos-delay="delay">
        <img :src="img" alt="Card image cap" class="card-img-top" />
        <div>
            <h5>{{ title }}</h5>
            <p>Precio: {{ price }}</p>
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
    /** Precio del juego */
    price: {
        type: String,
        default: ''
    },
    /** Animación AOS (e.g. "fade-up") */
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
.card-custom-width {
    width: 100%;
    /* se adapta al contenedor padre */
    border-radius: 15px;
    overflow: hidden;
    background: transparent;
}

.card-img-top {
    border-radius: 10px 10px 0 0;
    object-fit: cover;
    width: 100%;
    height: auto;
}

.card-body {
    background: linear-gradient(180deg,
            #243953 0%,
            rgba(10, 10, 10, 0.95) 67%,
            rgba(23, 23, 23, 0.91) 100%);
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.29);
    border-radius: 0 0 15px 15px;
    padding: 10px;
    text-align: center;
    color: white;
}

.card-title {
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.card-text {
    margin: 0;
    color: #39ff14;
}

</style>