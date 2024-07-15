<template>
    <div>
        <slot name="activator" @click="model = true"> </slot>

        <Teleport to="#overlay">
            <Transition
                appear
                enter-active-class="duration-300"
                leave-active-class="duration-300"
                enter-from-class="translate-x-[5rem] opacity-0"
                leave-to-class="translate-x-[-5rem] opacity-0"
            >
                <TContent
                    v-if="model"
                    :timeout="timeout"
                    @close="handleCloseToast"
                    v-bind="$attrs"
                >
                    <template #default>
                        <slot></slot>
                    </template>
                </TContent>
            </Transition>
        </Teleport>
    </div>
</template>

<script setup>
import TContent from "./TContent.vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    timeout: [String, Number],
    default: 4000,
});

const model = defineModel({ default: false });

const handleCloseToast = () => {
    model.value = false;
};
</script>

<style lang="scss" scoped></style>
