<template>
    <ul class="grid grid-cols-2 p-3 md:grid-cols-6 gap-2">
        <li v-for="item in items" :key="item.id">
            <Product :item="item" no-overlay></Product>
        </li>
    </ul>
</template>

<script setup>
import Product from "@/components/Product.vue";
const props = defineProps({
    items: Array,
});
</script>

<style lang="scss" scoped></style>
