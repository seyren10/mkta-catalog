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
        const form = reactive({
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
            form.type = "";
            form.title = "";
            form.description = "";

            form.ref_type = "direct";
            form.ref_table = "";
            form.ref_column = "";
            form.display_column = "";

            form.source_table = "";
            form.source_column = "";
        };
        const isExist = computed(() => {
            if (
                form.type.trim().length == 0 ||
                form.title.trim().length == 0 ||
                form.description.trim().length == 0 ||
                form.ref_type.trim().length == 0 ||
                form.ref_table.trim().length == 0 ||
                form.ref_column.trim().length == 0 ||
                form.source_table.trim().length == 0 ||
                form.source_column.trim().length == 0
            ) {
                return true;
            }
            return product_access_types.value.some((element) => {
                return (
                    element.type.trim().toLowerCase() ==
                        form.type.trim().toLowerCase() ||
                    element.title.trim().toLowerCase() ==
                        form.title.trim().toLowerCase()
                );
            });
        });
        const addProductAccessType = async () => {
            try {
                form.type = form.type.trim().toLowerCase();
                const res = await exec(
                    "/api/product-access-type",
                    "post",
                    form,
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
                    form,
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
                // form = {
                form.type = product_access_type.value.type;
                form.title = product_access_type.value.title;
                form.description = product_access_type.value.description;
                form.ref_type = product_access_type.value.ref_type;
                form.ref_table = product_access_type.value.ref_table;
                form.ref_column = product_access_type.value.ref_column;

                form.display_column = product_access_type.value.display_column;
                form.source_table = product_access_type.value.source_table;
                form.source_column = product_access_type.value.source_column;
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

        const getProductAccessTypes = async () => {
            try {
                const res = await exec("/api/product-access-type");
                product_access_types.value = res.data.data;
            } catch (e) {
                console.log(e);
            }
        };

        return {
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
