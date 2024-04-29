<template>
    <section id="work-with-us" class="mt-20">
        <v-heading class="mb-10 text-center">Reasons to work with us</v-heading>
        <div role="list" class="grid gap-5 md:grid-cols-3 lg:grid-cols-4">
            <div
                v-for="(reason, index) in reasons"
                :key="index"
                role="listitem"
                class="group relative isolate grid min-h-36 cursor-default rounded-md border border-stone-300 p-3 transition-transform duration-300 hover:-translate-y-5 hover:bg-stone-300 hover:shadow-md"
                :class="{
                    'animate-appear': startAnimation,
                    'opacity-1': !startAnimation,
                }"
                :style="{ animationDelay: `${(index + 1) * 200}ms` }"
                ref="lists"
            >
                <p class="mt-auto place-self-stretch">
                    {{ reason }}
                </p>
                <span
                    class="absolute left-5 top-5 -z-10 text-6xl font-bold text-stone-300 transition-colors duration-300 group-hover:text-accent"
                    >{{ 1 + index > 9 ? "" : "0" }}{{ ++index }}</span
                >
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
const lists = ref([]);
const startAnimation = ref(true);

const reasons = computed(() => {
    return [
        "We believe that everything is possible",
        "The end-user is our top priority",
        "Our passion is our work",
        "We make dreams come true",
        "We champion innovation and forward-thinking",
        "We focus exclusively on themed attractions",
        "We offer globel experience and local expertise",
        "Lorem ipsum dolor sit amet, consectetur adipisicing elit",
        "Lorem ipsum dolor sit amet, consectetur adipisicing elit",
        "Lorem ipsum dolor sit amet, consectetur adipisicing elit",
        "Lorem ipsum dolor sit amet, consectetur adipisicing elit",
    ];
});

onMounted(() => {
    const animationDuration = 200 * reasons.value.length + 800;

    setTimeout(() => {
        startAnimation.value = false;
    }, animationDuration);
});
</script>

<style scoped></style>
