<template>
    <div class="relative">
        <button class="rounded-lg border" @click="handleShowMenu">
            <v-icon name="bi-plus" scale="1.3"></v-icon>
        </button>

        <CMSButtonMenu
            v-if="showMenu"
            @select="handleAdd"
            @close="hideMenu"
        ></CMSButtonMenu>
    </div>
</template>

<script setup>
import { ref } from "vue";

import CMSButtonMenu from "./CMSButtonMenu.vue";

const showMenu = ref(false);
const emits = defineEmits(["select"]);

function handleAdd(node) {
    emits("select", node);
    hideMenu();
}
function handleShowMenu() {
    showMenu.value = !showMenu.value;
}

function hideMenu() {
    showMenu.value = false;
}
</script>

<style lang="scss" scoped></style>
