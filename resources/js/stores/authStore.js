import { ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useAuthStore = defineStore("auth", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

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
    const logout = async () => {
        try {
            await exec("/logout", "delete");

            if (!errors.value) await router.push({ name: "login" });
        } catch (e) {}
    };

    return { login, loading, errors, form, exec, logout };
});
