<script setup>
const props = defineProps({
    title: String,
    description: String,
});
const showDialog = defineModel("showDialog", { default: false });
const selectedProducts = defineModel("selectedProducts", { default: [] });
</script>

<template>
    <div>
        <h3 class="mb-2 text-[1rem]">{{ title }}</h3>
        <slot name="description">
            <p class="mb-2 text-gray-500">
                {{ description }}
            </p>
        </slot>
        <div class="flex items-center gap-2">
            <v-button
                class="border bg-none font-medium text-primary shadow-sm"
                @click="showDialog = true"
                >Select</v-button
            >
            <span class="text-gray-500" v-if="selectedProducts?.length"
                >{{ selectedProducts.length }} products selected</span
            >
            <span class="text-gray-500" v-else
                >There are no selected products</span
            >
        </div>
    </div>
</template>

<style lang="scss" scoped></style>
