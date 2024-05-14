import { reactive } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useAuthStore = defineStore("auth", () => {
    const { loading, errors, exec } = useAxios();
    const form = reactive({
        email: null,
        password: null,
        remember: false,
    });
    const router = useRouter();
    const login = async () => {
        try {
            await exec("/sanctum/csrf-cookie", "get");
            await exec("/login", "post", form);

            router.push({ name: "catalog" });
        } catch (e) {}
    };

    return { login, loading, errors, form };
});
