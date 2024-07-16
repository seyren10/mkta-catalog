<template>
    <RouterView v-slot="{ Component }">
        <template v-if="Component">
            <Suspense timeout="0">
                <component :is="Component" />

                <template v-slot:fallback>
                    <!-- <Spinner /> -->
                    <div class="absolute inset-0 grid place-content-center">
                        <VLoader scale="2"></VLoader>
                    </div>
                </template>
            </Suspense>
        </template>
    </RouterView>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { provide } from "vue";
import { useUserStore } from "@/stores/userStore";
import { useCategoryStore } from "@/stores/categoryStore";
import { useWishlistStore } from "./stores/wishlistStore";
import { useFilterStore } from "@/stores/filterStore";
import { useProductStore } from "./stores/productStore";
import { RouterView, useRouter } from "vue-router";

import VLoader from "./components/base_components/VLoader.vue";

const userStore = useUserStore();
const { currentUser } = storeToRefs(userStore);
const router = useRouter();

const categoryStore = useCategoryStore();
const productStore = useProductStore();
const wishlistStore = useWishlistStore();
const filterStore = useFilterStore();

provide("categoryStore", categoryStore);
provide("productStore", productStore);
provide("router", router);
provide("currentUser", currentUser);
provide("wishlistStore", wishlistStore);
provide("filterStore", filterStore);
provide("s3", (img) => {
    return `https://mkta-portal.s3.us-east-2.amazonaws.com/${img}`;
});
</script>
