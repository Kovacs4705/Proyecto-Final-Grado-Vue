<template>
  <section
    class="featured-section container mt-3"
    data-aos="fade-right"
    data-aos-duration="2000"
    v-if="featuredItem"
  >
    <!-- Título Destacado -->
    <h2 class="featured-title">{{ featuredItem.sectionTitle }}</h2>

    <!-- Layout: imagen a la izquierda, texto a la derecha -->
    <div class="row align-items-center mt-4">
      <!-- Columna imagen -->
      <div class="col-md-8">
        <img
          :src="featuredItem.imageUrl"
          :alt="featuredItem.altText"
          class="img-fluid w-100 rounded featured-image"
        />
      </div>

      <!-- Columna texto tipo noticia -->
      <div class="col-md-4 text-start">
        <h3 class="border-start border-4 border-success ps-3 mb-3">
          {{ featuredItem.headline }}
        </h3>
        <p class="featured-description">
          {{ featuredItem.description }}
        </p>
        <a
          :href="featuredItem.buttonUrl"
          class="btn btn-success rounded-pill px-4"
        >
          {{ featuredItem.buttonText }}
        </a>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "FeaturedSection",
  props: {
    featuredItem: {
      type: Object,
      required: true,
      // Debe tener:
      // {
      //   sectionTitle: String,
      //   imageUrl: String,
      //   altText: String,
      //   headline: String,
      //   description: String,
      //   buttonText: String,
      //   buttonUrl: String
      // }
    },
  },
};
</script>

<style scoped>
featured-section .container {
  max-width: 67%;
}

.featured-title {
  display: flex;
  text-align: left;
  position: relative;
}
.featured-title::after {
  content: "";
  position: absolute;
  width: 6%;
  height: 3px;
  background-color: #39ff14;
  bottom: -10px;
  left: 0;
}

/* Estilo del párrafo descriptivo */
.featured-description {
  margin-bottom: 1.5rem;
}
</style>
