import { onBeforeUnmount, onMounted, onUnmounted, ref } from "vue";

export const useZoom = (el, maxZoom = 5, zoomAmount = 0.5) => {
    const currentzoom = ref(1);

    const zoom = () => {
        if (currentzoom.value >= 1) {
            if (currentzoom.value >= maxZoom) currentzoom.value = maxZoom;
        } else {
            currentzoom.value = 1;
        }

        el.value.style.transform = `scale(${currentzoom.value})`;
    };

    const setZoomOrigin = (event) => {
        const rect = el.value.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        const xPercent = (x / rect.width) * 100;
        const yPercent = (y / rect.height) * 100;

        if (currentzoom.value <= 1)
            el.value.style.transformOrigin = `${xPercent}% ${yPercent}%`;
    };

    const zoomOnMouseWheel = (event) => {
        setZoomOrigin(event);

        const finalZoom = event.deltaY * 0.01 * zoomAmount;
        currentzoom.value -= finalZoom;

        zoom();
    };

    const zoomTo = (zoomAmount) => {
        el.value.style.transformOrigin = `50% 50%`;
        currentzoom.value = zoomAmount;

        zoom();
    };

    onMounted(() => {
        el.value.addEventListener("wheel", zoomOnMouseWheel);
    });

    onBeforeUnmount(() => {
        el.value.removeEventListener("wheel", zoomOnMouseWheel);
    });

    return {
        el,
        currentzoom,
        zoomTo,
    };
};
