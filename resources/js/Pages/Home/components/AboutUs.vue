<template>
    <section id="about">
        <v-heading class="text-center">About us</v-heading>
        <div class="grid gap-3 md:grid-cols-6 md:grid-rows-4">
            <div
                class="overflow-hidden rounded-lg bg-red-100 md:col-span-3 md:max-h-56"
            >
                <VImageTextOverlay
                    title="Nutcrackers"
                    src="/mk-images/nutcrackers.jpg"
                    class="h-full w-full"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Fugiat magnam fugit enim in sint quis nemo nobis modi
                    quaerat.</VImageTextOverlay
                >
            </div>

            <div class="overflow-hidden rounded-lg bg-red-200">
                <VImageTextOverlay
                    title="Witch"
                    src="/mk-images/halloween.jpg"
                    class="h-full w-full"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Fugiat magnam fugit enim in sint quis nemo nobis modi
                    quaerat.</VImageTextOverlay
                >
            </div>
            <div class="overflow-hidden rounded-lg bg-red-300 md:col-span-2">
                <VImageTextOverlay
                    title="InLiteFi"
                    src="/mk-images/inlitefi.jpg"
                    class="h-full w-full"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Fugiat magnam fugit enim in sint quis nemo nobis modi
                    quaerat.</VImageTextOverlay
                >
            </div>
            <div class="overflow-hidden rounded-lg bg-red-400 md:row-span-2">
                <VImageTextOverlay
                    title="Winter"
                    src="/mk-images/winter.jpg"
                    class="h-full w-full"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Fugiat magnam fugit enim in sint quis nemo nobis modi
                    quaerat.</VImageTextOverlay
                >
            </div>

            <div
                class="my-auto space-y-3 p-5 text-center md:col-span-4 md:row-span-2"
            >
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
                class="overflow-hidden rounded-lg bg-red-700 md:col-span-1 md:row-span-2"
            >
                <VImageTextOverlay
                    title="Witch"
                    src="/mk-images/halloween.jpg"
                    class="h-full w-full"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Fugiat magnam fugit enim in sint quis nemo nobis modi
                    quaerat.</VImageTextOverlay
                >
            </div>
            <div
                class="overflow-hidden rounded-lg bg-red-800 md:col-span-4 md:max-h-56"
            >
                <VImageTextOverlay
                    src="/mk-images/creation_group.png"
                    class="h-full w-full"
                    no-popup
                ></VImageTextOverlay>
            </div>
            <div
                class="overflow-hidden rounded-lg bg-red-600 md:col-span-2 md:max-h-56"
            >
                <VImageTextOverlay
                    title="Winter"
                    src="/mk-images/winter.jpg"
                    class="h-full w-full"
                    >Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Fugiat magnam fugit enim in sint quis nemo nobis modi
                    quaerat.</VImageTextOverlay
                >
            </div>
        </div>
    </section>
</template>

<script setup>
import VImageTextOverlay from "../../../components/VImageTextOverlay.vue";
</script>

<style scoped></style>
