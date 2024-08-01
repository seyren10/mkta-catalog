<template>
    <div class="relative">
        <button class="rounded-lg border" @click="handleShowMenu">
            <v-icon name="bi-plus" scale="1.3" ></v-icon>
        </button>

        <CMSButtonMenu
            v-if="showMenu"
            @select="handleAdd"
            @close="hideMenu"
        ></CMSButtonMenu>
    </div>
</template>

<script setup>
import { provide, ref } from "vue";

import CMSButtonMenu from "./CMSButtonMenu.vue";

const props = defineProps({
    menuContent: Array,
});
const emits = defineEmits(["select"]);
const showMenu = ref(false);

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

provide("menuContent", props.menuContent);
</script>

<style lang="scss" scoped></style>
