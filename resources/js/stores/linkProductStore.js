import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useLinkProductStore = defineStore("linkProduct", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    /////////////////////////////////////////////////////////////
    const related_products = ref([]);
    const recommended_products = ref([]);

    const getRelatedProducts = async (product_id) => {
        let data = [];
        try {
            const res = await exec(
                ["/api/products/related", product_id].join("/"),
                "get",
            );
            related_products.value = res.data;
            return res.data;
        } catch (e) {
            console.log(e);

        } finally {
            return data;
        }
    };
    const appendRelatedProduct = async (parent_product, linked_product) => {
        try {
            const res = await exec(
                ["/api/products/related", parent_product, linked_product].join(
                    "/",
                ),
                "post",
            );
        } catch (e) {
            console.log(e);
        } finally {
        }
    };
    const removeRelatedProduct = async (link_id) => {
        try {
            const res = await exec(
                "/api/products/related/" + link_id,
                "delete",
            );
            console.log(res)
        } catch (e) {
            console.log(e);
        } finally {
        }
    };

    const getRecommendedProducts = async (product_id) => {
        let data = [];
        try {
            const res = await exec(
                ["/api/products/recommended", product_id].join("/"),
                "get",
            );
            recommended_products.value = res.data;
            return res.data;
        } catch (e) {
            console.log(e);
        } finally {
            return data;
        }
    };
    const appendRecommendedProduct = async (parent_product, linked_product) => {
        try {
            const res = await exec(
                [
                    "/api/products/recommended",
                    parent_product,
                    linked_product,
                ].join("/"),
                "post",
            );
        } catch (e) {
            console.log(e);
        } finally {
        }
    };
    const removeRecommededProduct = async (link_id) => {
        try {
            const res = await exec(
                "/api/products/recommended/" + link_id,
                "delete",
            );
        } catch (e) {
            console.log(e);
        } finally {
        }
    };

    return {
        related_products,
        recommended_products,

        getRelatedProducts,
        appendRelatedProduct,
        removeRelatedProduct,

        getRecommendedProducts,
        appendRecommendedProduct,
        removeRecommededProduct,
    };
});
