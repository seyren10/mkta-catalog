import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useEmailRegistrationStore = defineStore(
    "email-registration",
    () => {
        const { exec, errors, loading } = useAxios();

        async function registerEmail(form) {
            const res = await exec(
                "/api/email-registration",
                "post",
                form.value,
            );

            return res;
        }

        return {
            registerEmail,
            loading,
            errors,
        };
    },
);
