<template>
    <div class="absolute top-[120%] z-10" ref="overlay">
        <div class="grid w-max gap-2 rounded-lg border bg-white p-3 shadow-sm">
            <div v-for="(menu, key) in menuContent" :key="key">
                <p class="mb-1 font-medium capitalize">
                    {{ key }}
                </p>
                <ul class="grid">
                    <li
                        v-for="node in menu"
                        class="rounded-lg hover:bg-slate-100"
                    >
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

const emits = defineEmits(["select", "close"]);
const overlay = ref(null);
const CMSStore = useCMSStore();

const menuContent = CMSStore.components;

useClickOutside(overlay, () => emits("close"));

function handleAdd(node) {
    emits("select", node);
}
</script>

<style lang="scss" scoped></style>
