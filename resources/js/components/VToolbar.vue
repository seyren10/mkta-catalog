<template>
    <VIconWrapper>
        <template v-for="(_, slotName) in $slots" #[slotName]>
            <slot :name="slotName"></slot>
        </template>

        <header class="flex items-center justify-between p-2">
            <slot name="title">
                <v-heading type="h3" class="font-normal">{{ title }}</v-heading>
            </slot>

            <slot />
        </header>
    </VIconWrapper>
</template>

<script setup>
import { useIcon } from "@/composables/useIcon";
import VIconWrapper from "./base_components/VIconWrapper.vue";

const props = defineProps({
    ...useIcon(),
    title: {
        type: String,
    },
});
</script>

<style lang="scss" scoped></style>
