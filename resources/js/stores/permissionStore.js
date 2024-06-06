import { reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const usePermissionStore = defineStore("permissions", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const current_permission = reactive({
        id: 0,
        key: "",
        title: "",
        desc: "",
    });
    const permissions = ref([]);
    const form = reactive({
        key: "",
        title: "",
        desc: "",
    });

    const isExist = () => {
        return false;
    };
    const getPermissions = async () => {
        try {
            const res = await exec("/api/permissions");
            console.log(res.data.data);
            permissions.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };

    return { getPermissions, permissions, loading, errors, form, exec };
});
