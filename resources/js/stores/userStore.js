import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useUserStore = defineStore("user", () => {
    const currentUser = ref(null);
    const user = ref([]);
    const users = ref([]);
    const form = reactive({
        name: "",
        email: "",
        password: "",
        is_active: true,
        role_id: 1,
    });

    const { loading, errors, exec } = useAxios();
    //actions
    const isExist = computed(() => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(form.email)) {
            return true;
        }
        if (form.email.trim().length == 0) {
            return true;
        }
        return users.value.some((element) => {
            return (
                element.email.trim().toLowerCase() ==
                form.email.trim().toLowerCase()
            );
        });
    });
    const resetForm = () => {
        form.name = "";
        form.email = "";
        form.password = "";
        form.is_active = 0;
        form.role_id = 1;
    };
    const addUser = async () => {
        try {
            const res = await exec("/api/users", "post", form);
            form.password = res.data.password;
        } catch (e) {
            console.log(e);
        }
    };
    const updateUser = async (id) => {
        try {
            const res = await exec("/api/users/" + id, "put", form);
        } catch (e) {
            console.log(e);
        }
    };
    const resetPassword = async (id) => {
        try {
            const res = await exec(
                "/api/users/reset-password/" + id,
                "post",
                form,
            );
            form.password = res.data.password;
        } catch (e) {
            console.log(e);
        }
    };
    const changePassword = async (id) => {
        try {
            const res = await exec(
                "/api/users/change-password/" + id,
                "put",
                form,
            );
            form.password = res.data.password;
        } catch (e) {
            console.log(e);
        }
    };
    const getCurrentUser = async () => {
        try {
            const res = await exec("/api/user");
            currentUser.value = res.data.data;
        } catch (err) {
            currentUser.value = null;
            console.log(err);
        }
    };
    const modifyUserPermissions = async (type, permission) => {
        try {
            const res = await exec(
                "/api/users/" +
                    user.value.id +
                    "/" +
                    type +
                    "/permissions/" +
                    permission,
                "post",
            );
            getUser(user.value.id, {
                includeRoleData: true,
                includePermissions: true,
                includePermissionKeys: true,
                includeRolePermissions: true,
            });
        } catch (e) {
            console.log(e);
        }
    };
    const getUser = async (id, requestData = null) => {
        try {
            const res = await exec("/api/users/" + id, "get", requestData);
            user.value = res.data.data;
            form.name = user.value.name;
            form.email = user.value.email;
            form.is_active = user.value.is_active;
            form.role_id = user.value.role_id ?? user.value.role_data.id;
        } catch (e) {
            console.log(e);
        }
    };
    const getUsers = async (requestData = null) => {
        try {
            const res = await exec("/api/users", "get", requestData);
            users.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    return {
        resetForm,
        resetPassword,
        changePassword,
        addUser,
        modifyUserPermissions,
        updateUser,
        getCurrentUser,
        getUser,
        getUsers,

        isExist,
        currentUser,
        form,
        user,
        users,
        loading,
        errors,
        exec,
    };
});
