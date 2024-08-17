<template>
    <div>
        <slot name="activator" :props="{ ...listeners }"> </slot>

        <Teleport to="#overlay">
            <div ref="menuRef" class="absolute z-[100]">
                <div
                    v-if="menu"
                    class="relative overflow-hidden rounded-lg border bg-white"
                >
                    <AppLoader v-if="loading" color="accent"></AppLoader>
                    <slot :props="() => (menu = false)"></slot>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
import { nextTick, ref, watch } from "vue";
import AppLoader from "./AppLoader.vue";

const props = defineProps({
    loading: Boolean,
});
const menu = ref(false);
const activatorRef = ref(null);
const menuRef = ref(null);

const listeners = {
    onClick: (event) => {
        activatorRef.value = event.target;
        menu.value = !menu.value;
    },
};

watch(menu, (newValue) => {
    if (newValue) {
        reposition();

        window.addEventListener("resize", reposition);
    } else {
        menuRef.value.style.top = "0px";
        menuRef.value.style.left = "0px";

        window.removeEventListener("resize", reposition);
    }
});

function reposition() {
    nextTick(() => {
        const menuRect = menuRef.value.getBoundingClientRect();
        const activatorRect = activatorRef.value.getBoundingClientRect();

        if (activatorRect.left > window.innerWidth / 2) {
            /* poistion menu on the right */
            menuRef.value.style.left =
                activatorRect.left -
                menuRect.width +
                activatorRect.width +
                "px";
        } else {
            /* position menu on the left */
            menuRef.value.style.left = activatorRect.left + "px";
        }

        if (activatorRect.top > window.innerHeight / 2) {
            /* position the menu on top of the activator  */
            console.log(menuRect.height);
            menuRef.value.style.top =
                activatorRect.top - menuRect.height - 2 + "px";
        } else {
            /* position the menu on bottom of the activator */

            menuRef.value.style.top = activatorRect.bottom + 4 + "px";
        }
    });
}
</script>

<style lang="scss" scoped></style>
