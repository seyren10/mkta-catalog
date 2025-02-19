import { ref, watch } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/authStore";
export const useAxios = (method, options) => {
    const loading = ref(false);
    const errors = ref(null);
    const router = useRouter();
    const authStore = useAuthStore();

    watch(errors, (newValue) => {
        switch (newValue.status) {
            case 404:
                router.push({ name: "notFound" });
                break;
            case 401:
                authStore.logout();
                break;
        }
    });

    const exec = async (url, method = "get", requestData = null) => {
        loading.value = true;

        try {
            let res = null;

            switch (method) {
                case "get":
                    res = await axios.get(url, {
                        params: requestData,
                    });
                    break;
                case "post":
                    res = await axios.post(url, requestData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    });
                    break;
                case "patch":
                    res = await axios.patch(url, requestData);
                    break;
                case "put":
                    res = await axios.put(url, requestData);
                    break;
                case "delete":
                    res = await axios.delete(url);
                    break;
            }
            errors.value = null;
            return res;
        } catch (err) {
            errors.value = err.response;
        } finally {
            loading.value = false;
        }
    };

    return { loading, errors, exec };
};
