<template>
    <div class="card p-4 shadow rounded bg-dark text-white" data-aos="fade-up">
        <h2 class="text-center mb-4">
            {{ isLogin ? "Iniciar Sesión" : "Registrarse" }}
        </h2>

        <form @submit.prevent="handleSubmit">
            <!-- Campos de registro -->
            <div v-if="!isLogin" class="mb-3">
                <label class="form-label">DNI</label>
                <input
                    type="text"
                    v-model="form.dni_usuario"
                    class="form-control"
                    placeholder="12345678A"
                    required
                    @blur="validateDniOnBlur"
                />
                <div v-if="dniError" class="alert alert-danger mt-2 py-1 px-2">
                    {{ dniError }}
                </div>
            </div>
            <div v-if="!isLogin" class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input
                    type="text"
                    v-model="form.nombre"
                    class="form-control"
                    placeholder="Juan Pérez"
                    required
                />
            </div>

            <!-- Campos comunes -->
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input
                    type="email"
                    v-model="form.email"
                    class="form-control"
                    placeholder="juan@ejemplo.com"
                    required
                    @blur="validateEmailOnBlur"
                />
                <div
                    v-if="emailError"
                    class="alert alert-danger mt-2 py-1 px-2"
                >
                    {{ emailError }}
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input
                    type="password"
                    v-model="form.password"
                    class="form-control"
                    placeholder="********"
                    required
                    @blur="validatePasswordOnBlur"
                />
            </div>
            <div v-if="!isLogin" class="mb-3">
                <label class="form-label">Repetir contraseña</label>
                <input
                    type="password"
                    v-model="form.repeatPassword"
                    class="form-control"
                    placeholder="********"
                    required
                    @blur="validateRepeatPasswordOnBlur"
                />
            </div>

            <!-- Botones -->
            <button
                class="btn btn-primary w-100"
                type="submit"
                :disabled="loginStore.isLoading"
            >
                {{
                    loginStore.isLoading
                        ? isLogin
                            ? "Validando..."
                            : "Registrando..."
                        : isLogin
                        ? "Entrar"
                        : "Registrarse"
                }}
            </button>
            <button
                class="btn btn-outline-light mt-3 w-100"
                type="button"
                @click="toggleMode"
                :disabled="loginStore.isLoading"
            >
                {{
                    isLogin
                        ? "¿No tienes cuenta? Regístrate"
                        : "¿Ya tienes cuenta? Inicia sesión"
                }}
            </button>
        </form>

        <!-- Error display -->
        <div v-if="loginStore.error" class="mt-3 alert alert-danger">
            {{ loginStore.error }}
        </div>
        <div v-if="passwordError" class="mt-3 alert alert-danger">
            {{ passwordError }}
        </div>

        <div class="text-center mt-4">
            <span>O entra como:</span>
            <button
                class="btn btn-secondary mt-2 w-100"
                @click="entrarComoInvitado"
                :disabled="loginStore.isLoading"
            >
                Invitado
            </button>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { ref } from "vue";
import { useRoute } from "vue-router";
import { useRouter } from "vue-router";
import { useLoginStore } from "../stores/useLoginStore.js";

const emit = defineEmits(["logged-in"]);

const router = useRouter();
const loginStore = useLoginStore();
const route = useRoute();

const isLogin = ref(true);
const form = ref({
    dni_usuario: "",
    nombre: "",
    email: "",
    password: "",
    repeatPassword: "",
});
const passwordError = ref(null);
const dniError = ref(null);
const emailError = ref(null);

onMounted(() => {
    if (route.query.register === "1") {
        isLogin.value = false;
    }
});

function toggleMode() {
    loginStore.error = null;
    passwordError.value = null;
    dniError.value = null;
    emailError.value = null;
    isLogin.value = !isLogin.value;
    form.value = {
        dni_usuario: "",
        nombre: "",
        email: "",
        password: "",
        repeatPassword: "",
    };
}

