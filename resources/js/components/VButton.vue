<template>
    <div class="flex items-center" v-if="!icon">
        <slot name="prepend"></slot>

        <template v-if="prependIcon">
            <v-icon :name="prependIcon" class="mr-2" scale="1.3"></v-icon>
        </template>
        <component
            :is="tag"
            v-bind="$attrs"
            :class="`group relative isolate flex items-center justify-center overflow-hidden rounded-md ${densityValue} disabled:cursor-not-allowed ${outlined ? 'border' : ''}`"
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
        </component>

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
import { useInput, useDensity, useDensityValues } from "@/composables/useInput";
import VLoader from "./base_components/VLoader.vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    ...useInput(),
    ...useDensity(),
    icon: { type: String },
    tag: { type: String, default: "button" },
    outlined: { type: Boolean, default: false },
});

const densityValue = useDensityValues(props.density);
</script>

<style lang="scss" scoped></style>
