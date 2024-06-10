<template>
    <div class="group overflow-hidden rounded-lg">
        <div
            :class="`relative isolate flex cursor-pointer items-center justify-between ${densityValue} ${bg}`"
            @click="expanded = !expanded"
        >
            <!-- backdrop -->
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
import { ref } from "vue";
import { useDensity, useDensityValues } from "@/composables/useInput";

const props = defineProps({
    ...useDensity(),
    title: {
        type: String,
        default: "Accordion",
    },
    icon: {
        type: String,
        default: "md-arrowdropdown-round",
    },
    bg: String,
    expanded: Boolean,
});

const densityValue = useDensityValues(props.density);
//reactives
const expanded = ref(props.expanded);

//derived props
</script>

<style lang="scss" scoped></style>
