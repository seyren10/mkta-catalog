<template>
    <div>
        <p class="mb-2">{{ data.text }}</p>
        Click
        <a class="text-blue-600 underline" :href="data.link" target="_blank"
            >here</a
        >
        to download the file.
    </div>
</template>
<script setup>
import { ref } from "vue";

const props = defineProps({
    value: {
        default: "",
        type: String,
    },
});

const data = ref(JSON.parse(props.value));
</script>
