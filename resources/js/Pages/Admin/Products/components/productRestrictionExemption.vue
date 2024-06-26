<template>
    <div class="rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-4 text-gray-800">
            This section identifies customers who cannot add the product to
            their Wishlist.
        </h2>
        <div class="text-gray-700">
            
            <accessType :product_id="id" :access_type_id="access_type.id" v-for="(access_type) in product_access_types" />
        </div>
    </div>
</template>
<script setup>

import accessType from "./essentials/accessType.vue";

import { onBeforeMount, ref, watch, inject, computed } from "vue";
import { storeToRefs } from "pinia";
const props = defineProps({
    id: String,
});
/*SECTION - Product Data */
import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_item } = storeToRefs(productStore);
if (!product_item.length && props.id != "") {
    await productStore.getProductItem(props.id);
}
/*SECTION - End Product Data */

/*SECTION - Restriction and Exemption */
import { useProductAccessTypeStore } from "@/stores/productAccessTypeStore";
const productAccessTypeStore = useProductAccessTypeStore();
const { product_access_types } = storeToRefs(productAccessTypeStore);
if (!product_access_types.length) {
    await productAccessTypeStore.getProductAccessTypes();
}
/*SECTION - End Restriction and Exemption */
</script>
