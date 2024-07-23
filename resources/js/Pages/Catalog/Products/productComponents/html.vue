<template>
    <div class="w-full" v-html="value"></div>
</template>
<script setup>
const props = defineProps({
    value: {
        default: "",
        type: String,
    },
});
</script>
