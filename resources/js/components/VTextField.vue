<template>
    <VInputWrapper v-slot="props" v-bind="props">
        <input
            type="text"
            class="outline-none"
            v-bind="{ ...$attrs, ...props }"
            v-model="model"
        />
    </VInputWrapper>
</template>

<script setup>
import VInputWrapper from "./base_components/VInputWrapper.vue";
import { useInput } from "@/composables/useInput";

defineOptions({
    inheritAttrs: false,
});

const model = defineModel();
const props = defineProps(useInput());
</script>

<style lang="scss" scoped></style>
