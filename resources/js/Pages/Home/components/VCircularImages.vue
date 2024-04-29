<template>
    <div class="relative isolate -z-50">
        <img :src="baseImg" alt="" class="m-auto" />
        <div
            v-for="(img, index) in imgSrc"
            :key="img"
            class="absolute z-[-100] aspect-square overflow-hidden rounded-full"
            :style="`
            top: 38%;
            left: 38%;
            width: ${circleSize}px;
            transform: translate(calc(cos(${index * degrees + timer * speed}deg) * ${offset}px), calc(sin(${index * degrees + timer * speed}deg) * ${offset}px));`"
        >
            <img :src="img" alt="" class="h-full w-full object-cover" />
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";

const props = defineProps({
    imgSrc: {
        type: Array,
    },
    baseImg: {
        type: String,
    },
    offset: {
        type: Number,
        default: 100,
    },
    circleSize: {
        type: Number,
        default: 20,
    },
    speed: {
        type: Number,
        default: 0.05,
    },
});

const degrees = computed(() => {
    return 360 / props.imgSrc.length;
});

const timer = ref(0);
const timerId = ref(null);

const stopTimer = () => {
    clearInterval(timerId.value);
    timer.value = 0;
};

onMounted(() => {
    timerId.value = setInterval(() => {
        if (timer.value * props.speed < 360) timer.value++;
        else timer.value = 0;
    }, 10);
});

onUnmounted(() => {
    stopTimer();
});
</script>

<style lang="scss" scoped></style>
