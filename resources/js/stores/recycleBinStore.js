import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useRecycleBinStore = defineStore("recycleBin", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const getDeletedProductItems = async () => {
        try {
            const res = await exec("/api/recycle-bin/products", "get");
            return res.data.data;
        } catch (e) {
        } finally {
            
        }
    }
    const restoreDeletedProductItem = async (ref_id) => {
        try {
            const res = await exec("/api/recycle-bin/products/restore", "post", {
                ref_id : ref_id
            });
            return res.data.data;
        } catch (e) {
        } finally {
            
        }
    }

    return {
        getDeletedProductItems,
        restoreDeletedProductItem,


        loading,
        errors,
        exec,
    };
});
