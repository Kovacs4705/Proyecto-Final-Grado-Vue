// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import HomeView       from '../views/HomeView.vue'
import ExplorarView   from '../views/ExplorarView.vue'
import BibliotecaView from '../views/BibliotecaView.vue'
import NoticiasView   from '../views/NoticiasView.vue'

const routes = [
  { path: '/',          name: 'home',      component: HomeView },
  { path: '/explorar',  name: 'explorar',  component: ExplorarView },
  { path: '/biblioteca',name: 'biblioteca',component: BibliotecaView },
  { path: '/noticias',  name: 'noticias',  component: NoticiasView },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
