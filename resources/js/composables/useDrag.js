import { onBeforeUnmount, onMounted, ref } from "vue";

export const useDrag = (el) => {
    const isDragging = ref(false);
    const mousePosition = { x: 0, y: 0 };
    const draggingPosition = { x: 0, y: 0 };

    const isWithinLeft = () => {
        const parentRect = el.value.parentElement.getBoundingClientRect();
        const childRect = el.value.getBoundingClientRect();

        return (
            childRect.left < parentRect.left &&
            childRect.right > parentRect.right
        );
    };

    const isWithinTop = () => {
        const parentRect = el.value.parentElement.getBoundingClientRect();
        const childRect = el.value.getBoundingClientRect();

        return (
            childRect.top < parentRect.top &&
            childRect.bottom > parentRect.bottom
        );
    };

    const startDragging = (e) => {
        isDragging.value = true;
        el.value.style.cursor = "grabbing";
        el.value.style.transition = "none";

        mousePosition.x = e.clientX - el.value.offsetLeft;
        mousePosition.y = e.clientY - el.value.offsetTop;
    };

    const stopDragging = (e) => {
        isDragging.value = false;
        el.value.style.cursor = "grab";
        el.value.style.transition = "all 300ms";

        if (!isWithinLeft()) {
            el.value.style.left = "0px";
        }
        if (!isWithinTop()) {
            el.value.style.top = "0px";
        }
    };

    const dragging = (e) => {
        if (isDragging.value) {
            draggingPosition.x = e.clientX;
            draggingPosition.y = e.clientY;

            el.value.style.left = `${draggingPosition.x - mousePosition.x}px`;
            el.value.style.top = `${draggingPosition.y - mousePosition.y}px`;
        }
    };

    onMounted(() => {
        el.value.addEventListener("mousedown", startDragging);
        el.value.addEventListener("mousemove", dragging);
        el.value.addEventListener("mouseup", stopDragging);
        el.value.addEventListener("mouseleave", stopDragging);
    });
    onBeforeUnmount(() => {
        el.value.removeEventListener("mousedown", startDragging);
        el.value.removeEventListener("mousemove", dragging);
        el.value.removeEventListener("mouseup", stopDragging);
        el.value.removeEventListener("mouseleave", stopDragging);
    });
};
