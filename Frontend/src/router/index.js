// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import LoginView    from '../views/LoginView.vue'
import Home         from '../views/HomeView.vue'
import Explorar     from '../views/ExplorarView.vue'
import Biblioteca   from '../views/BibliotecaView.vue'
import Noticias     from '../views/NoticiasView.vue'

const routes = [
  // 1) Cuando alguien vaya a “/”, le mandamos a “/login”
  { path: '/', name: 'root', redirect: '/login' },

  // 2) Página de login
  { path: '/login', name: 'login', component: LoginView },

  // 3) Home general (todos los roles). Dentro del componente HomeView
  //    se decide qué mostrar según loginStore.rol.
  { path: '/home', name: 'home', component: Home },

  // 4) Explorar (todos los roles; el componente decide con v-if qué mostrar)
  { path: '/explorar', name: 'explorar', component: Explorar },

  // 5) Biblioteca (todos los roles)
  { path: '/biblioteca', name: 'biblioteca', component: Biblioteca },

  // 6) Noticias (todos los roles)
  { path: '/noticias', name: 'noticias', component: Noticias },

  // (Opcional) Capturar todo lo que no exista: redirigir a /login o a 404
  // { path: '/:catchAll(.*)', redirect: '/login' }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
