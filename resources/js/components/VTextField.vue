<template>
    <VInputWrapper v-bind="{ ...props, densityValues }">
        <template v-for="(_, slotName) in $slots" #[slotName]>
            <slot :name="slotName" />
        </template>

        <template v-slot:default="props">
            <input
                type="text"
                class="w-full outline-none"
                v-bind="{ ...props, ...$attrs }"
                v-model="model"
            />
            <span class="text-sm">{{ hint }}</span>
        </template>
        <template #append-inner v-if="clearable && model.length > 0">
            <div @click="model = ''" class="cursor-pointer">
                <v-icon name="md-close-round" />
            </div>
        </template>
    </VInputWrapper>
</template>

<script setup>
import { computed } from "vue";
import VInputWrapper from "./base_components/VInputWrapper.vue";
import { useInput, useDensity, useDensityValues } from "@/composables/useInput";

defineOptions({
    inheritAttrs: false,
});

const model = defineModel();
const props = defineProps({
    ...useInput(),
    ...useDensity(),
    clearable: Boolean,
    persistentHint: Boolean,
    hint : { type: String, default: '' },
});

const densityValues = useDensityValues(props.density);
</script>

<style lang="scss" scoped></style>
