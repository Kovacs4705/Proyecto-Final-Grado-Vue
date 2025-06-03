<template>
  <div class="game-card" :data-aos="aos" :data-aos-duration="duration">
    <img :src="img" class="img-fluid" :alt="title" />
  </div>
  <p class="game-title">{{ title }}</p>
  <p class="game-price">{{ price }}</p>
</template>

<script setup>
const props = defineProps({
  img:    { type: String, required: true },
  title:  { type: String, required: true },
  price:  { type: String, required: true },
  aos:    { type: String, default: "fade-up" },
  duration: { type: Number, default: 1000 },
});
</script>

<style scoped>
.game-card {
  border-radius: 15px;
  overflow: hidden;         /* <-- Importante: recorta todo el contenido dentro */
  transition: transform 0.2s ease;
  width: 100%;
  max-width: 293px;
}

.game-card img {
  display: block;
  width: 100%;
  /* Puedes añadir `height: auto;` si quieres asegurar proporcionalidad */
}

.game-card:hover {
  transform: translateY(-5px);
}

.game-title {
  text-align: start;
  font: normal normal normal 24px Roboto;
  margin-top: 10px;
  color: white;
}

.game-price {
  text-align: start;
  font: normal normal normal 16px Roboto;
  margin-top: 10px;
  color: white;
}
</style>
