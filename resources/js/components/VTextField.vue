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
                {{ errorMessage }}
            </div>
        </template>
    </VInputWrapper>
</template>

<script setup>
import { useInput, useDensity, useDensityValues } from "@/composables/useInput";
import { useInputValidate } from "../composables/useInputValidate";

import VInputWrapper from "./base_components/VInputWrapper.vue";

defineOptions({
    inheritAttrs: false,
});

const model = defineModel({ default: "" });
const props = defineProps({
    ...useInput(),
    ...useDensity(),
    rules: {
        type: [Function, Array],
        default: []
    },
    errorMessages: {
        type: Object,
        default: {},
    },
});

const densityValues = useDensityValues(props.density);
const { errorMessage, isInputValid, validateInput } = useInputValidate(
    props.rules,
    props.errorMessages,
);

//derives

//methods
const handleValidation = () => {
    if (typeof props.rules === "function") {
        if (props.rules(model.value)) {
            isInputValid.value = false;
            errorMessage.value = "Invalid Input";
        } else {
            isInputValid.value = true;
        }
    } else validateInput(model.value);
};
</script>

<style lang="scss" scoped></style>
