<!-- src/components/Navbar.vue -->
<template>
    <nav ref="nav" :class="['navbar', 'navbar-expand-lg', 'navbar-dark', 'navbar-custom', { scrolled }]">
        <div class="container-fluid d-flex align-items-center px-4">
            <!-- Hamburger toggle -->
            <input id="active" type="checkbox" v-model="menuOpen" />
            <label for="active" class="menu-btn"><span></span></label>
            <label for="active" class="close"></label>

            <div class="wrapper" :class="{ open: menuOpen }">
                <ul>
                    <li v-if="rol === 'administrador'">
                        <router-link to="/panel" @click="menuOpen = false">Panel de Control</router-link>
                    </li>
                    <li><router-link to="/home" @click="menuOpen = false">Inicio</router-link></li>
                    <li v-if="rol === 'administrador' || rol === 'usuario'">
                        <router-link to="/biblioteca" @click="menuOpen = false">Biblioteca</router-link>
                    </li>   
                    <li><router-link to="/explorar" @click="menuOpen = false">Explorar</router-link></li>
                    <li><router-link to="/noticias" @click="menuOpen = false">Noticias</router-link></li>
                </ul>
            </div>

            <!-- Logo -->
            <router-link to="/" class="navbar-brand d-flex align-items-center ms-3">
                <img src="../assets/imagenes/logo header.PNG" alt="Logo" class="logo-img" />
                <span class="ms-2 company-title">KALE CONNECTING WORLDS</span>
            </router-link>

            <!-- Idioma + Usuario + Accesibilidad -->
            <div class="d-flex align-items-center ms-auto">
                <div class="lang-buttons me-3 position-relative">
                    <!-- Botón principal de ACCESIBILIDAD -->
                    <button class="lang-btn" @click="toggleAccessibilityOptions">
                        accesibilidad
                    </button>

                    <!-- Opciones desplegables de accesibilidad -->
                    <div v-if="showAccessibilityOptions" class="user-menu shadow-sm">
                        <label class="form-check mb-2">
                            <input type="checkbox" v-model="isFontAccessible" @change="onToggleFont"
                                class="form-check-input" />
                            <span class="form-check-label">Letra accesible</span>
                        </label>
                        <label class="form-check">
                            <input type="checkbox" v-model="isColorAccessible" @change="onToggleColor"
                                class="form-check-input" />
                            <span class="form-check-label">Colores accesibles</span>
                        </label>
                    </div>
                </div>

                <div class="user-info d-flex align-items-center position-relative">
                    <img src="../assets/images/avatar-de-usuario.png" class="user-avatar" />
                    <!-- Al hacer click en el nombre, mostramos el menú correspondiente -->
                    <span class="user-name ms-2" @click="toggleUserMenu" style="cursor: pointer;">
                        {{ displayName }}
                        <i class="fas fa-caret-down ms-1"></i>
                    </span>

                    <!-- Menú de usuario -->
                    <div v-if="showUserMenu" class="user-menu shadow-sm bg-dark text-white p-2">
                        <!-- Si existe usuario logueado -->
                        <template v-if="rol">
                            <div class="user-menu-item" @click="logout">
                                Cerrar sesión
                            </div>
                        </template>
                        <!-- Si es invitado -->
                        <template v-else>
                            <div class="user-menu-item" @click="goToLogin">
                                Iniciar sesión
                            </div>
                            <div class="user-menu-item" @click="goToRegister">
                                Registrarse
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
import { useLoginStore } from '../stores/useLoginStore.js'
import { useRouter, useRoute } from 'vue-router'
import AOS from 'aos'

const router = useRouter()
const route = useRoute()
const loginStore = useLoginStore()

const nav = ref(null)
const scrolled = ref(false)
const menuOpen = ref(false)
const showAccessibilityOptions = ref(false)
const isFontAccessible = ref(false)
const isColorAccessible = ref(false)

