<template>
    <div class="py-2 grid gap-2 grid-cols-1 ">
        <div class="w-full flex justify-end ">
            <v-button @click="openNonWishListProducts" class=" bg-accent text-white"
                >
                <v-icon name="bi-cart-x" class="me-2" scale="1.2"></v-icon>
                Append Non Wishlist Products</v-button
            >
        </div>
        "Add to Wishlist" Button on the Product Items listed below will not be
        avaible to the customer.
        <v-text-field prepend-inner-icon="la-search-solid" v-model="search" />
        <v-data-table
            class="my-2 border-none"
            :noHeader="true"
            :headers="headers"
            :items="non_wishlist_data"
            :search="search"
        >
            <template #item.data="{ item }">
                <div class="grid grid-cols-12 gap-2 border py-2">
                    <div class="col-span-12 sm:col-span-3 lg:col-span-2">
                        <div class="grid w-full justify-items-center">
                            <v-text-on-image
                                class="h-[150px] max-h-[150px] w-[150px] max-w-[150px] border-none"
                                title="Thumbnail"
                                :noOverlay="true"
                                :image="
                                    s3(
                                        item.raw.data?.product_thumbnail?.file?.filename,
                                    )
                                "
                            />
                            <div>
                                <span class="text-center">{{
                                    item.raw.data.id
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-7">
                        <pre></pre>
                        <p class="text-xl">{{ item.raw.data.title }}</p>
                        <span class="text-gray-400">{{
                            item.raw.data.description
                        }}</span>
                    </div>
                    <div
                        class="col-span-12 flex items-center justify-center sm:col-span-3"
                    >
                        <v-button
                            class="bg-red-600 text-white"
                            @click="removeWishlistProducts(item.raw.id)"
                        >
                            <v-icon name="la-times-solid" class="me-2"></v-icon
                            >Show Wishlist button</v-button
                        >
                    </div>
                </div>
            </template>
        </v-data-table>
        <v-dialog
            persistent
            title="Non Wishlist Products"
            v-model="insertNonWishlistProducts"
            @close="closeNonWishlistProducts()"
        >
            <div class="min-w-[800px] p-5">
                <ProductList
                    @close="closeNonWishlistProducts()"
                    @cancel="closeNonWishlistProducts()"
                    @submitSelection="appendNonWishlistProducts"
                />
            </div>
        </v-dialog>
    </div>
</template>
<script setup>
import ProductList from "../../Products/reusableComponents/Index.vue";

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const s3 = inject("s3");

const emit = defineEmits(["update"]);
const props = defineProps({
    id: String,
});

import { useCustomerStore } from "@/stores/customerStore";
const customerStore = useCustomerStore();
const { customer } = storeToRefs(customerStore);
const refresh = async () => {
    await customerStore.getCustomer(props.id);
};
if (!customer.length) {
    refresh();
}


/*SECTION - Non Wishlist */
import { useNonWishlistStore } from "@/stores/nonWishlistStore";
const nonWishlistStore = useNonWishlistStore();
const { non_wishlist_data, form } = storeToRefs(nonWishlistStore);
const refreshNonWishListProduct = async () => {
    await nonWishlistStore.getNonWishlist("customer", props.id);
};
refreshNonWishListProduct();
/*SECTION - End of Non Wishlist */
const search = ref("");
const headers = ref([
    {
        value: "",
        key: "data",
        hidden: false,
        sortable: false,
    },
]);

const insertNonWishlistProducts = ref(false);
const closeNonWishlistProducts = () => {
    insertNonWishlistProducts.value = false;
    refreshNonWishListProduct();
};
const openNonWishListProducts = () => {
    insertNonWishlistProducts.value = true;
};

const appendNonWishlistProducts = (data) => {
    data.forEach((element) => {
        form.value.product_id = element.id;
        form.value.user_id = props.id;
        nonWishlistStore.addNonWishlist();
    });
    closeNonWishlistProducts();
};

const removeWishlistProducts = async (id) => {
    await nonWishlistStore.deleteNonWishlist(id)
    refreshNonWishListProduct();
};
</script>
