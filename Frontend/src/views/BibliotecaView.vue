<!-- src/views/BibliotecaView.vue -->
<template>

  <div v-if="rol === 'admin'">
    <NavbarAdmin />
  </div>

  <div v-if="rol === 'usuario'">
    <NavbarUsuario />
  </div>

  <div v-else>
    <NavbarInvitado />
  </div>
  <div v-if="rol === 'admin'" class="biblioteca-view">
    <RecentlyPlayedAdmin />

    <AllGameGridAdmin />
  </div>

  <div v-if="rol === 'usuario'" class="biblioteca-view">
    <RecentlyPlayedUsuario />

    <AllGameGridUsuario />
  </div>
  <FooterGeneral />
</template>

<script setup>
// Importa los componentes que ya creaste
import FooterGeneral from '../components/Footer.vue'
import NavbarAdmin from '../components/Admin/Navbar.vue'
import NavbarUsuario from '../components/Usuario/Navbar.vue'
import NavbarInvitado from '../components/Invitado/Navbar.vue'

import RecentlyPlayedAdmin from '../components/Admin/Biblioteca/RecentlyPlayed.vue'
import AllGameGridAdmin from '../components/Admin/Biblioteca/AllGamesGrid.vue'

import RecentlyPlayedUsuario from '../components/Usuario/Biblioteca/RecentlyPlayed.vue'
import AllGameGridUsuario from '../components/Usuario/Biblioteca/AllGamesGrid.vue'
</script>

<style scoped>
/* Margen vertical para separar del navbar */
.biblioteca-view {
  margin-top: 2rem;
  margin-bottom: 2rem;
}

/* Asegura que el contenido encaje bien en pantallas muy pequeñas */
@media (max-width: 575px) {
  .biblioteca-view {
    margin-top: 1rem;
    margin-bottom: 1rem;
  }
}
</style>
