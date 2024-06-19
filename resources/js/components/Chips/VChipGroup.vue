<template>
    <div
        class="relative flex flex-wrap items-center gap-3 rounded-lg border p-3"
        ref="chipgroupElement"
    >
        <TransitionGroup
            enter-active-class="duration-300"
            leave-active-class="duration-300"
            enter-from-class="opacity-0"
            leave-to-class="opacity-0"
        >
            <v-chip
                v-for="(item, index) in items"
                class="text-[.8rem]"
                icon-size=".8"
                :prepend-inner-icon="item.icon"
                :key="isItemObject ? item.id : index"
            >
                <template #append-inner v-if="clearable">
                    <v-icon
                        name="md-close-round"
                        @click="$emit('delete', item)"
                        class="cursor-pointer"
                    ></v-icon>
                </template>

                <template #prepend-inner v-if="isItemObject && item.icon">
                    <v-icon :name="item.icon"></v-icon>
                </template>

                {{ isItemObject ? item.value : item }}</v-chip
            >
        </TransitionGroup>

        <slot name="append" ref="append"></slot>
    </div>
</template>

<script setup>
import { computed, inject, ref } from "vue";

const props = defineProps({
    items: [Array],
});
defineEmits(["delete"]);

const append = ref(null);
const clearable = inject("clearable", false);

const chipgroupElement = ref(null);

//expose
defineExpose({
    chipgroupElement,
});
//derived
const isItemObject = computed(() => {
    if (!props.items) return false;

    return typeof props.items[0] === "object";
});
</script>

<style lang="scss" scoped></style>
