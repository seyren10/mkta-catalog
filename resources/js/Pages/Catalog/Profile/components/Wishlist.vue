<template>
    <div class="grid gap-5 p-5 text-sm">
        <h3 class="text-lg font-bold">Summary:</h3>
        <ul class="scrollbar grid max-h-[30rem] gap-3 overflow-y-auto py-3">
            
            <li v-if="wishlistStore.wishlists.length == 0">
                No Wishlist
            </li>
            <li
                v-for="item in wishlistStore.wishlists"
                :key="item.id"
                class="flex gap-3 border-b p-3"
            >
                <WishlistItem
                    :item="item"
                    @delete="
                        async (item) => {
                            await wishlistStore.deleteWishlist(item);
                            await wishlistStore.getWishlists();
                        }
                    "
                ></WishlistItem>
            </li>
        </ul>
        <v-button
            v-if="wishlistStore.wishlists.length"
            class="ml-auto bg-red-500 text-xs text-white"
            @click="
                async () => {
                    await wishlistStore.deleteAllWishlist();
                    await wishlistStore.getWishlists();
                }
            "
            :loading="loading"
            >clear all</v-button
        >
    </div>
</template>
<script setup>
//!SECTION -> Required Init
import { inject, ref } from "vue";
import { storeToRefs } from "pinia";
//!SECTION - Stores

import WishlistItem from "../../../../Layouts/components/catalog/WishlistItem.vue";

const wishlistStore = inject("wishlistStore");
</script>
