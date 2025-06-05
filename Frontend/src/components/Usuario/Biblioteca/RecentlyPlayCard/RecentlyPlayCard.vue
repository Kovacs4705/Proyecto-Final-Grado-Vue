<!-- src/components/RecentlyPlayedCard.vue -->
<template>
  <div
    class="card recently-played-card"
    data-aos="fade-up"
    data-aos-duration="1200"
    :data-aos-delay="delay"
  >
    <img
      :src="image"
      alt="Game image"
      class="juegosRecientes"
    />
    <p class="game-title">{{ title }}</p>
  </div>
</template>

<script>
export default {
  name: 'RecentlyPlayedCard',
  props: {
    /**
     * Ruta de la imagen del juego.
     * Ejemplo: '/assets/images/juego1.png'
     */
    image: {
      type: String,
      required: true
    },
    /**
     * Título que se mostrará debajo de la imagen.
     * Ejemplo: 'JEDI Falling Order'
     */
    title: {
      type: String,
      required: true
    },
    /**
     * Retardo en milisegundos para la animación AOS.
     * Por defecto 200 (se puede sobrescribir desde el padre).
     */
    delay: {
      type: Number,
      default: 200
    }
  }
}
</script>

<style scoped>
/*--------------------------------------------------------------------------------*/
/*---------------------- RecentlyPlayedCard: Estilos específicos -----------------*/
/*--------------------------------------------------------------------------------*/

/* Contenedor principal de la card */
.recently-played-card {
  width: 100%;
  background: transparent;
  border: none;
}

/* Imagen del juego (“juegosRecientes”): redondeado y al 100% del ancho */
.juegosRecientes {
  width: 100%;
  border-radius: 15px;
  display: block;
}

/* Título debajo de la imagen */
.game-title {
  margin-top: 10px;
  /* Alinear el texto a la izquierda dentro de la card */
  text-align: left;
  /* Color blanco y fuente Roboto a 24 px */
  color: white;
  font: normal normal normal 24px 'Roboto', sans-serif;
  /* Asegura que no se salga del contenedor */
  word-wrap: break-word;
}

/* Añade un pequeño sombreado al contenedor para destacarlo sobre fondo oscuro */
.recently-played-card {
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.4);
  border-radius: 15px;
  overflow: hidden;
}
</style>
