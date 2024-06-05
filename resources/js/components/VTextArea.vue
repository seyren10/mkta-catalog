<template>
    <VInputWrapper v-slot="props" v-bind="{ ...props, densityValues }">
        <textarea
            class="w-full outline-none"
            v-bind="{ ...$attrs, ...props }"
            v-model="model"
        ></textarea>
    </VInputWrapper>
</template>

<script setup>
import VInputWrapper from "./base_components/VInputWrapper.vue";
import { useInput, useDensity, useDensityValues } from "@/composables/useInput";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({ ...useInput(), ...useDensity() });
const model = defineModel();
const densityValues = useDensityValues(props.density);
</script>

<style lang="scss" scoped></style>
