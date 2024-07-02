<template>
    <RouterView v-slot="{ Component }">
        <template v-if="Component">
            <Suspense timeout="0">
                <component :is="Component" />

                <template v-slot:fallback>
                    <!-- <Spinner /> -->
                    <h1>Loading....</h1>
                </template>
            </Suspense>
        </template>
    </RouterView>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { provide } from "vue";
import { RouterView } from "vue-router";
import { useUserStore } from "@/stores/userStore";
import { useCategoryStore } from "@/stores/categoryStore";
import { useWishlistUIStore } from "./stores/ui/wishlistUIStore";
import { useProductStore } from "./stores/productStore";

const userStore = useUserStore();
const { user } = storeToRefs(userStore);

const categoryStore = useCategoryStore();
const productStore = useProductStore();
const wishlistUIStore = useWishlistUIStore();

provide("currentUser", user);
provide("categoryStore", categoryStore);
provide("productStore", productStore);
provide("wishlistUIStore", wishlistUIStore);
</script>
