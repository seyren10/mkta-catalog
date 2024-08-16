import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useCategoryStore = defineStore("categories", () => {
    const { loading, errors, exec } = useAxios();
    const categories = ref([]);
    const category = ref([]);
    const form = ref({
        img: "",
        title: "",
        description: "",
        parent_id: 0,
        file_id: 0,
        cover_html: "",
    });
    const resetForm = () => {
        form.value.title = "";
        form.value.description = "";
        form.value.parent_id = 0;
        form.value.file_id = 0;
        form.value.cover_html = 0;
    };
    const addCategory = async () => {
        try {
            const res = await exec("/api/categories", "post", form.value);
            if (form.value.parent_id != 0) {
                getCategory(form.value.parent_id);
            } else {
                getCategories();
            }
        } catch (e) {
            console.log(e);
        }
    };
    const updateCategory = async (id) => {
        try {
            const res = await exec("/api/categories/" + id, "put", form.value);
            getCategory(id);
        } catch (e) {
            console.log(e);
        }
    };
    const updateCategoryImage = async (id, file_id) => {
        try {
            const res = await exec("/api/categories/image/" + id, "put", {
                file_id: file_id,
            });
            getCategory(id);
        } catch (e) {
            console.log(e);
        }
    };

    const deleteCategory = async (id) => {
        try {
            const res = await exec("/api/categories/" + id, "delete");
            await getCategories();
        } catch (e) {
            console.log(e);
        }
    };
    const getCategory = async (id, requestData = null) => {
        console.log("get category");
        try {
            let defaultData = {
                includeCoverHTML: true,
                includeSubCategories: true,
                includeFile: true,
                includeParentCategory: true,
                includeBannerImage: true,
            };
            const res = await exec("/api/categories/" + id, "get", {
                ...requestData,
                ...defaultData,
            });
            category.value = res.data.data;
            form.value.title = category.value.title;
            form.value.description = category.value.description;
            form.value.parent_id = category.value.parent_id;
            form.value.file_id = category.value.file_id ?? category.img;
            form.value.cover_html = category.value.cover_html;
        } catch (e) {
            console.log(e);
        }
    };
    const getCategories = async (requestData = null) => {
        try {

            let defaultData = {
                includeCoverHTML: true,
                includeSubCategories: true,
                includeFile: true,
                includeParentCategory: true,
            };

            const res = await exec("/api/categories", "get", {
                ...defaultData,
                ...requestData,
            });
            categories.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };

    const getCategoryWithId = (categoryId) => {
        if (categories.value.length) {
            category.value = categories.value.find((e) => e.id === categoryId);

            return category.value;
        }
    };

    async function updateBannerImage(id, fileId) {
        await exec(`/api/categories/banner-image/${id}`, "put", {
            banner_file_id: fileId,
        });
    }
    return {
        form,
        category,
        categories,
        loading,
        errors,
        exec,

        resetForm,
        addCategory,
        updateCategory,
        deleteCategory,
        getCategory,
        getCategories,
        getCategoryWithId,
        updateCategoryImage,
        updateBannerImage,
    };
});