// Valida el formato y letra del DNI español
function validarDNI(dni) {
    const dniRegex = /^(\d{8})([A-HJ-NP-TV-Z])$/i;
    if (!dniRegex.test(dni)) return false;
    const letras = "TRWAGMYFPDXBNJZSQVHLCKE";
    const numero = dni.substr(0, 8);
    const letra = dni.substr(8, 1).toUpperCase();
    return letras.charAt(parseInt(numero, 10) % 23) === letra;
}

// Valida el formato de email
function validarEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Validación al perder el foco
function validateDniOnBlur() {
    if (!isLogin.value && form.value.dni_usuario.trim() !== "") {
        if (!validarDNI(form.value.dni_usuario.trim())) {
            dniError.value =
                "El DNI no es válido. Debe tener 8 números y una letra correcta.";
        } else {
            dniError.value = null;
        }
    }
}

function validateEmailOnBlur() {
    if (form.value.email.trim() !== "") {
        if (!validarEmail(form.value.email.trim())) {
            emailError.value = "El correo electrónico no es válido.";
        } else {
            emailError.value = null;
        }
    }
}

function validatePasswordOnBlur() {
    if (
        !isLogin.value &&
        form.value.password !== "" &&
        form.value.repeatPassword !== ""
    ) {
        if (form.value.password !== form.value.repeatPassword) {
            passwordError.value = "Las contraseñas no coinciden.";
        } else {
            passwordError.value = null;
        }
    }
}

function validateRepeatPasswordOnBlur() {
    if (
        !isLogin.value &&
        form.value.password !== "" &&
        form.value.repeatPassword !== ""
    ) {
        if (form.value.password !== form.value.repeatPassword) {
            passwordError.value = "Las contraseñas no coinciden.";
        } else {
            passwordError.value = null;
        }
    }
}

async function handleSubmit() {
    loginStore.error = null;
    passwordError.value = null;
    dniError.value = null;
    emailError.value = null;

    if (isLogin.value) {
        // MODO LOGIN
        const ok = await loginStore.loginUser({
            email: form.value.email.trim(),
            contraseña: form.value.password,
        });
        if (ok) {
            const rolActual = loginStore.rol;
            emit("logged-in", rolActual);
            router.push({ name: "home" });
        }
    } else {
        // Validar DNI
        if (!validarDNI(form.value.dni_usuario.trim())) {
            dniError.value =
                "El DNI no es válido. Debe tener 8 números y una letra correcta.";
            return;
        }
        // Validar email
        if (!validarEmail(form.value.email.trim())) {
            emailError.value = "El correo electrónico no es válido.";
            return;
        }
        // Validar que las contraseñas coincidan
        if (form.value.password !== form.value.repeatPassword) {
            passwordError.value = "Las contraseñas no coinciden.";
            return;
        }
        // MODO REGISTRO
        const payload = {
            dni_usuario: form.value.dni_usuario.trim(),
            nombre: form.value.nombre.trim(),
            email: form.value.email.trim(),
            contraseña: form.value.password,
        };

        const ok = await loginStore.registerUser(payload);
        if (ok) {
            alert("¡Registro completado! Ahora inicia sesión.");
            form.value = {
                dni_usuario: "",
                nombre: "",
                email: "",
                password: "",
                repeatPassword: "",
            };
            isLogin.value = true;
        }
    }
}

function entrarComoInvitado() {
    loginStore.logout();
    emit("logged-in", null);
    router.push({ name: "home" });
}
</script>
<style scoped>
.card {
    background-color: #1c1c1c;
    border: none;
}
.form-control {
    background-color: #2c2c2c;
    color: white;
    border: 1px solid #555;
}
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: none;
}

.form-control::placeholder {
    color: #8f8f8f; 
    opacity: 1;
}

.btn-primary {
    background-color: #42d54d;
    border-color: #42d54d;
}

.btn-secondary {
    background-color: #444;
    border-color: #666;
}
</style>
