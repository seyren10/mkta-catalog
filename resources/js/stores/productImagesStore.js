import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useProductImageStore = defineStore("productImages", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const productImages = ref([]);
    const productImage = ref([]);

    const form = ref({
        product_id: 0,
        is_thumbnail: 0,
        file_id: 0,
        index: 100,
    });
    const resetForm = () => {
        form.value.product_id = 0;
        form.value.is_thumbnail = 0;
        form.value.file_id = 0;
        form.value.index = 100;
    };
    const moveProductImage = async (id, step) => {
        try {
            const res = await exec("/api/product-images/" + id, "patch", {
                step: step,
            });
            resetForm();
        } catch (e) {
            console.log(e);
        }
    };
    const insertProductImage = async () => {
        try {
            const res = await exec("/api/product-images", "post", form.value);
        } catch (e) {
            console.log(e);
        }
    };
    const insertProductImage_2 = async (product_id, file_id, index = 100) => {
        try {
            const res = await exec("/api/product-images", "post", {
                product_id: product_id,
                file_id: file_id,
                index: index,
            });
        } catch (e) {
            console.log(e);
        }
    };
    const setThumbnail = async (id) => {
        try {
            const res = await exec("/api/product-images/" + id, "put");
            resetForm();
        } catch (e) {
            console.log(e);
        }
    };
    const deleteProductImage = async (id) => {
        try {
            const res = await exec("/api/product-images/" + id, "delete");
            resetForm();
        } catch (e) {
            console.log(e);
        }
    };
    const getProductImage = async (product_id) => {
        try {
            const res = await exec("/api/product-images/" + product_id);
            productImage.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const getProductImage_2 = async (product_id) => {
        try {
            const res = await exec("/api/product-images/" + product_id);
            return res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const getProductImages = async () => {
        try {
            const res = await exec("/api/product-images");
            productImages.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const updateProductImages = async () => {
        try {
            const res = await exec("/api/product-images-batch", "post", {
                product_images: productImage.value,
            });
        } catch (e) {
            console.log(e);
        }
    };
    const updateProductImages_2 = async (images) => {
        try {
            const res = await exec("/api/product-images-batch", "post", {
                product_images: images,
            });
        } catch (e) {
            console.log(e);
        }
    };

    return {
        updateProductImages_2,
        updateProductImages,
        resetForm,
        insertProductImage,
        setThumbnail,
        deleteProductImage,
        getProductImage,
        getProductImage_2,
        getProductImages,
        
        moveProductImage,
        insertProductImage_2,

        loading,
        errors,
        form,
        exec,
        productImage,
        productImages,
    };
});
