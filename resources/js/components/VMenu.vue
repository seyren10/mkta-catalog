<template>
    <div>
        <slot name="activator" @click="showMenu"></slot>

        <Teleport to="#overlay">
            <!-- <Transition
                enter-active-class="duration-300 ease-out"
                leave-active-class="duration-300 ease-out"
                enter-from-class="opacity-0 scale-90"
                leave-to-class="opacity-0 scale-90"
            > -->
            <div
                class="fixed z-[2001] overflow-hidden rounded-lg bg-white text-sm shadow-lg"
                ref="menu"
                v-show="show"
            >
                <slot
                    ><div v-bind="$attrs">
                        Lorem ipsum dolor sit amet consectetur, adipisicing
                        elit. Inventore ipsum facere, ducimus distinctio porro
                        excepturi maxime! Perspiciatis quia quas quam impedit
                        adipisci esse fugiat dignissimos. Id praesentium labore
                        dolor totam? Lorem ipsum dolor sit amet consectetur
                        adipisicing elit. Natus, ipsam? Voluptatibus, quis?
                        Repellat consequuntur pariatur sed illo tempore
                        molestiae, sequi doloribus ipsam cum libero quia
                        laboriosam a! Perspiciatis, in sequi!
                    </div>
                </slot>
            </div>
            <!-- </Transition> -->
        </Teleport>
    </div>
</template>

<script setup>
import { nextTick, onMounted, ref } from "vue";
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

//reactives
const show = ref(false);
const menu = ref(null);

const started = ref(false);

//methods

const handleCloseMenu = (event) => {
    if (menu.value.contains(event.target)) {
        console.log("pasok");
    } else if (started.value) {
        show.value = false;
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

        const parentBound = e.currentTarget.getBoundingClientRect();
        const parentTop = parentBound.top;
        const parentHeight = parentBound.height;
        const menuBound = menu.value.getBoundingClientRect();
        const windowWidth = window.innerWidth;

        menu.value.style.top = parentTop + parentHeight + 8 + "px";

        //limit the menu width to be the screen size if it is larger than it.
        if (parentBound.left > windowWidth / 2) {
            //the parent element is on the right side of the screen

            if (
                menuBound.width <
                windowWidth - (windowWidth - parentBound.right)
            ) {
                menu.value.style.left = `${parentBound.right - menuBound.width}px`;
            }
        } else {
            //the parent element is on the left side of the screen

            console.log("left most");
            menu.value.style.left = parentBound.left + "px";
        }
        if (menuBound.width < windowWidth - (windowWidth - parentBound.right)) {
            menu.value.style.marginInline = "0";
        } else {
            menu.value.style.marginInline = ".5rem";
        }
    } else {
        show.value = false;
        document.body.removeEventListener("click", handleCloseMenu);
    }
};

onMounted(() => {});
</script>

<style lang="scss" scoped></style>
