<template>
    <section id="about">
        <v-heading class="text-center">About us</v-heading>
        <div class="grid gap-3 md:grid-cols-6 md:grid-rows-4">
            <div class="overflow-hidden rounded-lg bg-red-100 md:col-span-3">
                <v-text-on-image
                    :image="s3('resources/homepage-images/111x40.jpg')"
                    class="h-[15rem]"
                    no-overlay
                ></v-text-on-image>
            </div>

            <div class="overflow-hidden rounded-lg bg-red-200">
                <v-text-on-image
                    :image="
                        s3(
                            'resources/homepage-images/1x1_animal_nutcrackers.jpg',
                        )
                    "
                    class="h-full"
                    no-overlay
                ></v-text-on-image>
            </div>
            <div class="overflow-hidden rounded-lg bg-red-300 md:col-span-2">
                <v-text-on-image
                    :image="s3('resources/homepage-images/11+x+6.jpg')"
                    class="h-[15rem]"
                    no-overlay
                ></v-text-on-image>
            </div>

            <div class="overflow-hidden rounded-lg bg-red-400 md:row-span-2">
                <v-text-on-image
                    :image="s3('resources/homepage-images/107+x+246+v2.jpg')"
                    class="h-full"
                    no-overlay
                ></v-text-on-image>
            </div>

            <div
                class="my-auto space-y-3 p-5 text-center md:col-span-4 md:row-span-2"
            >
                <p>
                    <span class="text-accent"
                        >MK Themed Attractions Philippines
                    </span>
                    is a fiberglass products manufacturer. Best known for
                    the creative production of world-class products for
                    decorations and displays within different themes and
                    Christmas, Comic, Wildlife, Halloween, Wild West, Pirates,
                    Easter, etc.
                </p>
                <p>
                    We use high-quality materials in produing fiberglass
                    products and projects to ensure the best quality and meet
                    the satisfactions of our partners. Our main markets are
                    amusement parks, malls, hotels, bars, resorts, and family
                    entertainment
                </p>
                <p>
                    We are a group of designers, architects, sculptors, casters,
                    painters, welders, installers, projects, and techinical
                    managers that can help our client with the requirements for
                    custom design, development, manufacturing, and installations
                    of small to large scale projects worldwide.
                </p>
            </div>

            <div
                class="overflow-hidden rounded-lg bg-red-700 md:col-span-1 md:row-span-2"
            >
                <v-text-on-image
                    title="Witch"
                    :image="s3('resources/homepage-images/107+x+246.jpg')"
                    class="h-full"
                    no-overlay
                ></v-text-on-image>
            </div>
            <div
                class="overflow-hidden rounded-lg bg-red-800 md:col-span-4 md:max-h-56"
            >
                <v-text-on-image
                    :image="s3('resources/homepage-images/223+x+56+.jpg')"
                    no-overlay
                    class="h-full"
                ></v-text-on-image>
            </div>
            <div
                class="overflow-hidden rounded-lg bg-red-600 md:col-span-2 md:max-h-56"
            >
                <v-text-on-image
                    :image="s3('resources/homepage-images/55+x+28.jpg')"
                    class="h-full w-full"
                    no-overlay
                ></v-text-on-image>
            </div>
        </div>
    </section>
</template>

<script setup>
import { inject } from "vue";

const s3 = inject("s3");
</script>

<style scoped></style>
