import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { useAxios } from "@/composables/useAxios";

export const useWishlistStore = defineStore("wishlists", () => {
    const wishlists = ref([]);
    const { loading, errors, exec } = useAxios();

    const wishlistCount = computed(() => {
        return wishlists.value.length;
    });

    async function sendWishlist(payload) {
        const res = await exec("/api/customer-wishlist/send-wishlist", "post", {
            ...payload,
        });
    }
    async function sendProductInquiry(payload) {
        const res = await exec(
            "/api/customer-wishlist/product-inquery",
            "post",
            {
                ...payload,
            },
        );
    }

    const getWishlists = async () => {
        let data = [];
        try {
            loading.value = true;
            const res = await exec("/api/customer-wishlist");

            wishlists.value = res.data.data;
            data = wishlists.value;
        } catch (e) {
            errors.value = e;
        } finally {
            loading.value = false;
            return data;
        }
    };

    const addToWishlist = async (item) => {
        try {
            loading.value = true;
            await exec("/api/customer-wishlist", "post", {
                product_id: item.id,
            });
        } catch (e) {
            errors.value = e;
        } finally {
            loading.value = false;
        }
    };

    const deleteWishlist = async (wishlistId) => {
        try {
            loading.value = true;
            await exec(`/api/customer-wishlist/${wishlistId}`, "delete");
        } catch (e) {
            errors.value = e;
        } finally {
            loading.value = false;
        }
    };
    const deleteAllWishlist = async (item) => {
        try {
            loading.value = true;
            await exec(
                "/api/customer-wishlist/delete-all-user-wishlists",
                "delete",
            );
        } catch (e) {
            errors.value = e;
        } finally {
            loading.value = false;
        }
    };

    const isIncludedOnWishlist = (item) => {
        const searchItem = wishlists.value.find(
            (e) => e.product.id === item.id,
        );
        return searchItem;
    };

    return {
        wishlists,
        wishlistCount,
        addToWishlist,
        getWishlists,
        deleteWishlist,
        deleteAllWishlist,
        isIncludedOnWishlist,
        sendWishlist,
        sendProductInquiry,

        loading,
        errors,
        exec,
    };
});
