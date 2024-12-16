import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { ref } from "vue";

export const useProductVerificationStore = defineStore(
    "productVerification",
    () => {
        const { loading, exec, errors } = useAxios();

        const form = ref({
            info: null,
            category: null,
            images: null,
            restrictionAndExcemption: null,
            related: null,
            recommended: null,
        });

        async function verifyProduct(token) {
            const res = await exec("/api/product/bc-product-details", "get", {
                token,
            });

            return res.data?.data;
        }

        async function sendProduct() {
            console.log(form.value);
        }

        return {
            verifyProduct,
            sendProduct,
            errors,
            loading,
            form,
        };
    },
);
