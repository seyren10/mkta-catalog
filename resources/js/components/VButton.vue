<template>
    <div class="flex items-center">
        <slot name="prepend"></slot>

        <template v-if="prependIcon">
            <v-icon :name="prependIcon" class="mr-2" scale="1.3"></v-icon>
        </template>
        <button
            v-bind="$attrs"
            class="group relative isolate flex items-center justify-center overflow-hidden rounded-md px-3 py-2"
        >
            <!-- HOVERING EFFECT -->
            <div
                class="absolute inset-0 -z-10 duration-500 group-hover:backdrop-brightness-75"
            ></div>
            <!-- /HOVERING EFFECT -->
            <template v-if="prependInnerIcon">
                <v-icon
                    :name="prependInnerIcon"
                    class="mr-1"
                    scale="1.3"
                ></v-icon>
            </template>
            <slot name="prepend-inner"></slot>

            <slot />

            <template v-if="appendInnerIcon">
                <v-icon
                    :name="appendInnerIcon"
                    class="ml-1"
                    scale="1.3"
                ></v-icon>
            </template>
            <slot name="append-inner"></slot>
        </button>

        <slot name="append"></slot>
        <template v-if="appendIcon">
            <v-icon :name="appendIcon" class="ml-2" scale="1.3"></v-icon>
        </template>
    </div>
</template>

<script setup>
import { useInput } from "@/composables/useInput";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    ...useInput(),
});
</script>

<style lang="scss" scoped></style>
