<template>
    <div>
        <div
            class="gap-2 rounded-md"
            :class="`${!stacked ? 'flex items-center' : 'grid text-center'} ${densityValues}`"
            v-for="item in items"
            :key="item.title"
        >
            <v-icon
                v-if="item.icon"
                :name="item.icon"
                :scale="+iconSize"
                :class="{ 'mx-auto': stacked }"
            ></v-icon>
            <div>
                <div :class="titleClass" v-if="!$slots.title">
                    {{ item.title }}
                </div>
                <slot name="title" :item="item"></slot>
                <span :class="valueClass">{{ item.value }} </span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useDensity, useDensityValues } from "@/composables/useInput";
const props = defineProps({
    ...useDensity(),
    items: {
        type: Array,
    },
    titleClass: {
        type: String,
        default: " font-medium",
    },
    valueClass: {
        type: String,
        default: "text-slate-500",
    },
    stacked: {
        type: Boolean,
        default: false,
    },
    iconSize: {
        type: [String, Number],
        default: "1.5",
    },
});

const densityValues = useDensityValues(props.density);
</script>

<style lang="scss" scoped></style>
