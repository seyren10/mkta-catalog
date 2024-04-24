import { ref, onBeforeUnmount, onMounted } from "vue";

export const useMedia = (query) => {
    const mediaQuery = ref(window.matchMedia(query));
    const isMatched = ref(mediaQuery.value.matches);

    const matches = (e) => {
        isMatched.value = e.matches;
    };

    onMounted(() => {
        mediaQuery.value.addEventListener("change", matches);
    });

    onBeforeUnmount(() => {
        mediaQuery.value.removeEventListener("change", matches);
    });

    return { isMatched };
};
