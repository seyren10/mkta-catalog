<template>
    <div class="fixed inset-0 z-[3000] bg-black opacity-20"></div>
    <div class="fixed inset-0 z-[3001] grid place-items-center">
        <Transition
            appear
            enter-from-class="scale-50"
            enter-active-class="duration-300 ease-out"
        >
            <div
                class="relative grid overflow-hidden rounded-md bg-white shadow-lg"
                :style="maxWidth ? `max-width: ${maxWidth}px` : ''"
                v-closable
            >
                <slot name="header"></slot>
                <!-- TOOLBAR -->
                <v-toolbar v-if="!$slots.header" :title="title">
                    <v-button
                        icon="md-close-round"
                        @click="$emit('close')"
                    ></v-button>
                </v-toolbar>
                <!-- /TOOLBAR -->

                <div class="max-h-[90vh] overflow-y-auto">
                    <slot></slot>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { onMounted } from "vue";

//raeactive
const props = defineProps(["maxWidth", "title", "persistent"]);
const emit = defineEmits(["close"]);

//non-reactive
let started = true;

//methods
const handleBodyClick = (e) => {
    const el = handleBodyClick.el;

    if (el.contains(e.target)) {
        //when clicking inside the element
    } else if (!started) {
        emit("close");
    }

    //prevent from closing the dialog when clicking on the activator for the first time
    started = false;
};

//lifecycle hooks
onMounted(() => {
    // console.log("sampler");
});

//custom directives
const vClosable = {
    mounted: (el) => {
        if (props.persistent === "") {
            return;
        }

        handleBodyClick.el = el;
        document.body.addEventListener("click", handleBodyClick);
    },

    unmounted: (el) => {
        document.body.removeEventListener("click", handleBodyClick);
    },
};
</script>

<style lang="scss" scoped></style>
