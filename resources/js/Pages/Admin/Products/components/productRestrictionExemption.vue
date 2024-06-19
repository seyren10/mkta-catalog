<template>
    <div class="rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-4 text-gray-800">
            This section identifies customers who cannot add the product to
            their Wishlist.
        </h2>
        <div class="text-gray-700"></div>
    </div>
</template>
<script setup></script>

</template>
<script setup>
import { onBeforeMount, ref, watch, inject } from "vue";
import { storeToRefs } from "pinia";

import { useCustomerStore } from "@/stores/customerStore";
const customerStore = useCustomerStore();


import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { form, product_item } = storeToRefs(productStore);

</script>
