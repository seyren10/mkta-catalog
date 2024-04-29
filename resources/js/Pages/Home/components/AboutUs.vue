<template>
    <section id="about" class="my-20">
        <v-heading class="mb-10 text-center">About us</v-heading>
        <div class="grid gap-5 md:grid-cols-6 md:grid-rows-2">
            <div class="space-y-3 text-center md:col-span-3 md:row-span-2">
                <p>
                    <span class="text-accent"
                        >MK Themed Attractions Philippines </span
                    >(formerly Tema Design) is a fiberglass products
                    manufacturer and is a part of the well-reputed Danish
                    Company: Creation Group. Best known for the creative
                    production of world-class products for decorations and
                    displays within different themes and Christmas, Comic,
                    Wildlife, Halloween, Wild West, Pirates, Easter, etc.
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
                class="overflow-hidden rounded-md transition-all duration-300 hover:-translate-y-2 md:col-span-2 md:row-span-2"
            >
                <VImageTextOverlay
                    title="Nutcrackers"
                    src="/mk-images/nutcrackers.jpg"
                    >We are the champion my friend, and we keep on fighting till
                    the end.</VImageTextOverlay
                >
            </div>
            <div
                class="overflow-hidden rounded-md transition-all duration-300 hover:-translate-y-2 md:row-span-3"
            >
                <VImageTextOverlay
                    title="Witch"
                    src="/mk-images/halloween.jpg"
                    class="h-full w-full"
                    >We are the champion my friend, and we keep on fighting till
                    the end.</VImageTextOverlay
                >
            </div>
            <div
                class="overflow-hidden rounded-md transition-all duration-300 hover:-translate-y-2 md:col-span-3 md:row-span-2"
            >
                <VImageTextOverlay
                    title="InLiteFi"
                    src="/mk-images/inlitefi.jpg"
                    class="h-full w-full"
                    >We are the champion my friend, and we keep on fighting till
                    the end.</VImageTextOverlay
                >
            </div>
            <div
                class="overflow-hidden rounded-md transition-all duration-300 hover:-translate-y-2 md:col-span-2 md:row-span-2"
            >
                <VImageTextOverlay
                    title="Winter"
                    src="/mk-images/winter.jpg"
                    class="h-full w-full"
                    >We are the champion my friend, and we keep on fighting till
                    the end.</VImageTextOverlay
                >
                <!-- <img
                    src="/mk-images/winter.jpg"
                    alt=" "
                    class="h-full w-full transition-all duration-300 hover:scale-110 hover:filter-none md:grayscale"
                /> -->
            </div>
            <div
                class="overflow-hidden rounded-md bg-stone-300 transition-all duration-300 hover:-translate-y-2"
            >
                <VImageTextOverlay
                    src="/mk-images/creation_group.png"
                    class="h-full w-full"
                    no-popup
                ></VImageTextOverlay>
            </div>
        </div>
    </section>
</template>

<script setup>
import VImageTextOverlay from "../../../components/VImageTextOverlay.vue";
</script>

<style scoped></style>
