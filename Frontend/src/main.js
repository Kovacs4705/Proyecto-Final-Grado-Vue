// main.js
import { createApp } from 'vue'
import App from './App.vue'
import { createPinia } from 'pinia'
import router from './router'

import AOS from 'aos'
import 'aos/dist/aos.css'

import './assets/global.css'   // <-- tu CSS global debe cargarse antes del mount

const app = createApp(App)

const pinia = createPinia()
app.use(pinia)

// Registra vue-router ANTES de llamar a mount
app.use(router)

// Monta la app UNA vez que ya has registrado todos los plugins
app.mount('#app')

AOS.init({
  once: false,
  delay: 200,
})

window.addEventListener('resize', () => {
  AOS.refresh()
})

setTimeout(() => {
  AOS.refresh()
}, 500)
