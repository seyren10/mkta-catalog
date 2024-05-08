<template>
    <div class="flex items-center">
        <div class="mr-1">
            <v-icon v-if="prependIcon" :name="prependIcon" scale="1.3"></v-icon>
            <slot name="prepend"></slot>
        </div>
        <div class="grid grow">
            <div
                class=""
                :class="parentClass"
            >
                <v-icon
                    v-if="prependInnerIcon"
                    :name="prependInnerIcon"
                    scale="1.3"
                    class="mr-2"
                ></v-icon>
                <slot name="prepend-inner"></slot>
                <slot :id="id" class="grow"></slot>
                <v-icon
                    v-if="appendInnerIcon"
                    :name="appendInnerIcon"
                    scale="1.3"
                    color="#78716c"
                ></v-icon>
                <slot name="append-inner"></slot>
            </div>

            <label
                :for="id"
                class="order-1 mb-0.5 text-sm duration-300 peer-has-[:focus]:text-accent"
                >{{ label }}</label
            >
        </div>
        <div class="ml-1">
            <v-icon v-if="appendIcon" :name="appendIcon" scale="1.3"></v-icon>
            <slot name="append"></slot>
        </div>
    </div>
</template>

<script setup>
import { useInput } from "@/composables/useInput";

const props = defineProps(useInput());

const id = Math.random();
</script>

<style lang="scss" scoped></style>
