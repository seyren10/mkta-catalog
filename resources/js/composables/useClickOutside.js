import { onBeforeMount, onBeforeUnmount, onMounted, ref } from "vue";

export const useClickOutside = (el, cb) => {
    const firstAttempt = ref(false);

    function handleClick(event) {
        if (!el.value.contains(event.target) && firstAttempt.value) {
            cb();
            firstAttempt.value = false;
        } else {
            firstAttempt.value = true;
        }
    }
    onBeforeMount(() => {
        window.addEventListener("click", handleClick);
    });

    onBeforeUnmount(() => {
        window.removeEventListener("click", handleClick);
    });
};
