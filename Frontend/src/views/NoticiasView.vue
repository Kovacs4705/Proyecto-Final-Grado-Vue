<template>

  <div v-if="rol === 'admin'">
    <NavbarAdmin />
  </div>

  <div v-else-if="rol === 'usuario'">
    <NavbarUsuario />
  </div>

  <div v-else>
    <NavbarInvitado />
  </div>
  <div class="noticias-view container mt-4" v-if="rol === 'admin'">
    <!-- Sección Noticias de Hoy -->
    <section class="section-todays-news">
      <TodaysNewsAdmin />
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
          <GeneralNewsCardAdmin
            :title="item.title"
            :description="item.description"
            :image="item.image"
          />
        </div>
      </div>
    </section>
  </div>

  <div class="noticias-view container mt-4" v-if="rol === 'usuario'">
    <!-- Sección Noticias de Hoy -->
    <section class="section-todays-news">
      <TodaysNewsUsuario />
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
          <GeneralNewsCardUsuario
            :title="item.title"
            :description="item.description"
            :image="item.image"
          />
        </div>
      </div>
    </section>
  </div>

  <div class="noticias-view container mt-4" v-else>
    <!-- Sección Noticias de Hoy -->
    <section class="section-todays-news">
      <TodaysNewsInvitado />
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
          <GeneralNewsCardInvitado
            :title="item.title"
            :description="item.description"
            :image="item.image"
          />
        </div>
      </div>
    </section>
  </div>
  <FooterGeneral />
</template>

<script>
import { ref, onMounted, computed } from "vue";
import AOS from "aos";
import "aos/dist/aos.css";

import NavbarAdmin from "../components/Admin/Navbar.vue";
import NavbarUsuario from "../components/Usuario/Navbar.vue";
import NavbarInvitado from "../components/Invitado/Navbar.vue";

import TodaysNewsAdmin from "../components/Admin/Noticias/TodaysNews.vue";
import TodaysNewsUsuario from "../components/Usuario/Noticias/TodaysNews.vue";
import TodaysNewsInvitado from "../components/Invitado/Noticias/TodaysNews.vue";

import GeneralNewsCardAdmin from "../components/Admin/Noticias/GeneralNews.vue";
import GeneralNewsCardUsuario from "../components/Usuario/Noticias/GeneralNews.vue";
import GeneralNewsCardInvitado from "../components/Invitado/Noticias/GeneralNews.vue";

import FooterGeneral from "../components/Footer.vue";

export default {
  name: "NoticiasView",
  components: {
    NavbarAdmin,
    NavbarUsuario,
    NavbarInvitado,

    TodaysNewsAdmin,
    TodaysNewsUsuario,
    TodaysNewsInvitado,

    GeneralNewsCardAdmin,
    GeneralNewsCardUsuario,
    GeneralNewsCardInvitado,

    FooterGeneral,
  },
  setup() {
    // Lista de noticias generales (para todos los roles; puedes personalizar si hace falta)
    const generalNewsList = ref([
      {
        image: "/images/fornitenoticia.png",
        title: "Noticia General 1",
        description:
          "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
      },
      {
        image: "/images/rocket.png",
        title: "Noticia General 2",
        description:
          "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
      },
      {
        image: "/images/fornitenoticia.png",
        title: "Noticia General 3",
        description:
          "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
      },
      {
        image: "/images/rocket.png",
        title: "Noticia General 4",
        description:
          "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
      },
      {
        image: "/images/fornitenoticia.png",
        title: "Noticia General 5",
        description:
          "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
      },
      {
        image: "/images/rocket.png",
        title: "Noticia General 6",
        description:
          "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
      },
    ]);

    // Inicializar AOS al montar el componente
    onMounted(() => {
      AOS.init();
    });

    // Suponemos que el rol del usuario viene de un store global o contexto.
    // Aquí solo lo obtenemos de un supuesto estado (puedes adaptar según uses Vuex/Pinia/etc.)
    const rol = computed(() => {
      // Si usas Vuex:
      // return this.$store.state.usuario.rol;

      // Si defines rol en un composable o prop, cámbialo aquí.
      // Por ahora devolvemos "invitado" por defecto:
      return "invitado";
    });

    return {
      generalNewsList,
      rol,
    };
  },
};
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
