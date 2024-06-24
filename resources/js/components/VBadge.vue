<template>
    <div
        class="absolute top-[-.8rem] rounded-full bg-red-500 px-1.5 text-[.7rem] font-medium text-white"
        :class="computedPosition"
        ref="badge"
    >
        <slot></slot>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";

const props = defineProps({
    position: {
        type: String,
        validator: (value) => {
            return ["start", "end", "center"].includes(value);
        },
        default: "end",
    },
});
const badge = ref(null);

//derives
const computedPosition = computed(() => {
    switch (props.position) {
        case "end": {
            return "right-[-0.5rem]";
        }
        case "center": {
            return "left-[50%] translate-x-[-50%]";
        }
        case "start": {
            return "left-[-0.5rem]";
        }
    }
});
//functions
const setRelativeOnParent = () => {
    const parent = badge.value.parentElement;

    if (parent.style.position !== "relative")
        parent.style.position = "relative";
};

onMounted(() => {
    setRelativeOnParent();
});
</script>

<style lang="scss" scoped></style>
