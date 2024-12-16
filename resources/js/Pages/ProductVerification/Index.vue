<script setup>
import { RouterView, useRoute } from "vue-router";
import { useProductVerificationStore } from "@/stores/productVerificationStore";
import Tab from "./components/Tab.vue";
import { provide, ref } from "vue";

const route = useRoute();
const { verify, item } = useVerify();
await verify();

provide("item", item);

const tabItems = [
    {
        name: "Info",
        to: "verifyProductInformation",
        icon: "pr-info",
    },
    {
        name: "Category",
        to: "verifyProductCategory",
        icon: "md-category-outlined",
    },
    {
        name: "Images",
        to: "verifyProductImages",
        icon: "pr-images",
    },
    {
        name: "Restrictions and excemptions",
        to: "verifyProductRestrictionsAndExcemptions",
        icon: "pr-lock",
    },
    {
        name: "Related and recommended",
        to: "verifyProductRelatedAndRecommended",
        icon: "pr-share-alt",
    },
];

function useVerify() {
    const productVerificationStore = useProductVerificationStore();

    const token = route.query.token;
    const item = ref(null);

    async function verify() {
        item.value = await productVerificationStore.verifyProduct(token);
    }

    return {
        token,
        verify,
        item,
    };
}
</script>

<template>
    <div class="container mt-10 space-y-5 rounded-md bg-white py-5 text-xs">
        <div>
            <h1 class="text-lg">Product Verification</h1>
            <p class="text-xs text-gray-500">Please fill in the missing data</p>
        </div>

        <div class="space-y-2">
            <Tab :items="tabItems"> </Tab>
            <div class="rounded-md border p-3">
                <RouterView #default="{ Component }">
                    <KeepAlive>
                        <component :is="Component"></component>
                    </KeepAlive>
                </RouterView>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>
