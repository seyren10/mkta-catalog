<template>
    <div class="h-1 bg-slate-100">
        <div
            class="rounded-full animate-loading h-full w-[50%] bg-opacity-30"
            :class="`${computedColor}`"
        ></div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    color: String,
});

const computedColor = computed(() => {
    return "bg-" + props.color.trim();
});
</script>

<style lang="scss" scoped></style>
