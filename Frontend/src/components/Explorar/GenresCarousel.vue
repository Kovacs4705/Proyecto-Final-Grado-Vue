<template>
    <section class="genres-carousel py-5">
        <div class="container genres-container">
            <div class="position-relative mb-3 genres-header">
                <h2 class="title">GÉNEROS POPULARES</h2>
                <div class="navigation">
                    <div class="swiper-button-prev header-prev-btn"></div>
                    <div class="swiper-button-next header-next-btn"></div>
                </div>
            </div>
            <!-- Swiper -->
            <div class="genres-swiper swiper swiper-container">
                <div class="swiper-wrapper">
                    <div
                        v-for="(genre, index) in genres"
                        :key="genre.id"
                        class="swiper-slide"
                        :data-aos="
                            index === 0
                                ? 'fade-right'
                                : index === 1
                                ? 'fade-up'
                                : index === 2
                                ? 'fade-down'
                                : 'fade-left'
                        "
                        data-aos-duration="2000"
                    >
                        <div
                            class="genre-card"
                            :style="{
                                backgroundImage: `url(${genre.imageUrl})`,
                            }"
                        >
                            <span class="genre-title">{{ genre.title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, nextTick, watch, ref } from "vue";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

const props = defineProps({
    genres: {
        type: Array,
        required: true,
    },
});

const swiperInstance = ref(null);

function initSwiper() {
    // Destruye el swiper anterior si existe
    if (swiperInstance.value) {
        swiperInstance.value.destroy(true, true);
        swiperInstance.value = null;
    }
    swiperInstance.value = new Swiper(".genres-swiper.swiper", {
        slidesPerView: Math.min(4, props.genres.length),
        spaceBetween: 20,
        loop: props.genres.length > 4,
        navigation: {
            prevEl: ".header-next-btn",
            nextEl: ".header-prev-btn",
        },
        breakpoints: {
            0: { slidesPerView: Math.min(1.5, props.genres.length), spaceBetween: 10 },
            576: { slidesPerView: Math.min(2.5, props.genres.length), spaceBetween: 15 },
            768: { slidesPerView: Math.min(3.5, props.genres.length), spaceBetween: 20 },
            992: { slidesPerView: Math.min(4, props.genres.length), spaceBetween: 20 },
        },
    });
}

// Inicializa Swiper cuando los géneros cambian y hay slides
watch(
    () => props.genres,
    async (newGenres) => {
        if (newGenres && newGenres.length > 0) {
            await nextTick();
            initSwiper();
        }
    },
    { immediate: true }
);
</script>

<style scoped>
/* ------------------------------------------------ */
/*      SECCIÓN PRINCIPAL Y ANCHO (igual que DOC)   */
/* ------------------------------------------------ */
.genres-carousel {
    background-color: transparent;
}

/* Contenedor con width = 67% (como Featured) */
.genres-container {
    max-width: 67%;
}

/* ------------------------------------------------ */
/*       CABECERA: TÍTULO Y BOTONES DE NAVEGACIÓN   */
/* ------------------------------------------------ */
/* Con position-relative para poder colocar flechas 
   absolutely sin afectar al flujo del <h2> */
.genres-header {
    position: relative;
}

/* Título con línea verde debajo */
.title {
    color: #fff;
    position: absolute;
    top: -50px;
}
.title::after {
    content: "";
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 30%;
    height: 3px;
    background-color: #39ff14;
}

/* ------------------------------------------------ */
/*     CONTENEDOR DE FLECHAS (absoluto a la derecha) */
/* ------------------------------------------------ */
.navigation {
    position: absolute;
    top: 50%;
    right: 60px;
    transform: translateY(calc(-50% - 15px));
    display: flex;
    gap: 1rem;
}

/* ------------------------------------------------ */
/*        BOTONES DE NAVEGACIÓN EN LA CABECERA      */
/* ------------------------------------------------ */
.header-prev-btn,
.header-next-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #39ff14;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.2s ease;
}
.header-prev-btn:hover,
.header-next-btn:hover {
    transform: scale(1.1);
}
.header-prev-btn::after,
.header-next-btn::after {
    display: none; /* Oculta iconos predeterminados de Swiper */
}
.header-prev-btn::before {
    content: "→";
    font-size: 20px;
    color: black;
}
.header-next-btn::before {
    content: "←";
    font-size: 20px;
    color: black;
}

/* ------------------------------------------------ */
/*          CONTENEDOR SWIPER Y SLIDES              */
/* ------------------------------------------------ */
.genres-swiper {
    width: 100%;
    overflow: hidden; /* No cortar bordes redondeados */
    position: relative;
}

/* Cada slide centrado */
.genres-swiper .swiper-slide {
    display: flex;
    justify-content: center;
    overflow: visible;
}

/* ------------------------------------------------ */
/*          ESTILO DE LAS TARJETAS (GENRE-CARD)     */
/* ------------------------------------------------ */
.genre-card {
    position: relative;
    width: 100%;
    max-width: 400px; /* Máximo ancho para cada tarjeta */
    aspect-ratio: 16/9; /* Mantiene proporción para que escale */
    background-size: cover;
    background-position: center;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}
.genre-card:hover {
    transform: translateY(-5px);
}

.genre-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #fff;
    text-shadow: 0 0 6px rgba(0, 0, 0, 0.8);
    z-index: 1;
    text-align: center;
    padding: 0 0.5rem;
}

/* ------------------------------------------------ */
/*         AJUSTES RESPONSIVOS PARA SWIPER          */
/* ------------------------------------------------ */
.genres-swiper .swiper-slide .genre-card {
    border-radius: 10px; /* Asegura que el redondeo no se corte */
}

/* ------------------------------------------------ */
/*         PUNTOS DE RUPTURA (OPCIONAL)             */
/* ------------------------------------------------ */
@media (max-width: 576px) {
    .title {
        font-size: 1.4rem;
    }
    .header-prev-btn,
    .header-next-btn {
        width: 36px;
        height: 36px;
    }
    .genre-card {
        max-width: 220px;
    }
}

@media (min-width: 577px) and (max-width: 768px) {
    .title {
        font-size: 1.6rem;
    }
    .header-prev-btn,
    .header-next-btn {
        width: 38px;
        height: 38px;
    }
    .genre-card {
        max-width: 250px;
    }
}
</style>
