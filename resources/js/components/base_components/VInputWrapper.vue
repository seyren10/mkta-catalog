<template>
    <div class="grid w-fit auto-cols-max grid-flow-col items-end">
        <div class="mb-1 mr-1">
            <v-icon
                v-if="prependIcon"
                :name="prependIcon"
                scale="1.5"
                class="fill-stone-400"
            ></v-icon>
        </div>
        <div class="grid">
            <div
                v-bind="$attrs['class']"
                class="peer order-2 grid min-h-10 grid-flow-col items-center gap-1 rounded-md border border-stone-400 bg-white px-2 py-1 duration-300 has-[:focus]:ring-2 has-[:focus]:ring-accent has-[:focus]:ring-offset-2"
            >
                <v-icon
                    v-if="prependInnerIcon"
                    :name="prependInnerIcon"
                    scale="1.5"
                    class="fill-stone-400"
                ></v-icon>
                <slot></slot>
            </div>

            <label
                :for="id"
                class="order-1 mb-0.5 text-sm duration-300 peer-has-[:focus]:text-accent"
                >{{ label }}</label
            >
        </div>
    </div>
</template>

<script setup>
defineOptions({
    inheritAttrs: false,
});
const props = defineProps({
    prependIcon: {
        type: String,
    },
    prependInnerIcon: {
        type: String,
    },
    label: {
        type: String,
    },
});
const id = Math.random();
</script>

<style lang="scss" scoped></style>
