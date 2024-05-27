<template>
    <div
        class="group relative overflow-hidden rounded-lg"
        @mouseover="removeAuto"
        @mouseleave="setAuto"
    >
        <div
            class="flex transition-all duration-1000 ease-out"
            :style="{
                transform: `translateX(${scrollOffset}%)`,
            }"
        >
            <img
                v-for="image in images"
                alt=""
                class="aspect-[3/1] min-w-full object-cover"
                :key="image"
                :src="image"
            />
            <!-- </TransitionGroup> -->
        </div>
        <button
            @click.="handlePrev"
            class="absolute inset-y-0 -left-[50px] pr-5 text-white duration-500 ease-out group-hover:left-2"
        >
            <v-icon name="md-keyboardarrowleft-round" scale="1.5"></v-icon>
        </button>
        <button
            @click="handleNext"
            class="absolute inset-y-0 -right-[50px] pl-5 text-white duration-500 ease-out group-hover:right-5"
        >
            <v-icon name="md-keyboardarrowright-round" scale="1.5"></v-icon>
        </button>

        <!-- #region overlay -->
        <slot name="overlay" :item="currentData"></slot>
        <div
            v-if="!$slots.overlay && currentData"
            class="absolute bottom-[3rem] left-[50%] z-[100] translate-x-[-50%] rounded-lg p-7 text-white backdrop-brightness-[.8]"
        >
            <h1 class="mb-2 font-medium">{{ currentData.title }}</h1>
            <p class="text-xs font-light tracking-wide">
                {{ currentData.description }}
            </p>
        </div>
        <!-- #endregion -->

        <!--#region DOT INDICATOR -->
        <div
            class="absolute bottom-2 left-[50%] z-10 flex translate-x-[-50%] items-center"
        >
            <v-icon
                v-for="(index, _) in images"
                :key="index"
                :name="index === currentImage ? 'oi-dot-fill' : 'oi-dot'"
                :scale="index === currentImage ? '1.3' : '1'"
                class="cursor-pointer p-0 text-white"
                :class="{ 'fill-accent': index === currentImage }"
                @click="setIndex(_)"
            ></v-icon>
        </div>
        <!--#endregion  -->
    </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
const props = defineProps({
    items: {
        type: Array,
        default: [],
    },
    manual: Boolean,
    interval: {
        type: [String, Number],
        default: 5000,
    },
});

//reacives
const currentIndex = ref(0);
const direction = ref("");
const id = ref(null);

//computed
const hasData = computed(() => {
    return props.items.some((e) => {
        return typeof e === "object";
    });
});

const images = computed(() => {
    if (hasData.value) {
        return props.items.reduce((acc, cur) => {
            acc.push(cur.img);
            return acc;
        }, []);
    } else return props.items;
});
const currentImage = computed(() => {
    return images.value[currentIndex.value];
});
const currentData = computed(() => {
    if (hasData.value) return props.items[currentIndex.value];
});

const scrollOffset = computed(() => {
    return direction.value === "right"
        ? -currentIndex.value * 100
        : currentIndex.value * -100;
});

//methods
const handleNext = function () {
    direction.value = "right";
    if (currentIndex.value < images.value.length - 1) {
        currentIndex.value++;
    } else currentIndex.value = 0;
};
const handlePrev = function () {
    direction.value = "left";
    if (currentIndex.value > 0) currentIndex.value--;
    else currentIndex.value = images.value.length - 1;
};

const setIndex = (index) => {
    if (index >= 0 && index < images.value.length) currentIndex.value = index;
};
const setAuto = (e) => {
    if (e) e.preventDefault();

    if (props.manual) return;

    id.value = setInterval(() => {
        handleNext();
    }, +props.interval);
};
const removeAuto = (e) => {
    clearInterval(id.value);
};
//hooks
onMounted(() => {
    setAuto();
});

onUnmounted(() => {
    removeAuto();
});
</script>

<style lang="scss" scoped></style>
