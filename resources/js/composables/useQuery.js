import { computed, watch } from "vue";
import { useRoute, useRouter } from "vue-router";

export const useQuery = (queryName, cb, excludeOtherQuery = false) => {
    const route = useRoute();
    const router = useRouter();

    const query = computed(() => +route.query[queryName]);

    const setQuery = (value) => {
        if (excludeOtherQuery) {
            router.push({ query: { [queryName]: value } });
        } else
            router.push({
                query: {
                    ...route.query,
                    [queryName]: value,
                },
            });
    };

    watch(query, async (newValue) => {
        if (cb) await cb(newValue);
    });

    return [query, setQuery];
};
