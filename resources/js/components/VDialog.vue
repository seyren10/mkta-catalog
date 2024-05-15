<template>
    <div>
        <slot name="activator"></slot>

        <template v-if="!$slots.activator"> </template>

        <Teleport to="#overlay" v-if="modelValue">
            <VDialogContent
                v-bind="{ maxWidth, title, persistent }"
                @close="$emit('update:modelValue', false)"
            >
                <template #header v-if="$slots.header">
                    <slot name="header"></slot>
                </template>
                <slot></slot
            ></VDialogContent>
        </Teleport>
    </div>
</template>

<script setup>
import { onUpdated } from "vue";
import VDialogContent from "./derived_components/VDialogContent.vue";

const props = defineProps(["modelValue", "maxWidth", "title", "persistent"]);
const emits = defineEmits(["update:modelValue"]);

defineOptions({
    inheritAttrs: false,
});

onUpdated(() => {
    if (props.modelValue) {
        document
            .querySelector("body")
            .classList.add("h-full", "overflow-hidden");
    } else {
        document
            .querySelector("body")
            .classList.remove("h-full", "overflow-hidden");
    }
});
</script>

<style lang="scss" scoped></style>
