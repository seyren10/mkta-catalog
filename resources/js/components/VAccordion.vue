<template>
    <div
        class="group cursor-pointer overflow-hidden rounded-md"
        @click="expanded = !expanded"
    >
        <!-- backdrop -->

        <div
            :class="`relative isolate flex items-center justify-between bg-stone-200 p-2 ${densityValue}`"
        >
            <div
                class="absolute inset-0 -z-10 duration-500"
                :class="{ 'backdrop-brightness-75': expanded }"
            ></div>
            <slot name="title"></slot>
            <p v-if="!$slots.title">{{ title }}</p>
            <v-icon :name="icon" :flip="expanded ? 'vertical' : null"></v-icon>
        </div>

        <div
            class="grid overflow-hidden transition-[grid-template-rows] duration-300"
            :class="{
                'grid-rows-[0fr]': !expanded,
                'grid-rows-[1fr]': expanded,
            }"
        >
            <div class="overflow-hidden bg-white">
                <div class="p-3">
                    <slot>
                        Lorem, ipsum dolor sit amet consectetur adipisicing
                        elit. Vel modi, quisquam suscipit non provident dolor
                        labore culpa necessitatibus consequuntur cumque vitae
                        fuga libero aliquam, aspernatur veritatis impedit
                        eligendi ratione ipsam.
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

const props = defineProps({
    density: {
        type: String,
        default: "default",
    },
    title: {
        type: String,
        default: "Accordion",
    },
    icon: {
        type: String,
        default: "md-arrowdropdown-round",
    },
});

//reactives
const expanded = ref(false);

//derived props

const densityValue = computed(() => {
    switch (props.density) {
        case "default":
            return "p-3";
        case "compact": {
            return "p-2";
        }
        case "comfortable": {
            return "p-4";
        }
        default:
            break;
    }
});
</script>

<style lang="scss" scoped></style>
