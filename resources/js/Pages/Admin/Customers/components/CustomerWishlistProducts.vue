<template>
    <div>
        "Add to Wishlist" Button on the Product Items listed below will not be
        avaible to the customer.
        <v-text-field prepend-inner-icon="la-search-solid" v-model="search" />
        <!-- <v-data-table
            class="my-2 border-none"
            :noHeader="true"
            :headers="headers"
            :items="customer.non_wishlist_products"
            :search="search"
        >
            <template #item.data="{ item }">
                <div class="grid grid-cols-12 gap-2 border py-2">
                    <div class=" col-span-12 sm:col-span-3 lg:col-span-2 ">
                        <div class="grid justify-items-center w-full">
                            <v-text-on-image
                                class="h-[150px] max-h-[150px] w-[150px] max-w-[150px] border-none"
                                title="Thumbnail"
                                :noOverlay="true"
                                :image="s3(item.raw?.product_thumbnail?.file?.filename)"
                            />
                            <div>
                                <span class="text-center">{{
                                    item.raw.id
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div class=" col-span-12 sm:col-span-10 ">
                        <pre>
                            
                        </pre>
                        <p class="text-xl">{{ item.raw.title }}</p>
                        <span class="text-gray-400">{{
                            item.raw.description
                        }}</span>
                    </div>
                </div>
            </template>
        </v-data-table> -->
    </div>       
</template>
<script setup>



import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const s3 = inject("s3");


const emit = defineEmits(["update"]);
const props = defineProps({
    id: String,
});

import { useCustomerStore } from "@/stores/customerStore";
const customerStore = useCustomerStore();
const { customer, form } = storeToRefs(customerStore);
const refresh = async()=>{
    await customerStore.getCustomer(props.id);
}


if (!customer.length) {
    refresh();
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
