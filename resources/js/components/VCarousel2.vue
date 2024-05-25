<template>
    <div
        class="group relative overflow-hidden rounded-lg"
        @mouseover="removeAuto"
        @mouseleave="setAuto"
    >
        <div class="flex" :class="{ 'flex-row-reverse': direction === 'left' }">
            <Transition
                enter-active-class="duration-1000 ease-out"
                leave-active-class="duration-1000 ease-out"
                :enter-to-class="`${direction === 'right' ? '-translate-x-full' : 'translate-x-full'}`"
                :leave-to-class="`${direction === 'right' ? '-translate-x-full' : 'translate-x-full'}`"
            >
                <img
                    alt=""
                    class="aspect-[3/1] min-w-full object-cover"
                    :key="currentImage"
                    :src="currentImage"
                />
            </Transition>
        </div>
        <button
            @click="handlePrev"
            class="absolute inset-y-0 -left-[50px] text-white duration-500 ease-out group-hover:left-2"
        >
            <v-icon name="md-keyboardarrowleft-round" scale="1.5"></v-icon>
        </button>
        <button
            @click="handleNext"
            class="absolute inset-y-0 -right-[50px] text-white duration-500 ease-out group-hover:right-2"
        >
            <v-icon name="md-keyboardarrowright-round" scale="1.5"></v-icon>
        </button>

        <!-- #region overlay -->
        <div
            class="absolute bottom-[2rem] z-[100] ml-5 rounded-lg p-5 text-white backdrop-brightness-[.8]"
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

//methods
const handleNext = function () {
    direction.value = "right";
    if (currentIndex.value < images.value.length - 1) currentIndex.value++;
    else currentIndex.value = 0;
};
const handlePrev = function () {
    direction.value = "left";
    if (currentIndex.value > 0) currentIndex.value--;
    else currentIndex.value = images.value.length - 1;
};

const setIndex = (index) => {
    console.log("index");
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
    if (e) e.preventDefault();

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
