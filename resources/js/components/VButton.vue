<template>
    <div class="flex items-center" v-if="!icon">
        <slot name="prepend"></slot>

        <template v-if="prependIcon">
            <v-icon :name="prependIcon" class="mr-2" scale="1.3"></v-icon>
        </template>
        <button
            v-bind="$attrs"
            class="group relative isolate flex items-center justify-center overflow-hidden rounded-md px-3 py-2 disabled:cursor-not-allowed"
            :disabled="loading"
        >
            <template v-if="!loading">
                <!-- HOVERING EFFECT -->
                <div
                    class="absolute inset-0 -z-10 duration-500 group-hover:backdrop-brightness-125"
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
            </template>
            <template v-else>
                <VLoader class="mr-1" scale="1.3" />
            </template>

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
    <button
        v-else="icon"
        v-bind="$attrs"
        :disabled="loading"
        class="grid items-center rounded-full p-1 duration-500 hover:bg-stone-300 disabled:cursor-not-allowed"
    >
        <v-icon :name="icon" scale="1.5" v-if="!loading"></v-icon>
        <VLoader v-else />
    </button>
</template>

<script setup>
import { useInput } from "@/composables/useInput";
import VLoader from "./base_components/VLoader.vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    ...useInput(),
    icon: { type: String },
});
</script>

<style lang="scss" scoped></style>
