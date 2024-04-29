<template>
    <section
        id="home"
        class="relative grid animate-appear items-center gap-10 opacity-0 md:h-screen md:grid-cols-2"
    >
        <div
            class="relative mt-[4rem] text-center md:order-2 md:mt-0 md:text-left"
        >
            <v-heading>
                Festive Lighting Solutions & Themed Decorations
            </v-heading>
            <p class="mt-5">
                Creating magical experiences through design ingenuity and
                world-class craftsmanship to leisure centers and shopping malls
                worldwide.
            </p>
            <div class="flex justify-center md:justify-start">
                <button
                    class="relative mt-4 block animate-[appear_1s_ease-out_forwards_800ms] rounded-md bg-accent p-2 px-5 text-lg text-white opacity-0"
                >
                    <v-icon
                        name="la-search-solid"
                        class="mr-2"
                        animation="wrench"
                    ></v-icon>
                    <span>Browse our catalog</span>
                </button>
            </div>
        </div>
        <div>
            <img
                src="/mk-images/rocket-removebg-preview.png"
                alt="rocket"
                class="mx-auto"
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

<script setup></script>

<style scoped></style>
