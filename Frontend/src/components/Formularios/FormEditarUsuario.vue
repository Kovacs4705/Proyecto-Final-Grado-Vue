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
            <div v-if="usuarioErrors.nombre" class="alert alert-danger mt-2 py-1 px-2">
                {{ usuarioErrors.nombre }}
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
            <div v-if="usuarioErrors.email" class="alert alert-danger mt-2 py-1 px-2">
                {{ usuarioErrors.email }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">DNI*</label>
            <input
                v-model="formUsuario.dni_usuario"
                type="text"
                class="form-control"
                required
                readonly
            />
        </div>
        <div class="mb-3">
            <label class="form-label">Rol*</label>
            <select
                v-model="formUsuario.rol"
                class="form-select"
                required
                @blur="validateRolOnBlur"
            >
                <option value="" disabled>Selecciona un rol...</option>
                <option value="usuario">Usuario</option>
                <option value="administrador">Administrador</option>
            </select>
            <div v-if="usuarioErrors.rol" class="alert alert-danger mt-2 py-1 px-2">
                {{ usuarioErrors.rol }}
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Saldo*</label>
            <input
                v-model.number="formUsuario.saldo"
                type="number"
                min="0"
                class="form-control"
                required
                @blur="validateSaldoOnBlur"
            />
            <div v-if="usuarioErrors.saldo" class="alert alert-danger mt-2 py-1 px-2">
                {{ usuarioErrors.saldo }}
            </div>
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
                <span v-else>Guardar cambios</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, reactive, watch } from "vue";
import { useUsersStore } from "../../stores/useUserStore.js";

const props = defineProps({
    itemActual: { type: Object, required: true }
});
const emit = defineEmits(["saved", "cancel"]);
const usersStore = useUsersStore();

const formUsuario = reactive({
    nombre: "",
    email: "",
    dni_usuario: "",
    rol: "",
    saldo: 0,
});

const usuarioErrors = reactive({
    nombre: null,
    email: null,
    rol: null,
    saldo: null,
});

const isSubmitting = ref(false);

// Inicializar el formulario con los datos actuales
watch(
    () => props.itemActual,
    (nuevo) => {
        formUsuario.nombre = nuevo?.nombre || "";
        formUsuario.email = nuevo?.email || "";
        formUsuario.dni_usuario = nuevo?.dni_usuario || "";
        formUsuario.rol = nuevo?.rol || "";
        formUsuario.saldo = nuevo?.saldo ?? 0;
    },
    { immediate: true }
);

function validateNombreOnBlur() {
    usuarioErrors.nombre = !formUsuario.nombre.trim()
        ? "El nombre es obligatorio."
        : null;
}
function validateEmailOnBlur() {
    usuarioErrors.email = !formUsuario.email.trim()
        ? "El email es obligatorio."
        : null;
}
function validateRolOnBlur() {
    usuarioErrors.rol = !formUsuario.rol
        ? "El rol es obligatorio."
        : null;
}
function validateSaldoOnBlur() {
    usuarioErrors.saldo =
        formUsuario.saldo === null || formUsuario.saldo === "" || formUsuario.saldo < 0
            ? "El saldo debe ser 0 o mayor."
            : null;
}
function validateAllUsuarioFields() {
    let valid = true;
    if (!formUsuario.nombre.trim()) {
        usuarioErrors.nombre = "El nombre es obligatorio.";
        valid = false;
    } else {
        usuarioErrors.nombre = null;
    }
    if (!formUsuario.email.trim()) {
        usuarioErrors.email = "El email es obligatorio.";
        valid = false;
    } else {
        usuarioErrors.email = null;
    }
    if (!formUsuario.rol) {
        usuarioErrors.rol = "El rol es obligatorio.";
        valid = false;
    } else {
        usuarioErrors.rol = null;
    }
    if (formUsuario.saldo === null || formUsuario.saldo === "" || formUsuario.saldo < 0) {
        usuarioErrors.saldo = "El saldo debe ser 0 o mayor.";
        valid = false;
    } else {
        usuarioErrors.saldo = null;
    }
    return valid;
}

async function onSubmit() {
    isSubmitting.value = true;
    try {
        const valid = validateAllUsuarioFields();
        if (!valid) {
            throw new Error("Revisa los campos del formulario.");
        }
        const payload = {
            nombre: formUsuario.nombre.trim(),
            email: formUsuario.email.trim(),
            dni_usuario: formUsuario.dni_usuario.trim(),
            rol: formUsuario.rol,
            saldo: formUsuario.saldo,
        };
        const actualizado = await usersStore.updateUserByDni(
            props.itemActual.dni_usuario,
            payload
        );
        if (!actualizado) {
            throw new Error(usersStore.error || "Error al actualizar el usuario.");
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