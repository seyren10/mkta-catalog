<template>
    <div class="flex gap-3">
        <slot name="prepend"></slot>
        <v-icon scale="1.5" :name="prependIcon" v-if="prependIcon"></v-icon>
        <div v-bind="$attrs" class="grow">
            <slot name="prepend-inner"></slot>
            <v-icon
                scale="1.5"
                :name="prependInnerIcon"
                v-if="prependInnerIcon"
            ></v-icon>

            <slot />

            <slot name="append-inner"></slot>
            <v-icon
                scale="1.5"
                :name="appendInnerIcon"
                v-if="appendInnerIcon"
            ></v-icon>
        </div>
        <slot name="append"></slot>
        <v-icon scale="1.5" :name="appendIcon" v-if="!$slots.append"></v-icon>
    </div>
</template>

<script setup>
import { useIcon } from "@/composables/useIcon";

defineOptions({
    inheritAttrs: false,
});
const props = defineProps({ ...useIcon(), parentClass: String });
</script>

<style lang="scss" scoped></style>
