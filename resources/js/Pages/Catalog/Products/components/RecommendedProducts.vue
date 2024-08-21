<template>
    <div class="my-6">
        <h2
            class="w-full border-b-2 py-2 text-[1.5rem] font-bold tracking-wide"
        >
            Recommended Products
        </h2>
        <div
            class="relative grid h-full auto-rows-min grid-cols-2 gap-5 rounded-lg bg-white p-5 md:grid-cols-3 lg:grid-cols-4"
        >
            <template
                v-for="(recProduct, relIndex) in product.recommended_product"
                :key="recProduct.product.id"
            >
                <Product_Card
                    no-overlay
                    class="overflow-hidden rounded-lg bg-primary text-white"
                    :item="recProduct.product"
                ></Product_Card>
            </template>
        </div>
    </div>
</template>

<script setup>
import Product_Card from "@/components/Product.vue";

import { inject, ref } from "vue";
const product = inject("product");
</script>

<style lang="scss" scoped></style>
