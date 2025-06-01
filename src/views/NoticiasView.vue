<!-- src/views/NoticiasView.vue -->
<template>
  <div class="noticias-view container mt-4">
    <!-- Sección Noticias de Hoy -->
    <section class="section-todays-news">
      <TodaysNews />
    </section>

    <!-- Separador -->
    <hr class="mt-5 mb-5 separator" />

    <!-- Sección Noticias Generales -->
    <section class="section-general-news">
      <h2
        class="general-title text-center mb-4"
        data-aos="fade-right"
        data-aos-duration="2000"
      >
        Últimas Noticias
      </h2>
      <div class="row">
        <div
          class="col-md-4"
          v-for="(item, index) in generalNewsList"
          :key="index"
          data-aos="fade-right"
          data-aos-duration="2000"
        >
          <GeneralNewsCard
            :title="item.title"
            :description="item.description"
            :image="item.image"
          />
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import AOS from "aos";
import "aos/dist/aos.css";

import TodaysNews from "../components/Noticias/TodaysNews.vue";
import GeneralNewsCard from "../components/Noticias/GeneralNews.vue";

const generalNewsList = ref([
  {
    image: "/images/fornitenoticia.png",
    title: "Noticia General 1",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus."
  },
  {
    image: "/images/rocket.png",
    title: "Noticia General 2",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus."
  },
  {
    image: "/images/fornitenoticia.png",
    title: "Noticia General 3",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus."
  },
  {
    image: "/images/rocket.png",
    title: "Noticia General 4",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus."
  },
  {
    image: "/images/fornitenoticia.png",
    title: "Noticia General 5",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus."
  },
  {
    image: "/images/rocket.png",
    title: "Noticia General 6",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus."
  }
]);

onMounted(() => {
  AOS.init();
});
</script>

<style scoped>
.noticias-view {
  max-width: 1200px;
  margin: 0 auto;
  padding-bottom: 4rem;
}

/* Separador */
.separator {
  border: none;
  height: 1px;
  background-color: rgba(255, 255, 255, 0.2);
}

/* Título sección Noticias Generales */
.general-title {
  font-family: "Oswald", sans-serif;
  font-size: 2rem;
  color: #ffffff;
  position: relative;
}
.general-title::after {
  content: "";
  position: absolute;
  bottom: -8px;
  left: 50%;
  transform: translateX(-50%);
  width: 6%;
  height: 3px;
  background-color: #39ff14;
}

/* Ajustes de responsive para cards */
.section-general-news .col-md-4 {
  margin-bottom: 2rem;
}

/* Margen superior para Noticias de Hoy */
.section-todays-news {
  margin-top: 2rem;
}

/* Colocar espacio debajo de cada tarjeta */
.general-news-card {
  background-color: transparent;
}
</style>
