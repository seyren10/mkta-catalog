<template>
    <div class="rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-4 text-gray-800">
            This section identifies customers who cannot add the product to
            their Wishlist.
        </h2>
        <div class="text-gray-700">
            <v-chip-input
                @removeItem="(data)=>{ console.log(data) }"
                @appendItem="(data)=>{ console.log(data) }"
                clearable
                :appendable="false"
                :items="myCustomers"
                v-model="NonWishListCustomers"
            />
        </div>
        <pre>{{ myCustomers }}</pre>
    </div>
</template>
<script setup>
import { onBeforeMount, ref, watch, inject, computed } from "vue";
import { storeToRefs } from "pinia";

import { useCustomerStore } from "@/stores/customerStore";
const customerStore = useCustomerStore();

const { customers } = storeToRefs(customerStore);
if (!customers.length) {
    await customerStore.getCustomers();
}

import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { form, product_item } = storeToRefs(productStore);

const myCustomers = computed(() => {
    return customers.value.map((element) => {
        return {
            value: element.name,
            id: element.id,
        };
    });
});
// const NonWishListCustomers = ref([])
const NonWishListCustomers = ref(
    product_item.value.non_wishlist_users.map((element) => {
        return {
            value: element.user.name,
            id: element.user.id,
        };
    }),
);
</script>
