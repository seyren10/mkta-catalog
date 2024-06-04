<template>
    <div>
        <slot name="activator" @click="showMenu"></slot>

        <Teleport to="#overlay">
            <Transition
                enter-active-class="duration-300 ease-out"
                leave-active-class="duration-300 ease-out"
                enter-from-class="opacity-0"
                leave-to-class="opacity-0 "
                @after-leave="emits('close')"
            >
                <div
                    class="fixed z-[2001] overflow-hidden rounded-lg bg-white text-sm shadow-lg duration-200"
                    ref="menu"
                    v-show="show"
                >
                    <slot :loaded="loaded"><div v-bind="$attrs"></div> </slot>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<script setup>
import { nextTick, onMounted, ref, watch } from "vue";
defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    closeDelay: {
        type: [String, Number],
        default: 500,
    },
    persistent: {
        type: Boolean,
        default: false,
    },
});
const emits = defineEmits(["close"]);
const model = defineModel();

//reactives
const show = ref(false);
const menu = ref(null);
const started = ref(false);
const loaded = ref(false); // use this to load the menu content only when its actually opened (lazy-load)

//methods
const handleCloseMenu = (event) => {
    if (menu.value.contains(event.target)) {
    } else if (started.value) {
        show.value = false;
        model.value = null;
        document.body.removeEventListener("click", handleCloseMenu);
    }

    started.value = true;
};

const showMenu = async (e) => {
    if (!show.value) {
        started.value = false;

        if (!props.persistent)
            document.body.addEventListener("click", handleCloseMenu);

        show.value = true;
        await nextTick();
        handleShowMenu(e.currentTarget, menu.value);
    } else {
        show.value = false;
        document.body.removeEventListener("click", handleCloseMenu);
    }
};

const handleShowMenu = (parent, child) => {
    loaded.value = true;
    const parentBound = parent.getBoundingClientRect();
    const parentTop = parentBound.top;
    const parentHeight = parentBound.height;
    const childBound = child.getBoundingClientRect();
    const windowWidth = window.innerWidth;

    child.style.top = parentTop + parentHeight + 8 + "px";

    if (parentBound.left > windowWidth / 2) {
        //the parent element is on the right side of the screen

        //when the menu is placed on the right, and its width cant fit on the screen
        //relative to its parent right's position. place it as it be, otherwise, align its right
        //position to be its parent's right position.
        if (
            childBound.width <
            windowWidth - (windowWidth - parentBound.right)
        ) {
            child.style.left = `${parentBound.right - childBound.width}px`;
        }
    } else {
        //the parent element is on the left side of the screen
        child.style.left = parentBound.left + "px";
    }

    //add a margin, when the menu width is occupying the whole screen
    if (childBound.width < windowWidth - (windowWidth - parentBound.right)) {
        child.style.marginInline = "0";
    } else {
        child.style.marginInline = ".5rem";
    }
};

//hooks
onMounted(() => {});

//watch
watch(model, async (newValue) => {
    //if you are using this component without an activator (using v-model)
    if (newValue === null) {
        show.value = false;
    } else {
        started.value = false;
        show.value = true;

        if (!props.persistent)
            document.body.addEventListener("click", handleCloseMenu);

        await nextTick();
        handleShowMenu(newValue, menu.value);
    }
});
</script>

<style lang="scss" scoped></style>
