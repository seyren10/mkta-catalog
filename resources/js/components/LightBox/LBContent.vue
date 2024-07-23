<template>
    <div
        class="fixed inset-0 z-[2003] grid grid-rows-[auto,1fr,auto] bg-black bg-opacity-50 text-white"
    >
        <div class="container flex items-center py-3 text-sm">
            <p class="flex items-center text-[min(2vw+.1rem,_.8rem)]">
                <v-icon name="bi-mouse" scale="1.5"></v-icon>
                <span>
                    use your
                    <strong>&nbsp; mouse wheel &nbsp;</strong> to zoom-in and
                    out
                    <li>
        </li>
                </span>
            </p>
            <div class="ml-auto flex gap-4">
                <v-button
                    icon="md-fullscreen-round"
                    @click="el.requestFullscreen()"
                ></v-button>
                <v-button
                    icon="md-close-round"
                    @click="$emit('close')"
                ></v-button>
            </div>
        </div>
        <div
            class="group relative mx-auto w-[50%] overflow-hidden rounded-lg border-2 border-white"
        >
            <img
                :src="items[selectedImageIndex]"
                class="absolute cursor-grab"
                draggable="false"
                ref="el"
            />

            <div
                class="absolute right-[-30%] top-0 m-3 grid gap-5 rounded-lg bg-black bg-opacity-20 px-3 py-5 duration-500 group-hover:right-0"
            >
                <v-button
                    icon="ri-zoom-in-line"
                    @click="zoomTo(maxZoom)"
                ></v-button>
                <v-button
                    icon="ri-zoom-out-line"
                    @click="zoomTo(-maxZoom)"
                ></v-button>
            </div>
        </div>
        <LBImageList
            class="grid auto-cols-min grid-flow-col justify-center gap-3 py-5"
        ></LBImageList>
    </div>
</template>

<script setup>
import { inject, ref, onBeforeUnmount, onMounted } from "vue";
import { useZoom } from "../../composables/useZoom";
import { useDrag } from "../../composables/useDrag";

import LBImageList from "./LBImageList.vue";

const emits = defineEmits(["close"]);

const el = ref(null);
const maxZoom = inject("maxZoom");
const items = inject("items");
const selectedImageIndex = inject("imageIndex");

//reactives
const { zoomTo } = useZoom(el, maxZoom);
useDrag(el);

const closeWithEscKey = (e) => {
    if (e.code === "Escape") {
        emits("close");
    }
};
//hooks
onMounted(() => {
    document.querySelector("body").classList.add("h-full", "overflow-hidden");
    window.addEventListener("keydown", closeWithEscKey);
});

onBeforeUnmount(() => {
    document
        .querySelector("body")
        .classList.remove("h-full", "overflow-hidden");

    window.removeEventListener("keydown", closeWithEscKey);
});
</script>

<style lang="scss" scoped></style>