// Nuevo: control del menú de usuario
const showUserMenu = ref(false)
function toggleUserMenu() {
    showUserMenu.value = !showUserMenu.value
}

// Computed para rol y nombre a mostrar
const rol = computed(() => loginStore.rol)
const displayName = computed(() => {
    return loginStore.user?.nombre || 'Invitado'
})

// Cuando haya un logout, cerramos el menú automático si estaba abierto
watch(rol, () => {
    showUserMenu.value = false
})

// Métodos para navegar
function goToLogin() {
    showUserMenu.value = false
    router.push({ name: 'login' })
}
function goToRegister() {
    showUserMenu.value = false
    router.push({ name: 'login', query: { register: 1 } })
}
// Método de logout: limpia store y redirige a home como invitado
function logout() {
    loginStore.logout()
    showUserMenu.value = false
    router.push({ name: 'home' })
}

// Accesibilidad
function applyFontAccess(enabled) {
    if (enabled) document.body.classList.add('font-accessible')
    else document.body.classList.remove('font-accessible')
}
function applyColorAccess(enabled) {
    if (enabled) document.body.classList.add('color-accessible')
    else document.body.classList.remove('color-accessible')
}
function onToggleFont() {
    localStorage.setItem('font_accessibility', isFontAccessible.value)
    applyFontAccess(isFontAccessible.value)
}
function onToggleColor() {
    localStorage.setItem('color_accessibility', isColorAccessible.value)
    applyColorAccess(isColorAccessible.value)
}
function toggleAccessibilityOptions() {
    showAccessibilityOptions.value = !showAccessibilityOptions.value
}

// Scroll listener
function onScroll() {
    scrolled.value = window.scrollY > 50
}

// Evitamos scroll al abrir el menú hamburguesa
watch(menuOpen, (open) => {
    document.body.classList.toggle('no-scroll', open)
})

// Ciclo de vida: cargar preferencias de accesibilidad
onMounted(() => {
    window.addEventListener('scroll', onScroll)

    const savedFont = localStorage.getItem('font_accessibility') === 'true'
    isFontAccessible.value = savedFont
    applyFontAccess(savedFont)

    const savedColor = localStorage.getItem('color_accessibility') === 'true'
    isColorAccessible.value = savedColor
    applyColorAccess(savedColor)
})
onUnmounted(() => {
    window.removeEventListener('scroll', onScroll)
})
</script>
<style scoped>
/* Navbar */
.navbar-custom {
    background-color: black;
    padding: 15px 40px;
    transition: all 0.3s ease-in-out;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 999;
}

/* Efecto cuando se hace scroll */
.navbar-custom.scrolled {
    background-color: rgba(0, 0, 0, 0.8);
    /* Fondo opaco */
    padding: 10px 40px;
    /* Reducir el tamaño del padding al hacer scroll */
}

/* Ajuste de logo y título */
.navbar-brand {
    align-items: center;
    left: 1%;
}

.navbar-brand img {
    height: 30px;
    margin-right: 10px;
}


.lang-buttons button {
    display: flex;
    border: 1px solid white;
    color: white;
    background: transparent;
    padding: 5px 10px;
    margin-left: 5px;
    border-radius: 5px;
}

.lang-buttons,
.user-info {
    margin-left: auto;
    margin-right: 0;
    position: static;
}

.user-info img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-left: 10px;
}

.user-info span {
    margin-left: 10px;
}

.wrapper {
    position: fixed;
    top: 0;
    left: -100%;
    height: 100%;
    width: 100%;
    background: black;
    transition: all 0.6s ease-in-out;
    z-index: 9998;
    /* Asegúrate de que el menú esté por debajo del botón */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

#active:checked~.wrapper {
    left: 0;
}

.menu-btn {
    position: fixed;
    /* Cambiado a fixed */
    z-index: 9999;
    /* Asegúrate de que el botón esté por encima del menú */
    left: 20px;
    height: 50px;
    width: 50px;
    text-align: center;
    line-height: 50px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}

