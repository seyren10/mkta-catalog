<template>
    <VInputWrapper v-bind="{ ...props, densityValues }">
        <template v-for="(_, slotName) in $slots" #[slotName]>
            <slot :name="slotName" />
        </template>

        <template v-slot:default="slotProps">
            <input
                type="text"
                class="w-full outline-none"
                v-bind="{ ...slotProps, ...$attrs }"
                v-model="model"
                @blur="handleValidation"
            />
        </template>

        <template #message="slotProps" v-if="!isInputValid">
            <div v-bind="slotProps" class="!text-red-500">
                {{ error }}
            </div>
        </template>
    </VInputWrapper>
</template>

<script setup>
import { computed, ref } from "vue";
import VInputWrapper from "./base_components/VInputWrapper.vue";
import { useInput, useDensity, useDensityValues } from "@/composables/useInput";

defineOptions({
    inheritAttrs: false,
});

const model = defineModel();
const props = defineProps({
    ...useInput(),
    ...useDensity(),
    rules: {
        type: [Function, Array],
    },
    error: {
        type: String,
    },
});

const densityValues = useDensityValues(props.density);
const isInputValid = ref(true);

//derives

//methods
const handleValidation = () => {
    if (!props.rules) return;

    if (typeof props.rules !== "function") {
        if (!props.rules.length || props.rules.includes("required")) {
            isInputValid.value = model.value
                ? model.value.trim() !== ""
                : false;
        }

        return;
    }

    //for rules as function , it should return a boolean
    if (props.rules(model.value ?? "")) {
        isInputValid.value = true;
    } else {
        isInputValid.value = false;
    }
};
</script>

<style lang="scss" scoped></style>
