<template>
    <Teleport to="#overlay">
        <Transition
            appear
            enter-active-class="duration-300"
            leave-active-class="duration-300"
            enter-from-class="translate-y-[50%] opacity-0"
            leave-to-class="translate-y-[-50%] opacity-0"
        >
            <LBContent v-if="model" @close="model = false"></LBContent>
        </Transition>
    </Teleport>
</template>

<script setup>
import { provide, ref } from "vue";
import LBContent from "./LBContent.vue";

const props = defineProps({
    items: Array,
    maxZoom: {
        type: [String, Number],
        default: 5,
    },
});

const model = defineModel();

//reactives
const selectedImageIndex = ref(0);

//provides
provide("items", props.items);
provide("maxZoom", props.maxZoom);
provide("imageIndex", selectedImageIndex);
</script>

<style lang="scss" scoped></style>
