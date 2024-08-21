import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useProductAccessTypeStore = defineStore(
    "productAccessType",
    () => {
        const router = useRouter();
        const { loading, errors, exec } = useAxios();
        const product_access_type = ref([]);
        const product_access_types = ref([]);
        const form = ref({
            type: "",
            title: "",
            description: "",
            ref_type: "direct",
            ref_table: "",
            ref_column: "",
            display_column: "",
            source_table: "",
            source_column: "",
        });
        const resetForm = () => {
            form.value.type = "";
            form.value.title = "";
            form.value.description = "";

            form.value.ref_type = "direct";
            form.value.ref_table = "";
            form.value.ref_column = "";
            form.value.display_column = "";

            form.value.source_table = "";
            form.value.source_column = "";
        };
        const isExist = computed(() => {
            if (
                form.value.type.trim().length == 0 ||
                form.value.title.trim().length == 0 ||
                form.value.description.trim().length == 0 ||
                form.value.ref_type.trim().length == 0 ||
                form.value.ref_table.trim().length == 0 ||
                form.value.ref_column.trim().length == 0 ||
                form.value.source_table.trim().length == 0 ||
                form.value.source_column.trim().length == 0
            ) {
                return true;
            }
            return product_access_types.value.some((element) => {
                return (
                    element.type.trim().toLowerCase() ==
                        form.value.type.trim().toLowerCase() ||
                    element.title.trim().toLowerCase() ==
                        form.value.title.trim().toLowerCase()
                );
            });
        });
        const addProductAccessType = async () => {
            try {
                form.value.type = form.value.type.trim().toLowerCase();
                const res = await exec(
                    "/api/product-access-type",
                    "post",
                    form.value,
                );
                resetForm();
            } catch (e) {
                console.log(e);
            }
        };
        const updateProductAccessType = async (id) => {
            try {
                const res = await exec(
                    "/api/product-access-type/" + id,
                    "put",
                    form.value,
                );
                resetForm();
            } catch (e) {
                console.log(e);
            }
        };
        const deleteProductAccessType = async (id) => {
            try {
                const res = await exec(
                    "/api/product-access-type/" + id,
                    "delete",
                );
            } catch (e) {
                console.log(e);
            }
        };
        const getProductAccessType = async (id, requestData = null) => {
            try {
                let defaultData = {
                    includeOtherData: true,
                };
                const res = await exec(
                    "/api/product-access-type/" + id,
                    "get",
                    {
                        ...requestData,
                        ...defaultData,
                    },
                );
                product_access_type.value = res.data.data;
                // form.value = {
                form.value.type = product_access_type.value.type;
                form.value.title = product_access_type.value.title;
                form.value.description = product_access_type.value.description;
                form.value.ref_type = product_access_type.value.ref_type;
                form.value.ref_table = product_access_type.value.ref_table;
                form.value.ref_column = product_access_type.value.ref_column;

                form.value.display_column =
                    product_access_type.value.display_column;
                form.value.source_table =
                    product_access_type.value.source_table;
                form.value.source_column =
                    product_access_type.value.source_column;
                // };
            } catch (e) {
                console.log(e);
            }
        };
        const returnProductAccessType = async (id, requestData = null) => {
            let content = [];
            try {
                let defaultData = {
                    includeOtherData: true,
                };
                const res = await exec("/api/product-access/" + id, "get", {
                    ...requestData,
                    ...defaultData,
                });
                content = res.data.data;
            } catch (e) {
                console.log(e);
            }
            return content;
        };
        const appendProductAccess = async (
            action,
            product,
            product_access_type,
            value,
        ) => {
            try {
                const res = await exec(
                    [
                        "/api/product-access",
                        action,
                        product,
                        product_access_type,
                        value,
                    ].join("/"),
                    "post",
                );
                resetForm();
            } catch (e) {
                console.log(e);
            }
        };
        const removeProductAccess = async (
            action,
            product,
            product_access_type,
            value,
        ) => {
            try {
                const res = await exec(
                    [
                        "/api/product-access",
                        action,
                        product,
                        product_access_type,
                        value,
                    ].join("/"),
                    "delete",
                );
                resetForm();
            } catch (e) {
                console.log(e);
            }
        };

        const getProductAccessTypes = async (requestData = null) => {
            try {
                const res = await exec("/api/product-access-type", "get", {
                    ...requestData,
                });
                product_access_types.value = res.data.data;
            } catch (e) {
                console.log(e);
            }
        };

        const batchUpdate = async (requestData) => {
            try {
                const res = await exec(
                    ["/api/data-table/product-access-type"].join("/"),
                    "put",
                    { PAT_Changes : requestData},
                );
            } catch (e) {
                console.log(e);
            }
        };

        return {
            batchUpdate,
            resetForm,
            addProductAccessType,
            updateProductAccessType,
            deleteProductAccessType,
            getProductAccessType,
            getProductAccessTypes,
            returnProductAccessType,

            appendProductAccess,
            removeProductAccess,

            isExist,
            product_access_type,
            product_access_types,
            loading,
            errors,
            form,
            exec,
        };
    },
);
