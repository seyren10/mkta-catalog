<template>
    <v-card>
        Non includeNonWishlistProducts
    </v-card>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const emit = defineEmits(["update"]);
const props = defineProps({
    id: String,
});

import { useCustomerStore } from "@/stores/customerStore";
const customerStore = useCustomerStore();
const { customer, form } = storeToRefs(customerStore);

if (!customer.length) {
    await customerStore.getCustomer(props.id);
}
</script>
