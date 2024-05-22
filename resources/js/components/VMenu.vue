<template>
    <div>
        <slot name="activator" @click="showMenu"></slot>

        <Teleport to="#overlay">
            <Transition
                enter-active-class="duration-300 ease-out"
                leave-active-class="duration-300 ease-out"
                enter-from-class="opacity-0 scale-90"
                leave-to-class="opacity-0 scale-90"
            >
                <div
                    v-bind="$attrs"
                    class="fixed left-0 z-[2001] rounded-md bg-white text-sm shadow-xl"
                    v-show="show"
                    ref="menu"
                >
                    <slot
                        ><div>
                            Lorem ipsum dolor sit amet consectetur, adipisicing
                            elit. Inventore ipsum facere, ducimus distinctio
                            porro excepturi maxime! Perspiciatis quia quas quam
                            impedit adipisci esse fugiat dignissimos. Id
                            praesentium labore dolor totam? Lorem ipsum dolor
                            sit amet consectetur adipisicing elit. Natus, ipsam?
                            Voluptatibus, quis? Repellat consequuntur pariatur
                            sed illo tempore molestiae, sequi doloribus ipsam
                            cum libero quia laboriosam a! Perspiciatis, in
                            sequi!
                        </div>
                    </slot>
                </div>
            </Transition>
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

        const parentBound = e.currentTarget.getBoundingClientRect();
        const parentTop = parentBound.top;
        const parentHeight = parentBound.height;

        menu.value.style.top = parentTop + parentHeight + 5 + "px";

        await nextTick();

        // properly anchor the menu on either left or right side of the screen
        if (parentBound.left > window.innerWidth / 2) {
            console.log(menu.value.getBoundingClientRect().width);
            menu.value.style.left = `${parentBound.right - menu.value.getBoundingClientRect().width}px`;
        } else {
            menu.value.style.left = parentBound.left + "px";
        }
    } else {
        show.value = false;
        document.body.removeEventListener("click", handleCloseMenu);
    }
};

onMounted(() => {});
</script>

<style lang="scss" scoped></style>
