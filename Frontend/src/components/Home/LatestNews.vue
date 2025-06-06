<template>
  <div class="container mt-3">
    <div class="grid text-center">
      <h2 class="text-center ultimasNoticias">Últimas Noticias</h2>
      <div class="row">
        <div v-for="(noticia, idx) in news" :key="noticia.id" class="col-md-6 ultimas-noticias-card">
          <div class="card bg-transparent border-0 text-white" data-aos="fade-up" data-aos-duration="1200"
            :data-aos-delay="idx * 200" @click="openLightbox(noticia)" style="cursor:pointer">
            <img class="card-img-top lightbox-trigger" :src="noticia.image" :alt="noticia.title" />
            <div class="textoNoticia">
              <h5 class="card-title">{{ noticia.title }}</h5>
              <p class="card-text">{{ noticia.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Lightbox v-if="lightboxOpen" :image="lightboxImage" :body="lightboxBody" :visible="lightboxOpen"
      @close="lightboxOpen = false" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Lightbox from './Lightbox.vue'

const props = defineProps({
  news: { type: Array, required: true }
})

const lightboxOpen = ref(false)
const lightboxImage = ref('')
const lightboxBody = ref('')

function openLightbox(noticia) {
  lightboxImage.value = noticia.lightbox || noticia.image
  lightboxBody.value = noticia.body || noticia.description
  lightboxOpen.value = true
}
</script>

<style scoped>
body.no-scroll {
  overflow: hidden;
}

.ultimasNoticias {
  display: flex;
  text-align: left;
  margin-bottom: 30px;
  position: relative;
}

.ultimasNoticias::after {
  content: "";
  position: absolute;
  width: 9%;
  height: 3px;
  background-color: #39FF14;
  bottom: -10px;
  left: 0;
}

.grid {
  margin-top: 50px;
}

.ultimas-noticias-card {
  margin-bottom: 30px;
}

.ultimas-noticias-card img {
  width: 100%;
  object-fit: cover;
}

.textoNoticia {
  background-color: transparent !important;
  color: white !important;
}

.lightbox {
  display: flex;
  position: fixed;
  z-index: 99999;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  justify-content: center;
  align-items: center;
}

.lightbox-content {
  position: relative;
  max-width: 80%;
  max-height: 80%;
  text-align: center;
  color: white;
  overflow: auto;
}

.lightbox img {
  max-width: 100%;
  max-height: 60%;
  border-radius: 10px;
}

.lightbox-text {
  margin-top: 20px;
  font-size: 18px;
  line-height: 1.5;
}

.lightbox-close {
  position: absolute;
  top: 10px;
  right: 20px;
  font-size: 30px;
  color: white;
  cursor: pointer;
  z-index: 1001;
}
</style>