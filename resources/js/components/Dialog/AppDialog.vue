<template>
    <div>
        <slot name="activator" :props="{ ...listeners }"></slot>

        <Teleport to="#overlay">
            <div
                class="absolute inset-0 z-[200] bg-black bg-opacity-20"
                v-if="dialog"
            ></div>
            <Transition
                enter-active-class="duration-300"
                leave-active-class="duration-300"
                enter-from-class="opacity-0"
                leave-to-class="opacity-0"
            >
                <div
                    class="absolute inset-0 z-[201] text-xs"
                    :class="{ 'grid place-content-center': !fullScreen }"
                    v-if="dialog"
                >
                    <AppDialogContent
                        class="my-auto overflow-y-auto overflow-x-hidden"
                        :style="{
                            maxWidth: !fullScreen ? `${maxWidth}px` : 'auto',
                        }"
                        v-bind="$attrs"
                    >
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
import AppDialogContent from "./AppDialogContent.vue";
import { useKey } from "@/composables/useKey";

defineOptions({
    inheritAttrs: false,
});
const emits = defineEmits(["close"]);
const props = defineProps({
    persistent: Boolean,
    fullScreen: { type: Boolean, default: false },
    maxWidth: { type: [Number, String], default: "800" },
});
const dialog = defineModel({ default: false });
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
</script>

<style lang="scss" scoped></style>
