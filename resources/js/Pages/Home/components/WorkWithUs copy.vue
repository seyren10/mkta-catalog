<template>
    <section id="work-with-us">
        <v-heading class="text-center">Reasons to work with us</v-heading>
        <div role="list" class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="(reason, index) in reasons"
                :key="index"
                role="listitem"
                class="group relative isolate grid min-h-60 cursor-default rounded-lg border border-stone-300 p-3 transition-transform duration-500 hover:-translate-y-5 hover:bg-stone-300 hover:shadow-md"
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
            title: "<span class='text-accent text-xl'>400</span> containers shipped yearly ensure timely delivery.",
            img: "/mk-images/Containers.jpg",
        },
        {
            title: "<span class='text-accent text-xl'>500</span> hardworking employees ensure quality and efficiency.",
            img: "/illustrations/employees.jpg",
        },
        {
            title: "Over <span class='text-accent text-xl'>4000</span> products made from fiberglass material, offering durability and versatility in various applications",
            img: "/illustrations/products.jpg",
        },
        {
            title: "Over <span class='text-accent text-xl'>2000</span> lighting products, providing a diverse range of lighting solutions for different settings and preferences.",
            img: "/illustrations/products.jpg",
        },
        {
            title: "Operating in a <span class='text-accent text-xl'>300,000 sq. ft.</span> factory ensures scale and quality.",
            img: "/mk-images/mk-building.jpg",
        },
        {
            title: "Exporting to all <span class='text-accent text-xl'>seven</span> continents signifies experience and reliability.",
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
