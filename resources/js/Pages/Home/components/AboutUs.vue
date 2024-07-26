<template>
    <section id="about">
        <v-heading class="text-center">About us</v-heading>
        <div class="grid gap-3 md:grid-cols-6 md:grid-rows-4">
            <div
                class="overflow-hidden rounded-lg bg-red-100 md:col-span-3 md:max-h-56"
            >
                <v-text-on-image
                    title="Nutcrackers"
                    :image="s3('aiayJKSffhV6yJkYmlfaOVThtayDrlFh61tgWU7o.jpg')"
                    class="h-full"
                    no-overlay
                ></v-text-on-image>
            </div>

            <div class="overflow-hidden rounded-lg bg-red-200">
                <v-text-on-image
                    title="Witch"
                    :image="s3('ikKZguF9HWpoa6jRM6sjlqoiOxYEd9ZBX8d03Lwp.jpg')"
                    class="h-full"
                    no-overlay
                ></v-text-on-image>
            </div>
            <div class="overflow-hidden rounded-lg bg-red-300 md:col-span-2">
                <v-text-on-image
                    title="InLiteFi"
                    :image="s3('msIIdY6EnCf4VDIFnnROQ78WEaWQSliUpYrjv4tm.jpg')"
                    class="h-full"
                    no-overlay
                ></v-text-on-image>
            </div>
            <div class="overflow-hidden rounded-lg bg-red-400 md:row-span-2">
                <v-text-on-image
                    title="Winter"
                    :image="s3('EwWzSTCCLqXOGCYOOFsucvEI1XcwKIV7QgXnhiIL.jpg')"
                    class="h-full"
                    no-overlay
                ></v-text-on-image>
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
                <v-text-on-image
                    title="Witch"
                    :image="s3('CF4K0me1eX98nDZgffM2yvZakGryDBWw91SGRf6s.jpg')"
                    class="h-full"
                    no-overlay
                ></v-text-on-image>
            </div>
            <div
                class="overflow-hidden rounded-lg bg-red-800 md:col-span-4 md:max-h-56"
            >
                <v-text-on-image
                    :image="s3('qHAjp9RAHnR8CUsxd7nQzqZTzXKdrluHECZQmZ0M.jpg')"
                    no-overlay
                    class="h-full"
                ></v-text-on-image>
            </div>
            <div
                class="overflow-hidden rounded-lg bg-red-600 md:col-span-2 md:max-h-56"
            >
                <v-text-on-image
                    title="Winter"
                    :image="s3('xtMDWidjQGtrUQuFHL8p1pgWnNMNfsTv9xNKgqXo.jpg')"
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
