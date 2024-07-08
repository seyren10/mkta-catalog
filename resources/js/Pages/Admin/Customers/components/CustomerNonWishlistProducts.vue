<template>
    <div>
        "Add to Wishlist" Button on the Product Items listed below will not be
        avaible to the customer.
        <v-text-field prepend-inner-icon="la-search-solid" v-model="search" />
        <v-data-table
            class="my-2"
            :headers="headers"
            :items="customer.non_wishlist_products"
            :search="search"
        >
            <template #item.data="{ item }">
                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-2">
                        <div class="grid justify-items-center">
                            <v-text-on-image
                                class="h-[150px] max-h-[150px] w-[150px] max-w-[150px] border"
                                title="Thumbnail"
                                :noOverlay="true"
                                :image="'/fuck'"
                            />
                            <div>
                                <span class="text-center">{{
                                    item.raw.id
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-8">
                        <p class="text-xl">{{ item.raw.title }}</p>
                        <span class="text-gray-400">{{
                            item.raw.description
                        }}</span>
                    </div>
                    <div class="col-span-2 flex items-center justify-center">
                        <v-button class=" bg-red-600 text-white"> <v-icon name="la-times-solid" class="me-2 "></v-icon>Remove</v-button>
                    </div>
                </div>
            </template>
        </v-data-table>
    </div>
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

const search = ref("");
const headers = ref([
    {
        value: "",
        key: "data",
        hidden: false,
        sortable: false,
    },
]);
</script>
