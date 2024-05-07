<template>
    <div class="flex self-start">
        <div class="mr-1 mt-7">
            <v-icon v-if="prependIcon" :name="prependIcon" scale="1.5"></v-icon>
            <slot name="prepend"></slot>
        </div>
        <div class="grid grow">
            <div
                v-bind="$attrs['class']"
                class="peer order-2 flex min-h-10 gap-1 rounded-md border border-stone-400 bg-white px-2 py-1 duration-300 has-[:disabled]:bg-stone-200 has-[:focus]:ring-2 has-[:focus]:ring-accent has-[:focus]:ring-offset-2"
            >
                <v-icon
                    v-if="prependInnerIcon"
                    :name="prependInnerIcon"
                    scale="1.5"
                ></v-icon>
                <slot name="prepend-inner"></slot>

                <slot :id="id" class="grow"></slot>
                <v-icon
                    v-if="appendInnerIcon"
                    :name="appendInnerIcon"
                    scale="1.5"
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
        <div class="ml-1 mt-7">
            <v-icon v-if="appendIcon" :name="appendIcon" scale="1.5"></v-icon>
            <slot name="append"></slot>
        </div>
    </div>
</template>

<script setup>
import { useInput } from "@/composables/useInput";
defineOptions({
    inheritAttrs: false,
});

const props = defineProps(useInput());

const id = Math.random();
</script>

<style lang="scss" scoped></style>
