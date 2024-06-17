import { ref } from "vue";

export const useAxios = (method, options) => {
    const loading = ref(false);
    const errors = ref(null);

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
                    res = await axios.post(url, requestData);
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
            errors.value = err.response.data.message;
        } finally {
            loading.value = false;
        }
    };

    return { loading, errors, exec };
};
