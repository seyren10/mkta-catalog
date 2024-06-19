<template>
    <div class="flex gap-3">
        <slot name="prepend">
            <v-icon
                :scale="iconSize"
                :name="prependIcon"
                v-if="prependIcon"
            ></v-icon>
        </slot>

        <div v-bind="$attrs" class="flex grow items-center">
            <slot name="prepend-inner">
                <v-icon
                    :scale="iconSize"
                    :name="prependInnerIcon"
                    v-if="prependInnerIcon"
                ></v-icon>
            </slot>

            <!-- main slot -->
            <slot />

            <slot name="append-inner">
                <v-icon
                    :scale="iconSize"
                    :name="appendInnerIcon"
                    v-if="appendInnerIcon"
                ></v-icon>
            </slot>
        </div>
        <slot name="append">
            <v-icon
                :scale="iconSize"
                :name="appendIcon"
                v-if="appendIcon"
            ></v-icon>
        </slot>
    </div>
</template>

<script setup>
import { useIcon } from "@/composables/useIcon";

defineOptions({
    inheritAttrs: false,
});
const props = defineProps({
    ...useIcon(),
    parentClass: String,
    iconSize: {
        type: [Number, String],
        default: "1.5",
    },
});
</script>

<style lang="scss" scoped></style>
