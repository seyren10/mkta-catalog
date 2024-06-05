<template>
    <div class="hidden" ref="activator">
        <Teleport to="#overlay">
            <div
                class="fixed z-[2001] rounded-lg bg-black bg-opacity-25 px-2 py-1 text-[.7rem] text-white"
                v-show="model"
                ref="el"
            >
                <slot>This is a tooltip</slot>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
import { nextTick, onMounted, onUnmounted, ref } from "vue";

const props = defineProps({
    activator: {
        type: String,
    },
});
const model = defineModel(false);

//reactives
const el = ref(null);
const activator = ref(null);

//functions
const handleShow = async (event) => {
    model.value = true;

    await nextTick();
    handleShowMenu(event.currentTarget, el.value);

    event.currentTarget.removeEventListener("mouseover", handleShow);
};

const handleShowMenu = (parent, child) => {
    const parentBound = parent.getBoundingClientRect();
    const parentTop = parentBound.top;
    const parentHeight = parentBound.height;
    const childBound = child.getBoundingClientRect();
    const windowWidth = window.innerWidth;

    child.style.top = parentTop + parentHeight + "px";

    if (parentBound.left > windowWidth / 2) {
        if (
            childBound.width <
            windowWidth - (windowWidth - parentBound.right)
        ) {
            child.style.left = `${parentBound.right - childBound.width}px`;
        }
    } else {
        child.style.left = parentBound.left + "px";
    }

    if (childBound.width < windowWidth - (windowWidth - parentBound.right)) {
        child.style.marginInline = "0";
    } else {
        child.style.marginInline = ".5rem";
    }
};

const handleClose = (event) => {
    model.value = false;

    event.currentTarget.addEventListener("mouseover", handleShow);
};

onMounted(() => {
    if (props.activator === "parent") {
        activator.value = activator.value.parentElement;

        activator.value.addEventListener("mouseover", handleShow);
        activator.value.addEventListener("mouseleave", handleClose);
    }
});

onUnmounted(() => {
    if (props.activator === "parent") {
        activator.value.removeEventListener("mouseover", handleShow);
        activator.value.removeEventListener("mouseleave", handleClose);
    }
});
</script>

<style lang="scss" scoped></style>
