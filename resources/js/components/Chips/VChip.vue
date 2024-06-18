<template>
    <VIconWrapper
        class="grow-0 gap-1 rounded-full bg-slate-200 px-3 py-2 text-slate-400"
        v-bind="props"
    >
        <template v-for="(_, slotName) in $slots" #[slotName]>
            <slot :name="slotName"></slot>
        </template>

        <slot>Chip</slot>
    </VIconWrapper>
</template>

<script setup>
import { useIcon } from "@/composables/useIcon";
import VIconWrapper from "../base_components/VIconWrapper.vue";

const props = defineProps({
    ...useIcon(),
    iconSize: String,
});
</script>

<style lang="scss" scoped></style>
