<template>
    <div class="grid items-center gap-10 md:grid-cols-2">
        <div class="relative flex h-[35rem] w-[35rem]">
            <TransitionGroup :name="direction">
                <div v-for="(item, index) in items" :key="item.title">
                    <img
                        alt=""
                        class="h-full w-full object-cover"
                        :src="item.img"
                        v-show="index === activeIndex"
                    />
                </div>
            </TransitionGroup>
            <button class="absolute left-0 top-[50%]" @click="handlePrev">
                <v-icon name="la-arrow-circle-left-solid" scale="2"></v-icon>
            </button>
            <button class="absolute right-0 top-[50%]" @click="handleNext">
                <v-icon name="la-arrow-circle-right-solid" scale="2"></v-icon>
            </button>
        </div>

        <div>
            <v-heading type="h1">{{ items[activeIndex].title }}</v-heading>
            {{ items[activeIndex].caption }}
        </div>
    </div>

    <button
        @click="
            () => {
                direction = 'prev';
                sample.splice(sample.length - 1, 1);
            }
        "
    >
        Prev
    </button>

    <button
        @click="
            () => {
                direction = 'next';
                sample.splice(sample.length - 1, 1);
            }
        "
    >
        Next
    </button>
    <TransitionGroup
        enter-active-class="duration-200 ease-out"
        leave-active-class="duration-200 ease-in"
        :enter-from-class="`${direction === 'next' ? 'translate-x-[30px]' : 'translate-x-[-30px]'} opacity-0`"
        enter-to-class="opacity-100 translate-x-0"
        leave-from-class="opacity-100 translate-x-0"
        :leave-to-class="`${direction === 'next' ? 'translate-x-[-30px]' : 'translate-x-[30px]'} opacity-0`"
        @after-leave="sample.push(Math.random())"
    >
        <div v-for="data in sample" :key="data">
            {{ data }}
        </div>
    </TransitionGroup>
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

const sample = ref(["init"]);

const handlePrev = () => {
    if (activeIndex.value > 0) activeIndex.value--;
    else activeIndex.value = props.items.length - 1;
    direction.value = "prev";
};
const handleNext = () => {
    if (activeIndex.value < props.items.length - 1) activeIndex.value++;
    else activeIndex.value = 0;

    direction.value = "next";
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
