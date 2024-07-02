<template>
    <div class="my-2">
        <div class="border-b-2 text-xl font-semibold">{{ title }}</div>
        <div>
            <template v-for="img in model">
                <img class="min-h-10"  :src="img" :alt="title">
            </template>
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
