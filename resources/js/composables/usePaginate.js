import { computed, ref } from "vue";

export const usePaginate = (items, itemsPerPage = 20) => {
    const page = ref(1);

    const paginatedItems = computed(() => {
        return items.value.slice(
            startIndex.value,
            startIndex.value + itemsPerPage,
        );
    });
    const totalPages = computed(() => {
        return Math.ceil(items.value.length / itemsPerPage);
    });

    const startIndex = computed(() => (page.value - 1) * itemsPerPage);
    function nextPage() {
        if (page.value * itemsPerPage < items.value.length) {
            page.value++;
        } else page.value = 1;
    }
    function prevPage() {
        if (page.value > 1) {
            page.value--;
        } else {
            page.value = totalPages.value;
        }
    }

    return {
        paginatedItems,
        totalPages,
        nextPage,
        prevPage,
        page,
    };
};
