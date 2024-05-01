<template>
    <div>
        <div
            class="relative mx-auto flex aspect-square max-w-[35rem] overflow-hidden"
        >
            <TransitionGroup
                enter-active-class="duration-300 ease"
                leave-active-class="duration-300 ease"
                :enter-from-class="`${direction === 'next' ? 'translate-x-[10rem]' : 'translate-x-[-10rem] opacity-0'} `"
                enter-to-class="opacity-100 translate-x-0"
                leave-from-class="opacity-100 translate-x-0"
                :leave-to-class="`${direction === 'next' ? 'translate-x-[-10rem]' : 'translate-x-[10rem]'} opacity-0`"
                @after-leave="sample.push(items[activeIndex])"
            >
                <div v-for="data in sample" :key="data">
                    <img :src="data.img" alt="" />
                </div>
            </TransitionGroup>
            <button class="absolute left-0 top-[50%]" @click="handlePrev">
                <v-icon
                    name="la-arrow-circle-left-solid"
                    scale="2"
                    class="duration-200 hover:fill-accent"
                ></v-icon>
            </button>
            <button class="absolute right-0 top-[50%]" @click="handleNext">
                <v-icon
                    name="la-arrow-circle-right-solid"
                    scale="2"
                    class="duration-200 hover:fill-accent"
                ></v-icon>
            </button>
        </div>

        <div class="mx-auto overflow-hidden p-3 min-h-[7lh]">
            <Transition
                enter-active-class="duration-300 ease"
                leave-active-class="duration-300 ease"
                enter-from-class="opacity-0"
                leave-to-class="opacity-0"
                mode="out-in"
            >
                <div :key="activeIndex">
                    <v-heading type="h2">{{
                        items[activeIndex].title
                    }}</v-heading>
                    <p>{{ items[activeIndex].caption }}</p>
                </div>
            </Transition>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
    items: {
        type: Array,
    },
});

const direction = ref("");
const activeIndex = ref(0);

const sample = ref([props.items[0]]);

const handlePrev = () => {
    if (activeIndex.value > 0) activeIndex.value--;
    else activeIndex.value = props.items.length - 1;
    direction.value = "prev";
    sample.value = [];
};

const handleNext = () => {
    if (activeIndex.value < props.items.length - 1) activeIndex.value++;
    else activeIndex.value = 0;

    direction.value = "next";
    sample.value = [];
};
</script>

<style scoped>
.next-move,
.next-enter-active,
.next-leave-active,
.prev-move,
.prev-enter-active,
.prev-leave-active {
    transition: all 0.5s ease;
}

.next-enter-from,
.prev-leave-to {
    transform: translateX(30px);
}

.next-leave-to,
.prev-enter-from {
    transform: translateX(-30px);
}

/* ensure leaving items are taken out of layout flow so that moving
   animations can be calculated correctly. */
/* .fade-leave-active {
    position: absolute;
} */
</style>
