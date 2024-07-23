import { reactive } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useAuthStore = defineStore("auth", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const form = reactive({
        email: null,
        password: null,
        remember: false,
    });

    const login = async () => {
        try {
            await exec("/sanctum/csrf-cookie", "get");
            await exec("/login", "post", form);

            //when user is authenticated redirect them to the catalog route
            if (!errors.value) router.push({ name: "catalog" });
        } catch (e) {}
    };
    const logout = async () => {
        try {
            await exec("/logout", "delete");

            //when user is authenticated redirect them to the catalog route
            if (!errors.value) await router.push({ name: "home" });
        } catch (e) {}
    };

    return { login, loading, errors, form, exec, logout };
});
