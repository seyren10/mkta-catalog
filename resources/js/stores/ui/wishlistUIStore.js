import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useWishlistUIStore = defineStore("wishlistUI", () => {
    const wishlists = ref([]);

    const wishlistCount = computed(() => {
        return wishlists.value.length;
    });

    const addToWishlist = (item) => {
        wishlists.value.push(item);
    };

    const removeFromWishlist = (item) => {
        wishlists.value = wishlists.value.filter((e) => e.id !== item.id);
    };

    const isIncludedOnWishlist = (item) => {
        const searchItem = wishlists.value.find((e) => e.id === item.id);
        return searchItem;
    };

    return {
        wishlists,
        wishlistCount,
        addToWishlist,
        removeFromWishlist,
        isIncludedOnWishlist,
    };
});
