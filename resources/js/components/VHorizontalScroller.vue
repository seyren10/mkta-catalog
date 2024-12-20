<template>
    <div class="" @mouseover="handleHover" @mouseleave="handleHoverLeave">
        <slot name="header">
            <h1>{{ title }}</h1>
        </slot>
        <div class="group/scroller relative overflow-hidden rounded-lg">
            <slot
                name="items"
                :items="items"
                class="relative left-0 duration-500"
            >
                <div
                    class="relative left-0 grid grid-flow-col duration-500"
                    :style="{
                        gridTemplateRows: `repeat(${+columns},1fr)`,
                        gridAutoColumns: `${itemSize}`,
                    }"
                    ref="scroller"
                >
                    <div v-for="(item, index) in items" class="overflow-hidden">
                        <slot :item="item" :isMatched="isMatched"> {{ item }} </slot>
                    </div>
                </div>
            </slot>

            <template v-if="!noNavigation">
                <button
                    @click="next"
                    class="absolute inset-y-0 right-0 cursor-pointer px-3 text-white duration-300"
                    :class="{
                        'bg-black bg-opacity-15': scrim,
                        'right-[-30%] group-hover/scroller:right-0': isMatched,
                    }"
                >
                    <v-icon
                        name="md-keyboardarrowright-round"
                        scale="1.5"
                    ></v-icon>
                </button>
                <button
                    @click="prev"
                    class="absolute inset-y-0 cursor-pointer px-3 text-white duration-300"
                    :class="{
                        'bg-black bg-opacity-15': scrim,
                        'left-[-30%] group-hover/scroller:left-0': isMatched,
                    }"
                >
                    <v-icon
                        name="md-keyboardarrowleft-round"
                        scale="1.5"
                    ></v-icon>
                </button>
            </template>

            <div
                v-if="!noIndicator"
                class="absolute bottom-[5%] left-[50%] flex translate-x-[-50%] gap-1 text-white"
                :class="{
                    'rounded-full bg-black bg-opacity-15 px-2 py-1': scrim,
                }"
            >
                <v-icon
                    name="oi-dot-fill"
                    v-for="(_, index) in maxScroll + 1 || []"
                    :key="index"
                    class="cursor-pointer"
                    :class="{
                        'text-accent': index === currentScroll,
                    }"
                    @click="goTo(index)"
                ></v-icon>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { useHorizontalScroller } from "@/composables/useHorizontalScroller";
import { useMedia } from "@/composables/useMedia";

const props = defineProps({
    columns: {
        type: [String, Number],
        default: "1",
    },
    itemSize: {
        type: [String, Number],
        default: "auto",
    },
    items: {
        type: Array,
    },
    title: String,
    autoScroll: {
        type: Boolean,
        default: false,
    },
    interval: {
        type: [String, Number],
        default: "5000",
    },
    scrim: Boolean,
    noIndicator: Boolean,
    noNavigation: Boolean,
    activator: Object,
    showNavigation: Boolean,
});

const model = defineModel();

//reactives
const isHovering = ref(false);
const activator = computed(() => props.activator);

const horizontalScroller = useHorizontalScroller(
    props.autoScroll,
    +props.interval,
    activator,
);
const { isMatched } = useMedia("(min-width: 768px )");

const {
    scroller,
    next: scrollNext,
    prev: scrollPrev,
    currentScroll,
    maxScroll,
    setAutoScroll,
    clearAutoScroll,
    goTo,
    transitioning,
} = horizontalScroller;

//methods
const handleHover = (e) => {
    if (!isHovering.value) {
        clearAutoScroll();
        isHovering.value = true;
    }
};

const handleHoverLeave = () => {
    isHovering.value = false;
    setAutoScroll();
};

const next = () => {
    scrollNext();
    model.value = currentScroll.value;
};
const prev = () => {
    scrollPrev();
    model.value = currentScroll.value;
};

//watchers
let runOnce = false;
watch(model, (newValue, oldValue) => {
    if (!transitioning.value) {
        goTo(+newValue);
    } else {
        //prevent recursion from happening
        if (!runOnce) {
            model.value = oldValue; //this will result in a recursion without runOnce
            runOnce = true;
        } else {
            runOnce = false;
        }
    }
});
</script>

<style lang="scss" scoped></style>
