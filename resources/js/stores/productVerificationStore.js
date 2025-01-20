import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { ref } from "vue";

export const useProductVerificationStore = defineStore(
    "productVerification",
    () => {
        const { loading, exec, errors } = useAxios();

        const form = ref({
            token: null,
            info: null,
            category: null,
            images: null,
            restrictionAndExcemption: null,
            related: null,
            recommended: null,
        });

        const item = ref();

        async function verifyProduct(token) {
            const res = await exec("/api/product/bc-product-details", "get", {
                token,
            });

            item.value = res.data?.data;

            return res.data?.data;
        }

        async function sendProduct(token) {
            form.value.token = token;

            const res = await exec(
                "/api/product/store-product-verification",
                "post",
                form.value,
            );
        }

        async function temporarySaveImages(productId, images) {
            const res = exec(
                `/api/product/temp-image-upload/${productId}`,
                "post",
                {
                    images,
                },
            );
        }
        async function getTemporaryImages(productId) {
            const res = await exec(
                `/api/product/temp-image-upload/${productId}`,
            );

            return res.data?.data;
        }

        return {
            verifyProduct,
            sendProduct,
            temporarySaveImages,
            getTemporaryImages,
            errors,
            loading,
            form,
            item,
        };
    },
);
