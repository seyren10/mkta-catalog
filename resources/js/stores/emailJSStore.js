import emailjs from "@emailjs/browser";
import { defineStore, storeToRefs } from "pinia";
import { ref } from "vue";

export const useEmailJSStore = defineStore("emailJS", () => {
    const form = ref({
        order_id: null,
        wishlists: {},
        user_name: "",
        user_email: "",
        message: "",
    });
    const loading = ref(false);
    const errors = ref(null);

    const sendEmail = async () => {
        try {
            loading.value = true;

            await emailjs.send(
                import.meta.env.VITE_EMAILJS_SERVICE_ID,
                import.meta.env.VITE_EMAILJS_TEMPLATE_ID,
                form.value,
                {
                    publicKey: import.meta.env.VITE_EMAILJS_PUBLIC_KEY,
                },
            );
        } catch (e) {
            errors.value = e;
            console.log(errors.value);
        } finally {
            loading.value = false;
        }
    };

    const resetForm = () => {
        form.value = {
            order_id: null,
            wishlists: {},
            user_name: "",
            user_email: "",
            message: "",
        };
    };

    return {
        loading,
        errors,
        sendEmail,
        form,
        resetForm,
    };
});
