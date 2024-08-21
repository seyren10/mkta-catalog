import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useUserStore = defineStore("user", () => {
    const currentUser = ref(null);
    const user = ref([]);
    const users = ref([]);
    const form = ref({
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
        if (!emailRegex.test(form.value.email)) {
            return true;
        }
        if (form.value.email.trim().length == 0) {
            return true;
        }
        return users.value.some((element) => {
            return (
                element.email.trim().toLowerCase() ==
                form.value.email.trim().toLowerCase()
            );
        });
    });
    const resetForm = () => {
        form.value.name = "";
        form.value.email = "";
        form.value.password = "";
        form.value.is_active = 0;
        form.value.role_id = 1;
    };
    const addUser = async () => {
        try {
            const res = await exec("/api/users", "post", form.value);
            form.value.password = res.data.password;
        } catch (e) {
            console.log(e);
        }
    };
    const updateUser = async (id) => {
        try {
            const res = await exec("/api/users/" + id, "put", form.value);
        } catch (e) {
            console.log(e);
        }
    };
    const resetPassword = async (id) => {
        try {
            const res = await exec(
                "/api/users/reset-password/" + id,
                "post",
                form.value,
            );
            form.value.password = res.data.password;
        } catch (e) {
            console.log(e);
        }
    };
    const changePasswordFirstTime = async (form) => {
        await exec("/api/users/change-password-first-time", "post", form.value);
    };
    const changePassword = async (id) => {
        try {
            const res = await exec(
                "/api/users/change-password/" + id,
                "put",
                form.value,
            );
            form.value.password = res.data.password;
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
            // console.log(err);
        }
    };
    const getCurrentUserFullData = async () => {
        try {
            const res = await exec("/api/user", "get", {
                includeAreasData: true,
                includeCompaniesData: true,
            });
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
            form.value.name = user.value.name;
            form.value.email = user.value.email;
            form.value.is_active = user.value.is_active;
            form.value.role_id = user.value.role_id ?? user.value.role_data.id;
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
        changePasswordFirstTime,
        addUser,
        modifyUserPermissions,
        updateUser,
        getCurrentUser,
        getCurrentUserFullData,
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
