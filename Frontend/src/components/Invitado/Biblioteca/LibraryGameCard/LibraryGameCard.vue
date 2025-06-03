<!-- src/components/LibraryGameCard.vue -->
<template>
  <div
    class="card"
    data-aos="fade-up"
    data-aos-duration="1200"
    :data-aos-delay="delay"
  >
    <img
      :src="image"
      alt="Game cover"
      class="library-game-image"
    />
      <h5 class="game-name">{{ title }}</h5>
  </div>
</template>

<script>
export default {
  name: 'LibraryGameCard',
  props: {
    /**
     * Ruta de la imagen de portada del juego.
     * Ejemplo: '/assets/images/hordes.png'
     */
    image: {
      type: String,
      required: true
    },
    /**
     * Nombre o título del juego que aparece debajo de la imagen.
     * Ejemplo: 'Nier Automata'
     */
    title: {
      type: String,
      required: true
    },
    /**
     * Retardo en milisegundos para la animación AOS.
     * Por defecto 200 (puede sobrescribirse desde el padre).
     */
    delay: {
      type: Number,
      default: 200
    }
  }
};
</script>

<style scoped>
/*--------------------------------------------------------------------------------*/
/*------------------------ LibraryGameCard: Estilos específicos -----------------*/
/*--------------------------------------------------------------------------------*/

/* Cuando AOS inicializa (clase `aos-init`), mantener opacity: 0 */


.card {
  width: 100%;
  /* Se adapta al contenedor */
  /* max-width: 300px; */
  /* Tamaño máximo más pequeño */
  --bs-card-bg: transparent;
}

.card .library-game-image{
    transform: scale(1.2);
}

/* Contenedor principal de la tarjeta */
/* .library-game-card {
  width: 100%;
  border: none;
  border-radius: 10px;
  overflow: hidden;
  transition: transform 0.2s ease;
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.4);
} */

/* Efecto hover para elevar ligeramente la tarjeta */
.library-game-card:hover {
  transform: translateY(-5px);
}

/* Imagen de portada del juego */
/* .library-game-image {
  display: block;
  width: 100%;
  height: 470px;             
  object-fit: cover;         
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
   
} */

/* Cuerpo de la tarjeta que contiene el título */


/* Nombre del juego */
.game-name {
  margin: 0;
  font-size: 1.1rem;
  color: white;
  font-family: 'Roboto', sans-serif;
  font-weight: bold;
  line-height: 1.2;
  word-break: break-word;
}
</style>
