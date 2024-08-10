import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useNonWishlistStore = defineStore("nonWishlist", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const non_wishlist_data = ref([]);
    const form = ref({
        product_id: 0,
        user_id: 0,
    });
    const resetForm = () => {
        form.product_id = 0;
        form.user_id = 0;
    };
    const getNonWishlist = async (type, value, requestData = null) => {
        try {
            const defaultData = {
                type: type,
                value: value,
            };
            const res = await exec("/api/non-wishlist", "get", 
                {...requestData,
                ...defaultData,}
            );
            non_wishlist_data.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const addNonWishlist = async () => {
        try {
            const res = await exec("/api/non-wishlist", "post", form);
        } catch (e) {
            console.log(e);
        }
    }; 

    const deleteNonWishlist = async (id) => {
        try {
            const res = await exec("/api/non-wishlist/" + id, "delete");
        } catch (e) {
            console.log(e);
        }
    };

    return {
        getNonWishlist,
        addNonWishlist,
        deleteNonWishlist,

        non_wishlist_data,
        form
    };
});
