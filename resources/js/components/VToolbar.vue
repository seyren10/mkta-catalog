<template>
    <div class="flex items-center justify-between bg-stone-200 p-2">
        <slot name="title"></slot>
        <v-heading type="h3" v-if="!$slots.title" class="font-normal">{{
            title
        }}</v-heading>

        <slot />
    </div>
</template>

<script setup>
const props = defineProps({
    title: {
        type: String,
    },
});
</script>

<style lang="scss" scoped></style>
