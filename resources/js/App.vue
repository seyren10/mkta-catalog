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
import { useWishlistUIStore } from "./stores/ui/wishlistUIStore";
import { useProductStore } from "./stores/productStore";
import { RouterView, useRouter } from "vue-router";

import VLoader from "./components/base_components/VLoader.vue";

const userStore = useUserStore();
const { currentUser } = storeToRefs(userStore);
const router = useRouter();

const categoryStore = useCategoryStore();
const productStore = useProductStore();
const wishlistUIStore = useWishlistUIStore();

provide("categoryStore", categoryStore);
provide("productStore", productStore);
provide("router", router);
provide("currentUser", currentUser);
provide("wishlistUIStore", wishlistUIStore);
provide("s3", (img) => {
    return `https://mkta-portal.s3.us-east-2.amazonaws.com/${img}`;
});
</script>
