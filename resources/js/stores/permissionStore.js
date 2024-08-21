import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const usePermissionStore = defineStore("permissions", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const permission = ref({
        id: 0,
        key: "",
        title: "",
        description: "",
    });
    const permissions = ref([]);
    const form = ref({
        key: "",
        title: "",
        description: "",
    });
    const resetForm = ()=>{
            form.value.key = "";
            form.value.title = "";
            form.value.description = "";
    }
    const isExist = computed(() => {
        if (
            form.value.title.trim().length == 0 ||
            form.value.key.trim().length == 0 ||
            form.value.description.trim().length == 0
        ) {
            return true;
        }
        return permissions.value.some((element) => {
            return (
                element.key.trim().toLowerCase() ==
                    form.value.key.trim().toLowerCase() ||
                element.title.trim().toLowerCase() ==
                    form.value.title.trim().toLowerCase()
            );
        });
    });
    const addPermission = async () => {
        try {
            form.value.key = form.value.key.trim().toLowerCase();
            form.value.title = form.value.title.trim();
            form.value.description = form.value.description.trim();
            const res = await exec("/api/permissions", "post", form.value);
            form.value = {
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
                "put", form.value
            );
            form.value = {
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
