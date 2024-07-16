import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useFilterStore = defineStore("filterStore", () => {
    const filters = ref([]);
    const filter = ref({
        title: "",
        description: "",
        choices: [],
    });

    const { loading, errors, exec } = useAxios();
    //actions
    const getFilter = async (id, requestData = null) => {
        let data = [];
        try {
            const res = await exec(`/api/filters/${id}`, "get", requestData);
            filter.value = res.data.data;
            data = res.data.data;
        } catch (e) {
            console.log(e);
        } finally {
            return data;
        }
    };
    const getFilters = async () => {
        let data = [];
        try {
            const res = await exec("/api/filters");
            filters.value = res.data.data;
            data = res.data.data;
        } catch (e) {
            console.log(e);
        } finally {
            return data;
        }
    };
    const addFilter = async (form = {}) => {
        try {
            const res = await exec(["/api/filters"].join("/"), "post", form);
        } catch (e) {
            console.log(e);
        }
    };
    const updateFilter = async (id, form = {}) => {
        try {
            const res = await exec(["/api/filters", id].join("/"), "put", form);
        } catch (e) {
            console.log(e);
        }
    };
    const deleteFilter = async (id) => {
        try {
            const res = await exec(["/api/filters", id].join("/"), "delete");
        } catch (e) {
            console.log(e);
        }
    };

    const addFilterChoice = async (filter_id, form = {}) => {
        try {
            const res = await exec(
                ["/api/filters/choice", filter_id].join("/"),
                "post",
                form,
            );
        } catch (e) {
            console.log(e);
        }
    };
    const updateFilterChoice = async (id, form) => {
        try {
            const res = await exec(
                ["/api/filters/choice", id].join("/"),
                "post",
                form,
            );
        } catch (e) {
            console.log(e);
        }
    };
    const deleteFilterChoice = async (id) => {
        try {
            const res = await exec(
                ["/api/filters/choice", id].join("/"),
                "delete",
            );
        } catch (e) {
            console.log(e);
        }
    };
    return {
        filters,
        filter,
        loading,
        errors,
        getFilter,
        getFilters,
        addFilter,
        updateFilter,
        deleteFilter,

        addFilterChoice,
        updateFilterChoice,
        deleteFilterChoice,
    };
});
