<template>
    <section
        id="home"
        class="relative grid animate-appear items-center gap-10 opacity-0 md:h-screen md:grid-cols-2"
    >
        <div
            class="relative mt-[4rem] text-center md:order-2 md:mt-0 md:text-left"
        >
            <v-heading>
                Extraordinary Themed, Seasonal Concepts and Custom Products
            </v-heading>
            <p class="mt-5">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero
                aspernatur veritatis quaerat officiis accusamus animi totam in
                velit corrupti modi atque perferendis necessitatibus iure,
                soluta, deleniti eaque dignissimos itaque nobis.
            </p>
            <div class="flex justify-center md:justify-start">
                <button
                    class="relative mt-4 block rounded-md bg-accent p-2 px-5 text-lg text-white opacity-0 animate-[appear_1s_ease-out_forwards_800ms]"
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
                class="mx-auto "
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
