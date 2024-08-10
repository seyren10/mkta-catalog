import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useAreaStore = defineStore("area", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const area = ref({
        id: 0,
        title: "",
        description: "",
    });
    const areas = ref([]);
    const form = ref({
        title: "",
        description: "",
    });
    const resetForm = ()=>{
            form.title = "";
            form.description = "";
    }
    const isExist = computed(() => {
        if (
            form.title.trim().length == 0 ||
            form.description.trim().length == 0
        ) {
            return true;
        }
        return areas.value.some((element) => {
            return (
                element.title.trim().toLowerCase() ==
                    form.title.trim().toLowerCase()
            );
        });
    });
    const addArea = async () => {
        try {
            form.title = form.title.trim();
            form.description = form.description.trim();
            const res = await exec("/api/area-code", "post", form);
            form = {
                title: "",
                description: "",
            };
        } catch (e) {
            console.log(e);
        }
    };
    const updateArea = async (id) => {
        try {
            const res = await exec(
                "/api/area-code/" + id,
                "put", form
            );
            form = {
                title: "",
                description: "",
            };
        } catch (e) {
            console.log(e);
        }
    };
    const deleteArea = async (id) => {
        try {
            const res = await exec(
                "/api/area-code/" + id,
                "delete",
            );
        } catch (e) {
            console.log(e);
        }
    };
    const getArea = async () => {
        try {
            const res = await exec("/api/area-code/" + area.id);
            areas.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const getAreas = async () => {
        try {
            const res = await exec("/api/area-code");
            areas.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };

    return {
        resetForm,
        addArea,
        updateArea,
        deleteArea,
        getArea,
        getAreas,

        isExist,
        area,
        areas,
        loading,
        errors,
        form,
        exec,
    };
});
