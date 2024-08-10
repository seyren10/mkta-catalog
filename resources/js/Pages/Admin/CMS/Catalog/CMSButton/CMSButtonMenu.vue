<template>
    <div class="absolute z-10" ref="overlay">
        <div class="grid w-max gap-2 rounded-lg border bg-white p-3 shadow-sm">
            <div v-for="(menu, key) in components" :key="key">
                <p>{{ key }}</p>
                <ul class="grid" v-for="node in menu">
                    <li class="rounded-lg hover:bg-slate-100">
                        <button
                            class="flex w-full items-center gap-2 p-2"
                            @click="handleAdd(node)"
                        >
                            <v-icon :name="node.icon"></v-icon>
                            {{ node.title }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useCMSUIStore } from "../../../../../stores/ui/CMSUIStore";
import { useClickOutside } from "../../../../../composables/useClickOutside";
import { storeToRefs } from "pinia";

const emits = defineEmits(["select", "close"]);
const cmsStore = useCMSUIStore();
const { components } = storeToRefs(cmsStore);
const overlay = ref(null);

useClickOutside(overlay, () => emits("close"));

function handleAdd(node) {
    emits("select", node);
}

onMounted(() => {
    const overlayRect = overlay.value.getBoundingClientRect();

    if (overlayRect.top > window.innerHeight / 2) {
        overlay.value.classList.add("bottom-[130%]");
    } else {
        overlay.value.classList.add("top-[130%]");
    }

    if (overlayRect.left > window.innerWidth / 2) {
        overlay.value.classList.add("right-2");
    }
});
</script>

<style lang="scss" scoped></style>
