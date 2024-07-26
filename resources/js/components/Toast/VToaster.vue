<template>
    <Teleport to="#toast">
        <div class="fixed right-5 top-5 z-[9999] space-y-2">
            <TransitionGroup
                enter-active-class="duration-300"
                leave-active-class="duration-300"
                enter-from-class="opacity-0 translate-x-[100%]"
                leave-to-class="opacity-0 translate-x-[100%]"
            >
                <VToasterContent
                    v-for="child in children"
                    :key="child.props.id"
                    v-bind="child.props"
                >
                    {{ child.content }}
                </VToasterContent>
            </TransitionGroup>
        </div>
    </Teleport>
</template>

<script setup>
import VToasterContent from "./VToasterContent.vue";

const props = defineProps({
    children: Array,
    timeout: [String, Number],
});
</script>

<style lang="scss" scoped></style>
