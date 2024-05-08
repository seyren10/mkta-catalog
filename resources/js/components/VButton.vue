<template>
    <VInputWrapper v-slot="props" v-bind="props">
        <button v-bind="{ ...props, ...$attrs }" class="grow">
            <slot />
        </button>
    </VInputWrapper>
</template>

<script setup>
import VInputWrapper from "./base_components/VInputWrapper.vue";
import { useInput } from "@/composables/useInput";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    ...useInput(),
});
</script>

<style lang="scss" scoped></style>
