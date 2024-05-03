<template>
    <VInputWrapper v-slot="props" v-bind="props">
        <textarea
            class="w-full outline-none"
            v-bind="{ ...$attrs, ...props }"
            v-model="model"
        ></textarea>
    </VInputWrapper>
</template>

<script setup>
import VInputWrapper from "./base_components/VInputWrapper.vue";
import { useInput } from "@/composables/useInput";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps(useInput());
const model = defineModel();
</script>

<style lang="scss" scoped></style>
