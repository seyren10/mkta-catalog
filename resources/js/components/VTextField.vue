<template>
    <VInputWrapper v-bind="props">
        <template v-for="(_, slotName) in $slots" #[slotName]>
            <slot :name="slotName" />
        </template>

        <template v-slot:default="props">
            <input
                type="text"
                class="outline-none"
                v-bind="{ ...$attrs, ...props }"
                v-model="model"
            />
        </template>
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
