<template>
    <div class="col-span-full">
        <FeaturedProducts
            :items="products"
            :title-icon="icon"
            :title="title"
            :display-limit="limit"
        ></FeaturedProducts>
    </div>
</template>

<script setup>
import { computed } from "vue";

import FeaturedProducts from "../components/FeaturedProducts.vue";

const props = defineProps({
    data: Object,
});

const title = computed(() => props.data.title);
const products = computed(() => props.data.selectedProducts);
const limit = computed(() => props.data.limit);
const icon = computed(() => props.data.selectedIcon);
</script>

<style lang="scss" scoped></style>
