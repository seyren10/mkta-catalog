<template>
    <div>
        <slot>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi dolore
            voluptas impedit ab unde fuga atque aut eos tenetur, vero, incidunt
            laborum dignissimos, aliquam qui numquam non ullam iste velit!
        </slot>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted } from "vue";

onMounted(() => {
    document.body.classList.add("overflow-hidden");
});

onUnmounted(() => {
    document.body.classList.remove("overflow-hidden");
});
</script>

<style lang="scss" scoped></style>
