<template>
    <div class="my-2">
        <div class="border-b-2 text-xl font-semibold">{{ title }}</div>
        <div>
            <p class="mb-2">{{ model }}</p>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
const props = defineProps({
    title: "Default Title",
});

const model = defineModel();
</script>
