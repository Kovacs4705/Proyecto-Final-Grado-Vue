<template>
  <div class="todays-news">
    <!-- Título principal con AOS -->
    <h2
      id="destacado"
      class="text-center mt-3"
      data-aos="fade-right"
      data-aos-duration="2000"
    >
      Noticias de Hoy
    </h2>

    <!-- Bloque de noticias destacadas -->
    <div
      class="row align-items-center mt-4 featured-news-item"
      v-for="(item, index) in featuredNews"
      :key="index"
      data-aos="fade-right"
      data-aos-duration="2000"
    >
      <div class="col-md-4">
        <img
          :src="item.image"
          alt="Imagen Destacado"
          class="img-fluid rounded featured-img"
        />
      </div>
      <div class="col-md-8 text-start textoNoticia">
        <h3 class="news-title">{{ item.title }}</h3>
        <p class="news-description">{{ item.description }}</p>
        <button class="btn btn-success rounded-pill px-4">Leer más</button>
      </div>
    </div>

    <!-- Separador -->
    <hr class="separator my-5" />

    <!-- Bloque de noticias secundarias -->
    <div
      class="row small-news-grid"
      data-aos="fade-right"
      data-aos-duration="2000"
    >
      <div
        class="col-md-4 mb-4 small-news-item"
        v-for="(item, idx) in smallNews"
        :key="idx"
      >
        <img
          :src="item.image"
          alt="Imagen Noticia"
          class="img-fluid rounded small-news-img"
        />
        <h4 class="small-news-title">{{ item.title }}</h4>
        <p class="small-news-description">{{ item.description }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TodaysNews",
  data() {
    return {
      featuredNews: [
        {
          image: "/images/NoticiaDestacada.png",
          title: "UNREAL TOURNAMENT",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus, voluptates cum nobis ex enim deleniti reiciendis."
        },
        {
          image: "/images/rocket.png",
          title: "ROCKET LAUNCH EVENT",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus, voluptates cum nobis ex enim deleniti reiciendis."
        },
        {
          image: "/images/fornitenoticia.png",
          title: "FORTNITE UPDATES",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus, voluptates cum nobis ex enim deleniti reiciendis."
        }
      ],
      smallNews: [
        {
          image: "/images/fornitenoticia.png",
          title: "Noticia 1",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus."
        },
        {
          image: "/images/rocket.png",
          title: "Noticia 2",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus."
        },
        {
          image: "/images/fornitenoticia.png",
          title: "Noticia 3",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus."
        },
        {
          image: "/images/rocket.png",
          title: "Noticia 4",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus."
        },
        {
          image: "/images/fornitenoticia.png",
          title: "Noticia 5",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus."
        },
        {
          image: "/images/rocket.png",
          title: "Noticia 6",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus."
        }
      ]
    };
  },
  mounted() {
    // Inicializar AOS al montar el componente
    if (typeof AOS !== "undefined") {
      AOS.init();
    }
  }
};
</script>

<style scoped>
.todays-news {
  margin-top: 2rem;
  margin-bottom: 4rem;
  /* El contenedor principal no necesita más padding porque el wrapper global ya lo aplica */
}

/* --------------------------------------------------------------------------
   TÍTULO PRINCIPAL
   -------------------------------------------------------------------------- */
#destacado {
  position: relative;
  margin-bottom: 3rem;
  font-family: "Oswald", sans-serif;
  font-size: 2rem;
  color: #ffffff;
}
#destacado::after {
  content: "";
  position: absolute;
  bottom: -8px;
  left: 50%;
  transform: translateX(-50%);
  width: 6%;
  height: 3px;
  background-color: #39ff14;
}

/* --------------------------------------------------------------------------
   NOTICIAS DESTACADAS
   -------------------------------------------------------------------------- */
.featured-news-item {
  margin-bottom: 3rem;
}

.featured-img {
  width: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}
.featured-img:hover {
  transform: scale(1.02);
}

.textoNoticia .news-title {
  font-size: 1.75rem;
  margin-bottom: 0.75rem;
  color: #ffffff;
}

.textoNoticia .news-description {
  font-size: 1rem;
  line-height: 1.5;
  color: #dddddd;
  margin-bottom: 1rem;
}

/* --------------------------------------------------------------------------
   SEPARADOR
   -------------------------------------------------------------------------- */
.separator {
  border: none;
  height: 1px;
  background-color: rgba(255, 255, 255, 0.3);
  width: 80%;
  margin-left: 10%;
  margin-right: 10%;
}

/* --------------------------------------------------------------------------
   NOTICIAS SECUNDARIAS (GRID)
   -------------------------------------------------------------------------- */
.small-news-grid {
  margin-top: 2rem;
}

.small-news-item {
  text-align: left;
}

.small-news-img {
  width: 80%;
  object-fit: cover;
  margin-bottom: 0.5rem;
}

.small-news-title {
  font-size: 1.25rem;
  color: #ffffff;
  margin-bottom: 0.5rem;
}

.small-news-description {
  font-size: 0.95rem;
  color: #cccccc;
  line-height: 1.4;
}

/* --------------------------------------------------------------------------
   AOS (se asegura que no interfiera con estilos existentes)
   -------------------------------------------------------------------------- */
[data-aos] {
  opacity: 0;
  transition-property: opacity, transform;
}

[data-aos].aos-animate {
  opacity: 1;
}

/* --------------------------------------------------------------------------
   UTILITARIOS
   -------------------------------------------------------------------------- */
.mt-3 {
  margin-top: 1rem !important;
}
.my-5 {
  margin-top: 3rem !important;
  margin-bottom: 3rem !important;
}
.mb-4 {
  margin-bottom: 1.5rem !important;
}
</style>