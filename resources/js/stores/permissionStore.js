import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const usePermissionStore = defineStore("permissions", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const permission = reactive({
        id: 0,
        key: "",
        title: "",
        description: "",
    });
    const permissions = ref([]);
    const form = reactive({
        key: "",
        title: "",
        description: "",
    });
    const resetForm = ()=>{
            form.key = "";
            form.title = "";
            form.description = "";
    }
    const isExist = computed(() => {
        if (
            form.title.trim().length == 0 ||
            form.key.trim().length == 0 ||
            form.description.trim().length == 0
        ) {
            return true;
        }
        return permissions.value.some((element) => {
            return (
                element.key.trim().toLowerCase() ==
                    form.key.trim().toLowerCase() ||
                element.title.trim().toLowerCase() ==
                    form.title.trim().toLowerCase()
            );
        });
    });
    const addPermission = async () => {
        try {
            form.key = form.key.trim().toLowerCase();
            form.title = form.title.trim();
            form.description = form.description.trim();
            const res = await exec("/api/permissions", "post", form);
            form = {
                key: "",
                title: "",
                description: "",
            };
        } catch (e) {
            console.log(e);
        }
    };
    const updatePermission = async (id) => {
        try {
            const res = await exec(
                "/api/permissions/" + id,
                "put", form
            );
            form = {
                key: "",
                title: "",
                description: "",
            };
        } catch (e) {
            console.log(e);
        }
    };
    const deletePermission = async (id) => {
        try {
            const res = await exec(
                "/api/permissions/" + id,
                "delete",
            );
        } catch (e) {
            console.log(e);
        }
    };
    const getPermission = async () => {
        try {
            const res = await exec("/api/permissions/" + permission.id);
            permissions.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const getPermissions = async () => {
        try {
            const res = await exec("/api/permissions");
            permissions.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };

    return {
        resetForm,
        addPermission,
        updatePermission,
        deletePermission,
        getPermission,
        getPermissions,

        isExist,
        permission,
        permissions,
        loading,
        errors,
        form,
        exec,
    };
});
