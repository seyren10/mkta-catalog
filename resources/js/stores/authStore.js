import { ref } from "vue";
import { defineStore, storeToRefs } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";
import { useUserStore } from "./userStore";

export const useAuthStore = defineStore("auth", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();
    const userStore = useUserStore();
    const { currentUser } = storeToRefs(userStore);

    const form = ref({
        email: null,
        password: null,
        remember: false,
    });

    const login = async () => {
        try {
            await exec("/sanctum/csrf-cookie", "get");
            await exec("/login", "post", form.value);

            /* when user is authenticated redirect
             them to the catalog route */
            if (!errors.value) router.push({ name: "catalog" });
        } catch (e) {}
    };

    const logout = async (redirect = true) => {
        try {
            await exec("/logout", "delete");

            if (!errors.value) {
                currentUser.value = null;
            }
            if (redirect) {
                await router.push({ name: "login" });
            }
        } catch (e) {}
    };

    return { login, loading, errors, form, exec, logout };
});
