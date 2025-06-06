<template>
    <teleport to="body">
        <div v-if="visible" ref="box" class="lightbox" @click.self="onClose">
            <div class="lightbox-content">
                <span class="lightbox-close" @click="onClose">&times;</span>
                <img
                    class="lightbox-image"
                    :src="lightboxImage"
                    alt="noticia"
                />
                <div class="lightbox-text">{{ body }}</div>
            </div>
        </div>
    </teleport>
</template>

<script setup>
import { ref, watch, nextTick } from "vue";

const props = defineProps({
    lightboxImage: { type: String, required: true },
    body: { type: String, required: true },
    visible: { type: Boolean, required: true },
});

const emit = defineEmits(["close"]);
const box = ref(null);

function onClose() {
    emit("close");
}

watch(
    () => props.visible,
    async (vis) => {
        if (vis) {
            document.body.classList.add("no-scroll");
            await nextTick();
            if (box.value) {
                box.value.style.top = `${window.scrollY}px`;
            }
        } else {
            document.body.classList.remove("no-scroll");
        }
    }
);
</script>

<style scoped>
.lightbox {
    display: flex;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.8);
    z-index: 9999;
    overflow: auto;
}

.lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
    text-align: center;
    color: #fff;
}

.lightbox-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 2rem;
    cursor: pointer;
    color: white;
}

.lightbox-image {
    max-width: 100%;
    max-height: 60%;
    margin-bottom: 1rem;
    border-radius: 0.5rem;
}

.lightbox-text {
    font-size: 1rem;
    line-height: 1.5;
}
</style>
