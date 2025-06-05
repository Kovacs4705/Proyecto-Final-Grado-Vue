import { createApp } from 'vue'
import App from './App.vue'
import { createPinia } from 'pinia'
import router from './router'       // ← aquí importas tu router

import AOS from 'aos'
import 'aos/dist/aos.css'

import './assets/global.css'        // tu CSS global

const app = createApp(App)

const pinia = createPinia()            // <-- Crear instancia de Pinia
app.use(pinia)        

app.use(router)                     // ← aquí registras Vue Router
app.mount('#app')   
                 // <-- Registrar Pinia EN EL APP
app.use(router)                     // montas tu App en el div#app


AOS.init({
    once: false,  // Permite que las animaciones se repitan al hacer scroll
    delay: 200,  // Pequeña demora para evitar que se rendericen antes de tiempo
});

window.addEventListener("resize", function () {
    AOS.refresh(); // Vuelve a calcular las posiciones cuando la ventana cambia de tamaño
});
// Forzar la actualización de AOS después de la carga
setTimeout(() => {
    AOS.refresh();
}, 500);