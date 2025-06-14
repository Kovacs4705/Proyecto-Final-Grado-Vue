<template>
    <form @submit.prevent="onSubmit">
        <div class="mb-3">
            <label class="form-label">Nombre*</label>
            <input
                v-model="formUsuario.nombre"
                type="text"
                class="form-control"
                required
                @blur="validateNombreOnBlur"
            />
            <div
                v-if="userErrors.nombre"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ userErrors.nombre }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email*</label>
            <input
                v-model="formUsuario.email"
                type="email"
                class="form-control"
                required
                @blur="validateEmailOnBlur"
            />
            <div
                v-if="userErrors.email"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ userErrors.email }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña*</label>
            <input
                v-model="formUsuario.contrasena"
                type="password"
                class="form-control"
                placeholder="Escribe una contraseña"
                required
                @blur="validatePasswordOnBlur"
            />
            <div
                v-if="userErrors.contrasena"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ userErrors.contrasena }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Repetir contraseña*</label>
            <input
                v-model="formUsuario.repeatPassword"
                type="password"
                class="form-control"
                placeholder="Repite la contraseña"
                required
                @blur="validateRepeatPasswordOnBlur"
            />
            <div
                v-if="userErrors.password"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ userErrors.password }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">DNI*</label>
            <input
                v-model="formUsuario.dni_usuario"
                type="text"
                class="form-control"
                required
                @blur="validateDniOnBlur"
            />
            <div
                v-if="userErrors.dni"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ userErrors.dni }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Rol*</label>
            <select
                v-model="formUsuario.rol"
                class="form-select"
                required
                @blur="validateRolOnBlur"
            >
                <option value="">Selecciona un rol</option>
                <option value="usuario">Usuario</option>
                <option value="administrador">Administrador</option>
            </select>
            <div
                v-if="userErrors.rol"
                class="alert alert-danger mt-2 py-1 px-2"
            >
                {{ userErrors.rol }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Saldo</label>
            <input
                v-model.number="formUsuario.saldo"
                type="number"
                min="0"
                class="form-control"
                required
            />
        </div>
        <div class="modal-footer">
            <button
                type="button"
                class="btn btn-secondary"
                @click="$emit('cancel')"
            >
                Cancelar
            </button>
            <button
                type="submit"
                class="btn btn-primary"
                :disabled="isSubmitting"
            >
                <span
                    v-if="isSubmitting"
                    class="spinner-border spinner-border-sm text-light"
                    role="status"
                ></span>
                <span v-else>Guardar</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useUsersStore } from "../../stores/useUserStore.js";

const emit = defineEmits(["saved", "cancel"]);
const usersStore = useUsersStore();

const formUsuario = reactive({
    nombre: "",
    email: "",
    dni_usuario: "",
    rol: "",
    saldo: null,
    contrasena: "",
    repeatPassword: "",
});
const userErrors = reactive({
    nombre: null,
    email: null,
    contrasena: null,
    password: null,
    dni: null,
    rol: null,
});
const isSubmitting = ref(false);

