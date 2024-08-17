<template>
    <div>
        <ul class="flex flex-wrap gap-4">
            <li
                v-for="icon in iconList"
                class="cursor-pointer rounded-lg border p-1 hover:bg-slate-200"
                @click="handleSelection(icon)"
            >
                <v-icon :name="icon" scale="2"></v-icon>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { listIcons } from "oh-vue-icons";

const iconList = Object.keys(listIcons());
const model = defineModel();
const emits = defineEmits(["close"]);

function handleSelection(icon) {
    model.value = icon;
    emits("close");
}
</script>

<style lang="scss" scoped></style>
