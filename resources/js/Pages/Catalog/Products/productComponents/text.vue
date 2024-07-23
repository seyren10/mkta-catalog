<template>
    {{ value }}
</template>
<script setup>
const props = defineProps({
    value: {
        default: "",
        type: String,
    },
});
</script>