// Validaciones
function validarDNI(dni) {
    const dniRegex = /^(\d{8})([A-HJ-NP-TV-Z])$/i;
    if (!dniRegex.test(dni)) return false;
    const letras = "TRWAGMYFPDXBNJZSQVHLCKE";
    const numero = dni.substr(0, 8);
    const letra = dni.substr(8, 1).toUpperCase();
    return letras.charAt(parseInt(numero, 10) % 23) === letra;
}
function validarEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
function validateNombreOnBlur() {
    if (!formUsuario.nombre.trim()) {
        userErrors.nombre = "El nombre es obligatorio.";
    } else {
        userErrors.nombre = null;
    }
}
function validateDniOnBlur() {
    if (!formUsuario.dni_usuario.trim()) {
        userErrors.dni = "El DNI es obligatorio.";
    } else if (!validarDNI(formUsuario.dni_usuario.trim())) {
        userErrors.dni =
            "El DNI no es válido. Debe tener 8 números y una letra correcta.";
    } else {
        userErrors.dni = null;
    }
}
function validateEmailOnBlur() {
    if (!formUsuario.email.trim()) {
        userErrors.email = "El correo electrónico es obligatorio.";
    } else if (!validarEmail(formUsuario.email.trim())) {
        userErrors.email = "El correo electrónico no es válido.";
    } else {
        userErrors.email = null;
    }
}
function validatePasswordOnBlur() {
    if (!formUsuario.contrasena) {
        userErrors.contrasena = "La contraseña es obligatoria.";
    } else if (
        formUsuario.contrasena !== "" &&
        formUsuario.repeatPassword !== "" &&
        formUsuario.contrasena !== formUsuario.repeatPassword
    ) {
        userErrors.password = "Las contraseñas no coinciden.";
    } else {
        userErrors.contrasena = null;
        userErrors.password = null;
    }
}
function validateRepeatPasswordOnBlur() {
    if (!formUsuario.repeatPassword) {
        userErrors.password = "Debes repetir la contraseña.";
    } else if (
        formUsuario.contrasena !== "" &&
        formUsuario.repeatPassword !== "" &&
        formUsuario.contrasena !== formUsuario.repeatPassword
    ) {
        userErrors.password = "Las contraseñas no coinciden.";
    } else {
        userErrors.password = null;
    }
}
function validateRolOnBlur() {
    if (!formUsuario.rol) {
        userErrors.rol = "El rol es obligatorio.";
    } else {
        userErrors.rol = null;
    }
}
function validateAllUserFields() {
    let valid = true;
    // Nombre
    if (!formUsuario.nombre) {
        userErrors.nombre = "El nombre es obligatorio.";
        valid = false;
    } else {
        userErrors.nombre = null;
    }
    // Email
    if (!formUsuario.email) {
        userErrors.email = "El correo electrónico es obligatorio.";
        valid = false;
    } else if (!validarEmail(formUsuario.email.trim())) {
        userErrors.email = "El correo electrónico no es válido.";
        valid = false;
    } else {
        userErrors.email = null;
    }
    // Contraseña
    if (!formUsuario.contrasena) {
        userErrors.contrasena = "La contraseña es obligatoria.";
        valid = false;
    } else {
        userErrors.contrasena = null;
    }
    // Repetir contraseña
    if (!formUsuario.repeatPassword) {
        userErrors.password = "Debes repetir la contraseña.";
        valid = false;
    } else if (
        formUsuario.contrasena &&
        formUsuario.repeatPassword &&
        formUsuario.contrasena !== formUsuario.repeatPassword
    ) {
        userErrors.password = "Las contraseñas no coinciden.";
        valid = false;
    } else {
        userErrors.password = null;
    }
    // DNI
    if (!formUsuario.dni_usuario) {
        userErrors.dni = "El DNI es obligatorio.";
        valid = false;
    } else if (!validarDNI(formUsuario.dni_usuario.trim())) {
        userErrors.dni =
            "El DNI no es válido. Debe tener 8 números y una letra correcta.";
        valid = false;
    } else {
        userErrors.dni = null;
    }
    // Rol
    if (!formUsuario.rol) {
        userErrors.rol = "El rol es obligatorio.";
        valid = false;
    } else {
        userErrors.rol = null;
    }
    // Saldo (no es obligatorio)
    return valid;
}

async function onSubmit() {
    isSubmitting.value = true;
    try {
        const valid = validateAllUserFields();
        if (!valid) {
            throw new Error("Revisa los campos del formulario.");
        }
        const nuevoUsuario = await usersStore.createUser({
            nombre: formUsuario.nombre,
            email: formUsuario.email,
            contraseña: formUsuario.contrasena,
            dni_usuario: formUsuario.dni_usuario,
            rol: formUsuario.rol,
            saldo: formUsuario.saldo,
        });
        if (!nuevoUsuario) {
            throw new Error(usersStore.error || "Error al crear usuario");
        }
        emit("saved");
    } catch (err) {
        alert(err.message || "Hubo un error al guardar.");
    } finally {
        isSubmitting.value = false;
    }
}
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
}

.modal .modal-dialog {
    margin-top: 3rem;
}

.modal-content {
    background-color: #1c1c1c;
    border: none;
}

.form-label {
    color: #ffffff;
}

.form-control,
.form-select {
    background-color: #2c2c2c;
    color: #ffffff;
    border: 1px solid #444;
}

.form-control::placeholder {
    color: #8f8f8f;
    opacity: 1;
}

.form-control:focus,
.form-select:focus {
    box-shadow: none;
    border-color: #42d54d;
}

.btn-primary {
    background-color: #42d54d;
    border-color: #42d54d;
}

.btn-secondary {
    background-color: #444;
    border-color: #666;
}

.btn-close-white {
    filter: invert(1);
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.modal-footer .btn {
    min-width: 80px;
}
</style>
