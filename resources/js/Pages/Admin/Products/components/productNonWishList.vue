<template>
    <div class="rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-4 text-gray-800">
            This section identifies customers who cannot add the product to
            their Wishlist.
        </h2>
        <div class="text-gray-700">
            <v-button
                class="my-2 ml-auto border"
                prepend-inner-icon="md-refresh-sharp"
                @click="refresh()"
                >Refresh</v-button
            >
            <h2 class="text-xl font-semibold">Restricted Customer(s)</h2>
            <v-chip-input
                clearable
                @remove="
                    async (item) => {
                        await nonWishlistStore.deleteNonWishlist(
                            NonWishListCustomers_data[item.id].id,
                        );
                        refresh();
                    }
                "
                @addItem="
                    async (item) => {
                        form.user_id = item.id;
                        await nonWishlistStore.addNonWishlist();
                        refresh();
                    }
                "
                :appendable="false"
                :items="myCustomers"
                v-model="NonWishListCustomers"
            />
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, ref, watch, inject, computed } from "vue";
import { storeToRefs } from "pinia";
/*SECTION - Customer Data */
import { useCustomerStore } from "@/stores/customerStore";
const customerStore = useCustomerStore();
const { customers } = storeToRefs(customerStore);
if (!customers.length) {
    await customerStore.getCustomers();
}
/*SECTION - End Customer Data */
/*SECTION - Product Data */
const product_item = inject("product_item");
const productStore = inject("productStore");

/*SECTION - End Product Data */

/*SECTION - Non Wishlist */
import { useNonWishlistStore } from "@/stores/nonWishlistStore";
const nonWishlistStore = useNonWishlistStore();
const { non_wishlist_data, form } = storeToRefs(nonWishlistStore);
form.value.product_id = product_item.value.id;
if (!non_wishlist_data.length) {
    nonWishlistStore.getNonWishlist("product", product_item.value.id);
}
/*SECTION - End of Non Wishlist */

const NonWishListCustomers = computed(() => {
    return non_wishlist_data.value.map((element) => {
        return {
            value: element.data.name,
            id: element.data.id,
        };
    });
});
const myCustomers = computed(() => {
    return customers.value.map((element) => {
        return {
            value: element.name,
            id: element.id,
        };
    });
});
const NonWishListCustomers_data = computed(() => {
    let def = non_wishlist_data.value.reduce((acc, element) => {
        acc[element.data.id] = element; // You can set any default value here
        return acc;
    }, {});
    return def;
});

const refresh = () => {
    nonWishlistStore.getNonWishlist("product", product_item.value.id);
};
</script>
