<template>
    <section id="work-with-us" class="mt-20">
        <v-heading class="mb-10 text-center">Reasons to work with us</v-heading>
        <div role="list" class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="(reason, index) in reasons"
                :key="index"
                role="listitem"
                class="group relative isolate grid min-h-60 cursor-default rounded-md border border-stone-300 p-3 transition-transform duration-500 hover:-translate-y-5 hover:bg-stone-300 hover:shadow-md"
                :class="{
                    'animate-appear': startAnimation,
                    'opacity-1': !startAnimation,
                }"
                :style="{ animationDelay: `${(index + 1) * 200}ms` }"
                ref="lists"
            >
                <img
                    :src="reason.img"
                    alt=""
                    class="aspect-video w-full object-cover"
                />
                <p
                    class="mt-5 place-self-stretch text-center group-hover:font-bold"
                    v-html="reason.title"
                ></p>

                <span
                    class="absolute left-5 top-5 z-10 text-6xl font-bold text-stone-300 transition-colors duration-500 group-hover:text-accent"
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
        {
            title: "We shipped an average of <span class='text-accent text-xl'>400</span> containers yearly.",
            img: "/illustrations/loading-van.jpg",
        },
        {
            title: "We have a hard working  <span class='text-accent text-xl'>500</span> employees.",
            img: "/illustrations/employees.jpg",
        },
        {
            title: "We have more than  <span class='text-accent text-xl'>4000+</span> items in our catalog, in fiberglass.",
            img: "/illustrations/products.jpg",
        },
        {
            title: "We have more that  <span class='text-accent text-xl'>2000+</span> items in our light collection.",
            img: "/illustrations/products.jpg",
        },
        {
            title: "Our factory is  <span class='text-accent text-xl'>300,000</span> sq. ft.",
            img: "/illustrations/factory.jpg",
        },
        {
            title: "We export our items to all seven continents",
            img: "/illustrations/port.jpg",
        },
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
