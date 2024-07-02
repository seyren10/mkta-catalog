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
    <v-card class="border-0">
        <template #header>
            <div class="flex">
                <v-button
                    :prepend-inner-icon="tab.icon"
                    @click="selectedTab = tab.key"
                    v-for="tab in [
                        {
                            icon: 'fa-user-alt',
                            title: 'Account Information',
                            key: 'AccountInformation',
                        },
                        {
                            icon: 'la-map-marked-alt-solid',
                            title: 'Areas',
                            key: 'Areas',
                        },
                        {
                            icon: 'px-buildings',
                            title: 'Companies',
                            key: 'Companies',
                        },
                        {
                            icon: 'bi-cart-x',
                            title: 'Unwishlist Products',
                            key: 'UnwishlistProducts',
                        },
                    ]"
                    :class="
                        '  ' +
                        (selectedTab == tab.key ? 'bg-accent text-white' : '')
                    "
                >
                    {{ tab.title }}
                </v-button>
            </div>
        </template>
        <CustomerInformation v-show="selectedTab === 'AccountInformation'" :id="id" />
        <CustomerAreas v-show="selectedTab === 'Areas'" :id="id" />
    </v-card>
</template>
<script setup>
import CustomerInformation from "./components/CustomerInformation.vue";
import CustomerAreas from "./components/CustomerAreas.vue";

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const props = defineProps({
    id: String,
});

const router = inject("router");

import { useCustomerStore } from "@/stores/customerStore";
const customerStore = useCustomerStore();
const { customer, form } = storeToRefs(customerStore);
if (!customer.length) {
    await customerStore.getCustomer(props.id, {
        includeAreasData: true,
        includeCompaniesData: true,
        includeNonWishlistProducts: true,
        includeNonWishlistProductsKeys: true,
    });
}

const selectedTab = ref("AccountInformation");
</script>

<style lang="scss" scoped></style>
