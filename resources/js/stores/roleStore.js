import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useRoleStore = defineStore("roles", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const role = ref([]);
    const roles = ref([]);
    const form = reactive({
        title: "",
        description: "",
    });

    const resetForm = () => {
        form.title = "";
        form.description = "";
    };
    const isExist = computed(() => {
        if (
            form.title.trim().length == 0 ||
            form.description.trim().length == 0
        ) {
            return true;
        }
        return roles.value.some((element) => {
            return (
                element.title.trim().toLowerCase() ==
                form.title.trim().toLowerCase()
            );
        });
    });
    const addRole = async () => {
        try {
            form.title = form.title.trim();
            form.description = form.description.trim();
            const res = await exec("/api/roles", "post", form);
        } catch (e) {
            console.log(e);
        }
    };
    const updateRole = async (id) => {
        try {
            const res = await exec("/api/roles/" + id, "put", form);
        } catch (e) {
            console.log(e);
        }
    };
    const deleteRole = async (id) => {
        try {
            const res = await exec("/api/roles/" + id, "delete");
        } catch (e) {
            console.log(e);
        }
    };
    const getRole = async (id, requestData = null) => {
        try {
            const res = await exec("/api/roles/" + id, "get", requestData);
            role.value = res.data.data;
            form.title = role.value.title;
            form.description = role.value.description;
        } catch (e) {
            console.log(e);
        }
    };
    const getRoles = async () => {
        try {
            const res = await exec("/api/roles");
            roles.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const modifyRolePermissions = async (type, permission) => {
        try {
            const res = await exec(
                "/api/roles/" +
                    role.value.id +
                    "/" +
                    type +
                    "/permissions/" +
                    permission,
                "post",
            );
            await getRole(role.value.id, { includePermissions: true, includePermissionKeys: true,  })
        } catch (e) {
            console.log(e);
        }
    };

    return {
        resetForm,
        modifyRolePermissions,
        addRole,
        updateRole,
        deleteRole,
        getRole,
        getRoles,

        isExist,
        role,
        roles,
        loading,
        errors,
        form,
        exec,
    };
});
