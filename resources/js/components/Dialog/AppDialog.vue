<template>
    <div>
        <slot name="activator" :props="{ ...listeners }"></slot>

        <Teleport to="#overlay">
            <div
                class="fixed inset-0 z-[3000] bg-black bg-opacity-20"
                v-if="dialog"
            ></div>
            <Transition
                enter-active-class="duration-300"
                leave-active-class="duration-300"
                enter-from-class="opacity-0"
                leave-to-class="opacity-0"
            >
                <div
                    class="fixed inset-0 z-[3001] text-xs"
                    :class="{ 'grid place-content-center': !fullScreen }"
                    v-if="dialog"
                >
                    <AppDialogContent
                        class="relative my-auto min-w-[30rem] overflow-y-auto overflow-x-hidden mx-4"
                        :style="{
                            maxWidth: !fullScreen ? `${maxWidth}px` : 'auto',
                        }"
                        v-bind="$attrs"
                    >
                        <slot
                            name="toolbar"
                            :props="{ close: handleCloseDialog }"
                        >
                            <AppDialogToolbar v-bind="props">
                                <template #title>
                                    <slot name="title"></slot>
                                </template>
                            </AppDialogToolbar>
                        </slot>

                        <slot
                            :props="{ closeDialog: () => handleCloseDialog() }"
                        ></slot>
                    </AppDialogContent>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<script setup>
import { provide, useSlots } from "vue";
import { useKey } from "@/composables/useKey";

import AppDialogContent from "./AppDialogContent.vue";
import AppDialogToolbar from "./AppDialogToolbar.vue";

defineOptions({
    inheritAttrs: false,
});
const emits = defineEmits(["close"]);
const props = defineProps({
    persistent: Boolean,
    fullScreen: { type: Boolean, default: false },
    maxWidth: { type: [Number, String], default: "800" },
    ...AppDialogToolbar.props,
});
const dialog = defineModel({ default: false });
const slots = useSlots();

console.log(slots);
useKey("Escape", handleCloseDialog);

const listeners = {
    onClick: () => {
        dialog.value = !dialog.value;
    },
};

function handleCloseDialog() {
    dialog.value = false;
    emits("close");
}

provide("close", handleCloseDialog);
</script>

<style lang="scss" scoped></style>
