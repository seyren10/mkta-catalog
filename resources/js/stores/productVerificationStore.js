import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useProductVerificationStore = defineStore(
    "productVerification",
    () => {
        const { loading, exec, errors } = useAxios();

        async function verifyProduct(token) {
            const res = await exec("/api/product/bc-product-details", "get", {
                token,
            });

            return res.data?.data;
        }

        return {
            verifyProduct,
            errors,
            loading,
        };
    },
);
