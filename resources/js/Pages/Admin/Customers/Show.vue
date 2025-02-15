<template>
    <div class="mb-2">
        <v-heading type="h2">
            <v-icon
                v-if="$route.meta.redirectTo"
                @click="
                    () => {
                        router.push({ name: $route.meta.redirectTo });
                    }
                "
                name="la-arrow-circle-left-solid"
                scale="1.8"
            ></v-icon
            >{{ $route.meta.title }}</v-heading
        >
        <p>
            {{ $route.meta.description }}
        </p>
    </div>
    <div class="border-0">
        <v-tab
            headerClass=" bg-white"
            no-navigation
            v-model="selectedTab"
            :tabs="tabs"
        >
            <template class="p-3" #content.AccountInformation>
                <CustomerInformation @update="()=>{
                    customerStore.updateCustomer(id)
                    getCustomer();
                }"
                 />
            </template>
            <template class="p-3" #content.Areas>
                <CustomerAreas
                    @modify_area="
                        (mode, area_id) => {
                            customerStore.modifyCustomerAreas(mode, area_id);
                            getCustomer();
                        }
                    "
                />
            </template>
            <template class="p-3" #content.Companies>
                <CustomerCompanies
                    @modify_company="
                        (mode, company_id) => {
                            customerStore.modifyCustomerCompanies(
                                mode,
                                company_id,
                            );
                            getCustomer();
                        }
                    "
                />
            </template>
            <template class="p-3" #content.WishlistProducts>
                <CustomerWishlistProducts />
            </template>
        </v-tab>
    </div>
</template>
<script setup>
import CustomerInformation from "./components/CustomerInformation.vue";
import CustomerAreas from "./components/CustomerAreas.vue";
import CustomerCompanies from "./components/CustomerCompanies.vue";
import CustomerNonWishlistProducts from "./components/CustomerNonWishlistProducts.vue";
import CustomerWishlistProducts from "./components/CustomerWishlistProducts.vue";

import { onBeforeMount, ref, watch, computed, inject, provide } from "vue";
import { storeToRefs } from "pinia";

const props = defineProps({
    id: String,
});

const router = inject("router");

const selectedTab = ref("AccountInformation");
const tabs = ref([
    {
        icon: "fa-user-alt",
        iconScale: "1.5",
        title: "Account Information",
        value: "AccountInformation",
    },
    {
        icon: "la-map-marked-alt-solid",
        iconScale: "1.5",
        title: "Areas",
        value: "Areas",
    },
    {
        icon: "px-buildings",
        iconScale: "1.5",
        title: "Companies",
        value: "Companies",
    },
    {
        icon: "bi-cart4",
        iconScale: "1.5",
        title: "Wishlist",
        value: "WishlistProducts",
    },
    // {
    //     icon: "bi-cart-x",
    //     iconScale: "1.5",
    //     title: "Unwishlist Products",
    //     value: "UnwishlistProducts",
    // },
]);

//!SECTION - Customer
import { useCustomerStore } from "@/stores/customerStore";
const customerStore = useCustomerStore();
const { customer, form } = storeToRefs(customerStore);
const getCustomer = async () => {
    await customerStore.getCustomer(props.id, {
        includeAreasData: true,
        includeCompaniesData: true,
        includeNonWishlistProducts: true,
        includeNonWishlistProductsKeys: true,
    });
};
if (!customer.length) {
    await getCustomer();
}

provide("customerStore", customerStore);

provide(
    "customer",
    computed(() => customer.value),
);
provide(
    "form",
    computed(() => form.value),
);

//!SECTION - Area
import { useAreaStore } from "@/stores/areaStore";
const areaStore = useAreaStore();
const { areas } = storeToRefs(areaStore);
if (!areas.length) {
    await areaStore.getAreas();
}
provide("areas", areas.value);

//!SECTION - Company
import { useCompanyStore } from "@/stores/companyStore";
const companyStore = useCompanyStore();
const { companies } = storeToRefs(companyStore);
await companyStore.getCompanies();

provide("companies", companies.value);
</script>

<style lang="scss" scoped></style>
