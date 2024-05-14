import { ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useUserStore = defineStore("user", () => {
    const user = ref(null);
    const { loading, errors, exec } = useAxios();
    //actions
    const getUser = async () => {
        try {
            const res = await exec("/api/user");

            user.value = res.data.data;
        } catch (err) {}
    };

    return { user, getUser };
});