.menu-btn span,
.menu-btn:before,
.menu-btn:after {
    content: "";
    position: absolute;
    top: calc(50% - 1px);
    left: 30%;
    width: 40%;
    border-bottom: 2px solid white;
    transition: transform .6s cubic-bezier(0.215, 0.61, 0.355, 1);
}

.menu-btn:before {
    transform: translateY(-8px);
}

.menu-btn:after {
    transform: translateY(8px);
}

.close {
    z-index: 1;
    width: 100%;
    height: 100%;
    pointer-events: none;
    transition: background .6s;
}

/* closing animation */
#active:checked+.menu-btn span {
    transform: scaleX(0);
}

#active:checked+.menu-btn:before {
    transform: rotate(45deg);
    border-color: #fff;
}

#active:checked+.menu-btn:after {
    transform: rotate(-45deg);
    border-color: #fff;
}

.wrapper ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    /* Asegura que estén en vertical */
    align-items: center;
    /* Centra los elementos */
}

.wrapper ul li {
    width: 200px;
    /* Puedes ajustar este valor para que todos sean iguales */
    text-align: center;
    /* Centra el texto */
}

::v-deep .wrapper ul li a {
    display: block;
    width: 100%;
    /* Ocupará todo el ancho del <li> */
    padding: 10px 0;
    text-decoration: none;
    color: white;
    position: relative;
    transition: color 0.3s ease-in-out;
}

::v-deep .wrapper ul li a::after {
    content: "";
    display: block;
    width: 100%;
    height: 3px;
    background-color: #42D54D;
    position: absolute;
    bottom: 0;
    left: 0;
    transform: scaleX(0);
    transition: transform 0.3s ease-in-out;
}

::v-deep .wrapper ul li a:hover::after {
    transform: scaleX(1);
    /* Hace que la línea se expanda */
}

::v-deep #active:checked~.wrapper ul li a {
    opacity: 1;
}

::v-deep .wrapper ul li a {
    opacity: 0;
    /* Hacer los enlaces invisibles al inicio */
    transition: opacity 0.6s ease, transform 1.2s cubic-bezier(0.215, 0.61, 0.355, 1);
    transform: translateX(100px);
}


::v-deep #active:checked~.wrapper ul li a {
    opacity: 1;
    transform: translateX(0);
    transition-delay: 0.3s;
    /* Opcional, para que la opacidad tarde un poco en activarse */
}

/* Estilos para el menú hamburguesa */
.hamburger-menu {
    position: fixed;
    /* top: 20px; */
    left: 20px;
    z-index: 1000;
    cursor: pointer;
    font-size: 30px;
    color: white;
    /* Asegúrate de que el color sea blanco */
}

/* Estilos para el menú lateral */
.wrapper {
    position: fixed;
    top: 0;
    left: -100%;
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.9);
    color: white;
    /* Asegúrate de que el color del texto sea blanco */
    z-index: 9998;
    /* Asegúrate de que el menú esté por debajo del botón */
    transition: left 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.wrapper ul {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: center;
}

.wrapper ul li {
    margin: 20px 0;
}

::v-deep.wrapper ul li a {
    color: white;
    /* Asegúrate de que el color del texto sea blanco */
    text-decoration: none;
    font-size: 24px;
}

.close {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
    color: white;
    /* Asegúrate de que el color sea blanco */
}

#active {
    display: none;
}

/* Menú de usuario desplegable */
.user-menu {
    position: absolute;
    top: 40px;
    right: 0;
    background: #222;
    border: 1px solid #444;
    border-radius: 5px;
    min-width: 150px;
    z-index: 10000;
}

.user-menu-item {
    padding: 10px 15px;
    cursor: pointer;
    transition: background 0.2s;
}

.user-menu-item:hover {
    background: #333;
    color: #42D54D;
}
</style>
