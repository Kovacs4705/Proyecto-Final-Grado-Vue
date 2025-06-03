<template>
  <div class="ultimas-noticias-card col-md-6">
    <div
      class="card"
      :data-aos="'fade-up'"
      :data-aos-duration="1200"
      :data-aos-delay="aosDelay"
      @click="openLightbox"
    >
      <img class="card-img-top" :src="news.thumbnail" :alt="news.title" />
      <div class="textoNoticia">
        <h5 class="card-title">{{ news.title }}</h5>
        <p class="card-text">{{ news.excerpt }}</p>
      </div>
    </div>

    <!-- Lightbox integrado dentro del mismo NewsCard -->
    <Lightbox
      v-if="lightboxOpen"
      :image="news.fullImage"
      :text="news.fullText"
      @close="closeLightbox"
    />
  </div>
</template>

<script setup>
import { ref } from "vue";
import Lightbox from "./Lightbox.vue";

const props = defineProps({
  noticia: { type: Object, required: true },
  aosDelay: { type: Number, default: 0 },
});
// renombro la flag y la función para no chocar con el nombre
const lightboxOpen = ref(false);

function openLightbox() {
  lightboxOpen.value = true;
  document.body.classList.add("no-scroll");
}
function closeLightbox() {
  lightboxOpen.value = false;
  document.body.classList.remove("no-scroll");
}
</script>

<style scoped>
.no-scroll {
  overflow: hidden;
}
</style>
