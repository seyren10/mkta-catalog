<template>
    <section id="work-with-us">
        <v-heading class="text-center">Reasons to work with us</v-heading>
        <div class="relative rounded-md">
            <Transition
                enter-from-class="opacity-0"
                leave-to-class="opacity-0"
                leave-active-class="duration-1000 ease absolute"
                enter-active-class="duration-1000 ease"
            >
                <img
                    :key="activeImage"
                    :src="activeImage"
                    class="aspect-[16/9] w-full rounded-md object-fill"
                />
            </Transition>

            <ul
                class="inset-x-28 bottom-10 grid items-end gap-3 md:absolute md:grid-cols-3"
            >
                <li
                    v-for="(reason, index) in reasons"
                    :key="reason.title"
                    class="group rounded-md p-3 text-slate-300 backdrop-brightness-[.4] duration-500 hover:bg-primary"
                    ref="lists"
                    @mouseover="activeImage = reason.img"
                    @mouseleave="activeImage = defaultImage"
                >
                    <span class="text-2xl font-bold"
                        >{{ 1 + index > 9 ? "" : "0" }}{{ ++index }}</span
                    >
                    <v-heading type="h3" class="text-white">{{
                        reason.title
                    }}</v-heading>
                    <div
                        class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out group-hover:grid-rows-[1fr]"
                    >
                        <p
                            class="overflow-hidden font-light text-white"
                            v-html="reason.description"
                        ></p>
                    </div>
                </li>
            </ul>
        </div>
    </section>
</template>

<script setup>
import { computed, ref } from "vue";

//non-reactive
let defaultImage = "/mk-images/hero-background.jpg";
//reactives
const lists = ref(null);
const activeImage = ref(defaultImage);

//devired properties
const reasons = computed(() => {
    return [
        {
            title: "Timely Delivery Assurance",
            description:
                "<span class='text-accent text-xl'>400</span> containers shipped yearly ensure timely delivery.",
            img: "/mk-images/Containers.jpg",
        },
        {
            title: "Quality Workforce Guarantee",
            description: `<span class='text-accent text-xl'>500</span> hardworking employees ensure quality and efficiency. `,
            img: "/mk-images/VISSION.jpg",
        },
        {
            title: "Fiberglass Durability",
            description:
                "Over <span class='text-accent text-xl'>4000</span> products made from fiberglass material, offering durability and versatility in various applications",
            img: "/illustrations/products.jpg",
        },
        {
            title: "Illuminating Diversity",
            description:
                "Over <span class='text-accent text-xl'>2000</span> lighting products, providing a diverse range of lighting solutions for different settings and preferences.",
            img: "/mk-images/INLITEFI PICTURE.jpg",
        },
        {
            title: "Scale and Quality Hub",
            description:
                "Operating in a <span class='text-accent text-xl'>300,000 sq. ft.</span> factory ensures scale and quality.",
            img: "/mk-images/mk-building.jpg",
        },
        {
            title: "Global Reliability",
            description:
                "Exporting to all <span class='text-accent text-xl'>seven</span> continents signifies experience and reliability.",
            img: "/mk-images/reason-8.jpg",
        },
    ];
});
</script>

<style scoped></style>
