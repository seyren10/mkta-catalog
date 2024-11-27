import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useProductComponentStore = defineStore("productComponent", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();
    const components = ref([]);
    const form = ref({
        type: null,
        is_visible: true,
        index: 100,
        title: "",
        value: [],
    });
    const resetForm = () => {
        form.value.type = null;
        form.value.is_visible = true;
        form.value.index = 100;
        form.value.title = "";
        form.value = [];
    };
    const addProductComponent = async (product_id) => {
        if (product_id == "") {
            return;
        }
        try {
            form.value.type = form.value.type.trim().toLowerCase();
            switch (form.value.type) {
                case "list":
                    form.value = JSON.stringify(form.value);
                    break;
                case "file":
                    form.value = JSON.stringify(form.value);
                    break;
                case "album":
                    form.value = JSON.stringify(form.value);
                    break;
                case "table":
                    form.value = JSON.stringify(form.value);
                    break;
            }
            const res = await exec(
                "/api/product-components/" + product_id,
                "post",
                form.value,
            );
            resetForm();
        } catch (e) {
            console.log(e);
        }
    };
    const updateProductComponent = async (product_id, data) => {
        if (product_id == "") {
            return;
        }
        try {
            data.type = data.type.trim().toLowerCase();
            switch (data.type) {
                case "list":
                    data.value = JSON.stringify(data.value);
                    break;
                case "file":
                    data.value = JSON.stringify(data.value);
                    break;
                case "album":
                    data.value = JSON.stringify(data.value);
                    break;
                case "table":
                    data.value = JSON.stringify(data.value);
                    break;
            }
            const res = await exec(
                "/api/product-components/" + product_id,
                "put",
                data,
            );
        } catch (e) {
            console.log(e);
        }
    };
    const deleteProductComponent = async (id) => {
        try {
            const res = await exec("/api/product-components/" + id, "delete");
        } catch (e) {
            console.log(e);
        }
    };
    const getProductComponent = async (product_id) => {
        try {
            const res = await exec(
                "/api/product-components/" + product_id,
                "get",
                {},
            );
            components.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const getProductComponent_2 = async (product_id) => {
        try {
            const res = await exec(
                "/api/product-components/" + product_id,
                "get",
                {},
            );
            return res.data.data;
        } catch (e) {
            console.log(e);
        }
    };

    return {
        resetForm,
        addProductComponent,
        updateProductComponent,
        deleteProductComponent,
        getProductComponent,
        getProductComponent_2,

        loading,
        errors,
        form,
        exec,

        components,
    };
});
