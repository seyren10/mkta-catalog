import { onBeforeUnmount, onMounted } from "vue";

export function useKey(code, cb) {
    function handleKeyPress(event) {
        if (event.code === code) {
            cb();
        }
    }
    onMounted(() => {
        window.addEventListener("keydown", handleKeyPress);
    });

    onBeforeUnmount(() => {
        window.removeEventListener("keydown", handleKeyPress);
    });
}
