<template>
    <div
        ref="el"
        class="invisible absolute left-0 z-[1000] w-max scale-75 rounded-lg bg-[#00000094] p-1 px-3 text-[.9rem] text-white opacity-0 duration-100 ease-out group-hover/tooltip:visible group-hover/tooltip:scale-100 group-hover/tooltip:opacity-100"
        :class="{
            'top-[105%]': align === 'bottom',
            'bottom-[105%]': align === 'top',
        }"
        :style="{ maxWidth: `${maxWidth}px` }"
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
        default: "1000",
    },
});
const el = ref(null);

onMounted(() => {
    const parent = el.value.parentElement;
    parent.classList.add("relative", "group/tooltip");
    parent.classList.remove("overflow-hidden");

    //anchor the tooltip on the left/right depending
    //whether the element is placed on the left/right of the screen
    if (el.value.getBoundingClientRect().x > window.innerWidth / 2) {
        el.value.classList.add("right-0");
        el.value.classList.remove("left-0");
    }
});
</script>

<style lang="scss" scoped></style>
