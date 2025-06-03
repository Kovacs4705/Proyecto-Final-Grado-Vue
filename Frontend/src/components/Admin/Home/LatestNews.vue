<template>
  <div class="container mt-3">
    <div class="grid text-center">
      <h2 class="text-center ultimasNoticias">Últimas Noticias</h2>
      <div class="row">
        <div
          v-for="(noticia, idx) in noticias"
          :key="noticia.id"
          class="col-md-6 ultimas-noticias-card"
        >
          <div
            class="card bg-transparent border-0 text-white"
            data-aos="fade-up"
            data-aos-duration="1200"
            :data-aos-delay="idx * 200"
          >
            <img
              class="card-img-top lightbox-trigger"
              :src="noticia.thumbnail"
              :alt="noticia.title"
              @click="openLightbox(noticia.id)"
            />
            <div class="textoNoticia">
              <h5 class="card-title">{{ noticia.title }}</h5>
              <p class="card-text">{{ noticia.excerpt }}</p>
            </div>
          </div>
        </div>
      </div>

      <Lightbox
        :visible="lightboxOpen"
        :image="current.fullImage"
        :text="current.text"
        @close="closeLightbox"
      />

      <!-- Lightbox -->
      <!-- <div
        id="lightbox"
        class="lightbox"
        v-if="lightboxOpen"
        data-aos="fade-up"
        data-aos-duration="1200"
        @click.self="closeLightbox"
      >
        <div class="lightbox-content">
          <span class="lightbox-close" @click="closeLightbox">&times;</span>
          <img
            id="lightbox-image"
            :src="current.fullImage"
            alt="Imagen de la noticia"
            data-aos="zoom-in"
            data-aos-duration="800"
          />
          <div
            id="lightbox-text"
            class="lightbox-text"
            data-aos="fade-in"
            data-aos-duration="1000"
          >
            {{ current.text }}
          </div>
        </div>
      </div> -->
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import AOS from "aos";
import "aos/dist/aos.css";
import Lightbox from "../Home/Lightbox.vue";
import { nextTick } from "vue";

const noticias = [
  {
    id: "noticia1",
    title: "Noticia 1",
    excerpt:
      "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis voluptatibus magnam libero voluptates facere qui ab soluta possimus? Voluptate molestiae ullam praesentium illo omnis earum necessitatibus odit, autem quisquam numquam!",
    thumbnail:
      "images/Epic+Games+Node_ut-1920x1080-416b0b679e572854df52c39154aff5945328c04d (1).png",
    fullImage: "images/reddead.jpg",
    text: "lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
  },
  {
    id: "noticia2",
    title: "Noticia 2",
    excerpt:
      "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Id laudantium molestiae natus delectus iure minima necessitatibus molestias voluptate nostrum ex officiis pariatur at dolorum, ipsa aut ducimus ullam repellendus debitis?",
    thumbnail:
      "images/Epic+Games+Node_ue-alt-1920x1080-e653a4a4dae65307fd2420076abe44bb71b22f06.png",
    fullImage: "images/Wukong.jpg",
    text: "lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
  },
];

const lightboxOpen = ref(false);
const current = ref({});

function openLightbox(id) {
  current.value = noticias.find(n => n.id === id)
  lightboxOpen.value = true
}

function closeLightbox() {
  lightboxOpen.value = false;
  document.body.classList.remove("no-scroll");
}

onMounted(() => {
  AOS.init({ once: false, delay: 200 });
});
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
  background-color: #39ff14;
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
