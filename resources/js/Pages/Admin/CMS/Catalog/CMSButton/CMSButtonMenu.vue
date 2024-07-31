<template>
    <div class="absolute top-[120%] z-10" ref="overlay">
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
import { ref } from "vue";
import { useCMSStore } from "../../../../../stores/ui/CMSStore";
import { useClickOutside } from "../../../../../composables/useClickOutside";
import { storeToRefs } from "pinia";

const emits = defineEmits(["select", "close"]);
const cmsStore = useCMSStore();
const { components } = storeToRefs(cmsStore);
const overlay = ref(null);

useClickOutside(overlay, () => emits("close"));

function handleAdd(node) {
    emits("select", node);
}
</script>

<style lang="scss" scoped></style>
