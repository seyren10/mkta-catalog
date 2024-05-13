<template>
    <section
        id="home"
        class="relative grid animate-appear items-center gap-10 opacity-0 md:h-screen md:grid-cols-2"
    >
        <!-- <Teleport to="body">
            <div
                class="bg-hero-background absolute inset-0 -z-10 bg-cover bg-fixed bg-top"
            ></div>
        </Teleport> -->
        <div
            class="relative mt-[4rem] text-center md:order-2 md:mt-0 md:text-left"
        >
            <v-heading type="display">
                Festive Lighting Solutions & Themed Decorations
            </v-heading>
            <p class="mt-5 font-medium text-slate-500">
                Creating magical experiences through design ingenuity and
                world-class craftsmanship to leisure centers and shopping malls
                worldwide.
            </p>
            <div class="mt-5 flex justify-center md:justify-start">
                <v-button
                    tag="a"
                    href="#become-a-partner"
                    class="relative mt-4 block animate-[appear_1s_ease-out_forwards_800ms] rounded-md bg-accent p-2 px-5 text-lg text-white opacity-0"
                >
                    <template #prepend-inner>
                        <v-icon
                            name="la-search-solid"
                            class="mr-2"
                            animation="wrench"
                        ></v-icon>
                    </template>
                    <span>Browse our catalog</span>
                </v-button>
            </div>
        </div>
        <div>
            <VCircularImages
                class="mx-auto"
                :img-src="circleImageData"
                base-img="/mk-images/rocket-removebg-preview.png"
                :offset="300"
                :circle-size="150"
                :speed="0.05"
            />
        </div>
        <div
            class="absolute bottom-20 left-[50%] hidden -translate-x-[50%] md:block"
        >
            <div class="animate-bounce">
                <v-icon name="la-arrow-circle-down-solid" scale="2"></v-icon>
            </div>
        </div>
    </section>
</template>

<script setup>
import VCircularImages from "./VCircularImages.vue";
import { computed } from "vue";

const circleImageData = computed(() => {
    return [
        "/mk-images/hero-images/1.png",
        "/mk-images/hero-images/2.png",
        "/mk-images/hero-images/3.png",
        "/mk-images/hero-images/4.png",
        "/mk-images/hero-images/5.png",
        "/mk-images/hero-images/6.png",
        "/mk-images/hero-images/7.png",
        "/mk-images/hero-images/8.png",
    ];
});
</script>

<style scoped></style>
