<template>
    <slot :props="{ close }">
        <div
            class="mb-2 flex items-center justify-between border-b p-3"
            :class="{ 'sticky top-0 z-[100] bg-white': fixedToolbar }"
            v-bind="$attrs"
        >
            <slot name="title">
                <h3 class="text-sm font-bold">{{ title }}</h3>
            </slot>

            <v-button
                icon="la-times-solid"
                @click="close()"
                icon-size=".9"
            ></v-button>
        </div>
    </slot>
</template>

<script setup>
import { inject } from "vue";
defineOptions({
    inheritAttrs: false,
});
const props = defineProps({
    title: String,
    fixedToolbar: Boolean,
});

const close = inject("close", () => {
    console.error("no close function provided on parent");
});
</script>

<style lang="scss" scoped></style>
