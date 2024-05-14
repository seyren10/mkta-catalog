import { ref } from "vue";

export const useAxios = (method, options) => {
    const loading = ref(false);
    const errors = ref(null);

    const exec = async (
        url,
        method = "get",
        form = null,
        requestData = null,
    ) => {
        loading.value = true;
        try {
            switch (method) {
                case "get": {
                    const res = await axios.get(url, {
                        params: requestData,
                    });

                    errors.value = null;
                    return res;
                }
                case "post": {
                    const res = await axios.post(url, form);

                    errors.value = null;
                    return res;
                }
                case "patch": {
                    const res = await axios.patch(url, form);

                    errors.value = null;
                    return res;
                }
                case "put": {
                    const res = await axios.put(url, form);

                    errors.value = null;
                    return res;
                }
                case "delete": {
                    const res = await axios.delete(url);

                    errors.value = null;
                    return res;
                }
            }
        } catch (err) {
            errors.value = err.response.data.message;
        } finally {
            loading.value = false;
        }
    };

    return { loading, errors, exec };
};
