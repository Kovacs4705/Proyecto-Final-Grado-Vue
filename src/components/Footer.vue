<template>
    <footer class="footer mt-5">
        <div class="footer-line"></div>
        <div class="container-fluid mt-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-start">
                    <ul class="footer-links">
                        <li v-for="link in links" :key="link.text">
                            <a :href="link.href" target="_blank" rel="noopener">{{ link.text }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 text-end">
                    <a v-for="icon in icons" :key="icon.name" :href="icon.href" target="_blank" rel="noopener"
                        class="footer-icon">
                        <i :class="icon.class"></i>
                    </a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col text-start">
                    <p class="footer-rights">© {{ year }} KALE CONNECTING WORLDS. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue'

// Array de enlaces de texto
const links = ref([
    { text: 'Términos de servicio', href: '#' },
    { text: 'Política de privacidad', href: '#' },
    { text: 'Política de reembolso de tienda', href: '#' },
])

// Array de iconos sociales
const icons = ref([
    { name: 'youtube', href: 'https://www.youtube.com', class: 'fab fa-youtube' },
    { name: 'instagram', href: 'https://www.instagram.com', class: 'fab fa-instagram' },
])

// Año dinámico
const year = new Date().getFullYear()
</script>
<style scoped>
.footer {
  left: 15%;
  bottom: 0;
  width: 100%;
}
.footer {
    background-color: black;
    max-width: 70%;
    /* Igual al ancho del .container.mt-3 */
    margin: 0 auto;
    /* Centrar el footer horizontalmente */
    color: white;
    padding: 20px 0;
    font-size: 11px;
    text-align: center;
    /* Centrar el contenido del texto */
}

.footer-line {
    height: 2px;
    background-color: #39ff14;
    /* Verde fosforescente */
    margin-bottom: 20px;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 15px;
}

.footer-links li {
    display: inline;
}

.footer-links a {
    color: white;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #39ff14;
    /* Verde fosforescente al pasar el cursor */
}

.footer-icon {
    color: white;
    font-size: 20px;
    margin-left: 15px;
    transition: color 0.3s ease;
}

.footer-icon:hover {
    color: #39ff14;
    /* Verde fosforescente al pasar el cursor */
}

.footer-rights {
    color: gray;
    font-size: 12px;
    margin: 0;
    padding-top: 10px;
}

/* Ajustar el ancho del footer */
.footer .container {
    padding-left: 15px;
    /* Asegurar un pequeño padding izquierdo */
    padding-right: 15px;
    /* Asegurar un pequeño padding derecho */
}
</style>