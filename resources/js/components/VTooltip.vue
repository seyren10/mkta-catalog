<template>
    <div
        ref="el"
        class="invisible absolute left-[50%] translate-x-[-50%] scale-75 rounded-md bg-[#00000060] p-3 text-white opacity-0 duration-100 ease-out group-hover:visible group-hover:scale-100 group-hover:opacity-100"
        :class="{
            'top-[105%]': align === 'bottom',
            'bottom-[105%]': align === 'top',
        }"
        :style="{ 'max-width': `${+maxWidth}px` }"
    >
        <slot></slot>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
const props = defineProps({
    align: {
        type: String,
        default: "bottom",
    },
    maxWidth: {
        type: String,
        default: 300,
    },
});
const el = ref(null);

onMounted(() => {
    const parent = el.value.parentElement;

    parent.classList.add("relative", "group");
});
</script>

<style lang="scss" scoped></style>
