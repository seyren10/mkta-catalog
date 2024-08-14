import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useProductStore = defineStore("products", () => {
    //states
    const router = useRouter();
    const { loading, errors, exec } = useAxios();
    const form = ref({
        id: "",
        parent_code: "",
        title: "",
        description: "",

        volume: 0.0,

        weight_net: 0.0,
        weight_gross: 0.0,

        dimension_length: 0.0,
        dimension_width: 0.0,
        dimension_height: 0.0,
    });

    const product_item = ref(null);

    const pagination = ref(null);

    const product_items = ref([]);

    //computed
    const isValid = computed(() => {
        if (form.id == "" || form.title == "") {
            return false;
        }
        return true;
    });
    const paginationLinks = computed(() => pagination.value?.links);
    const currentPage = computed(() => pagination.value?.current_page);
    const totalPages = computed(() => pagination.value?.total);

    //actions

    const addProductItem = async () => {
        try {
            form.id = form.id.replace(/ /g, "-");
            const res = await exec("/api/product", "post", form);
        } catch (e) {
            console.log(e);
        } finally {
            resetForm();
        }
    };
    const updateProductItem = async (id) => {
        try {
            const res = await exec("/api/product/" + id, "put", form);
        } catch (e) {
            console.log(e);
        } finally {
            resetForm();
        }
    };
    const deleteProductItem = async (id) => {
        try {
            const res = await exec("/api/product/" + id, "destroy", { form });
        } catch (e) {
            console.log(e);
        } finally {
            resetForm();
        }
    };
    const getProductItemsWithCategoryId = async (
        categoryId,
        requestData = null,
    ) => {
        try {
            let defaultData = {
                includeParentCode: true,
            };
            const res = await exec(
                `/api/product/category/${categoryId}`,
                "get",
                {
                    ...defaultData,
                    ...requestData,
                },
            );
            product_items.value = res.data.data;
            pagination.value = res.data.meta;
        } catch (e) {}
    };
    const getProductItems = async (requestData = null, useStore = true) => {
        let arrayData = {
            data: {},
            pagination: {},
        };
        try {
            let defaultData = {
                includeParentCode: true,
            };
            const res = await exec("/api/product", "get", {
                ...defaultData,
                ...requestData,
            });
            if (useStore) {
                product_items.value = res.data.data;
                pagination.value = res.data.meta;
            } else {
                arrayData = {
                    data: res.data.data,
                    pagination: res.data.meta.links,
                };
            }
        } catch (e) {
        } finally {
            return arrayData;
        }
    };
    const getProductItem = async (id, requestData = null) => {
        try {
            let defaultData = {
                includeProductCategories: true,
                includeProductCategoryKeys: true,
                includeProductComponents: true,
                includeNonWishlistUser: true,
                includeProductImages: true,
                includeProductDimensions: true,
                includeProductWeight: true,
                includeProductVolume: true,
                includeParentCode: true,
                includeProductFilter: true,
                includeVariants: true,
            };
            const res = await exec("/api/product/" + id, "get", {
                ...defaultData,
                ...requestData,
            });

            product_item.value = res.data.data;
            form.value = product_item.value;
            form.id = product_item.value.id;
            form.parent_code = product_item.value.parent_code;
            form.title = product_item.value.title;
            form.description = product_item.value.description;
            form.volume = product_item.value.volume;
            form.weight_net = product_item.value.weight_net;
            form.weight_gross = product_item.value.weight_gross;
            form.dimension_length = product_item.value.dimension_length;
            form.dimension_width = product_item.value.dimension_width;
            form.dimension_height = product_item.value.dimension_height;
        } catch (e) {
            console.log(e);
        }
    };
    const NonWishlistProduct = async (type, product_id, customer_id) => {
        try {
            const res = await exec(
                ["/api/nonwishlist", customer_id, type, product_id].join("/"),
                "put",
            );
        } catch (e) {
            console.log(e);
        } finally {
            resetForm();
        }
    };
    const updateProductCategories = async (id, categories) => {
        try {
            console.log(categories);
            const res = await exec("/api/product-categories/" + id, "put", {
                categories: categories,
            });
        } catch (e) {
            console.log(e);
        } finally {
        }
    };
    const resetForm = () => {
        form.parent_code = "";
        form.title = "";
        form.description = "";
        form.volume = 0.0;
        form.weight_net = 0.0;
        form.weight_gross = 0.0;
        form.dimension_length = 0.0;
        form.dimension_width = 0.0;
        form.dimension_height = 0.0;
    };

    const getProductFilter = async (product_id) => {
        try {
            const res = await exec(
                ["/api/product-filter", product_id].join("/"),
                "get",
            );
            product_item.value.product_filter = res.data.data;
            return res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const addProductFilter = async (product_id, filter_id, option_id) => {
        try {
            const res = await exec(
                ["/api/product-filter", product_id, filter_id, option_id].join(
                    "/",
                ),
                "post",
            );
        } catch (e) {
            console.log(e);
        }
    };
    const removeProductFilter = async (product_id, filter_id, option_id) => {
        try {
            const res = await exec(
                ["/api/product-filter", product_id, filter_id, option_id].join(
                    "/",
                ),
                "delete",
            );
        } catch (e) {
            console.log(e);
        }
    };

    const zipProductImages = async (product_id) => {
        try {
            const res = await exec(
                "/api/product-images/zip/" + product_id,
                "get",
                {},
            );
        } catch (e) {
            console.log(e);
        }
    };

    const tablebatch_updateProducts = async (product_data) => {
        try {
            const res = await exec("/api/data-table/product", "put", {
                products : product_data
            });
        } catch (e) {
            console.log(e);
        } finally {
            resetForm();
        }
    };

    return {

        tablebatch_updateProducts,

        getProductItemsWithCategoryId,

        zipProductImages,

        getProductFilter,
        addProductFilter,
        removeProductFilter,
        //pagination
        pagination,
        paginationLinks,
        currentPage,
        totalPages,
        //////////////////
        form,
        product_item,
        product_items,
        loading,
        errors,
        exec,
        isValid,

        updateProductCategories,

        resetForm,
        addProductItem,
        updateProductItem,
        deleteProductItem,

        getProductItem,
        getProductItems,

        NonWishlistProduct,
    };
});
