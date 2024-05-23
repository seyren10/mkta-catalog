<template>
    <nav class="bg-slate-600">
        <div class="container">
            <div
                class="hidden justify-end pt-1 text-[min(1vw_+_.3rem,.7rem)] text-slate-400 md:flex"
            >
                <div class="flex items-center">
                    <v-text-icon
                        class="flex gap-3 md:gap-5"
                        density=""
                        :items="headerData"
                        icon-size=".9"
                    ></v-text-icon>
                </div>
            </div>

            <div class="ml-auto flex w-fit items-center gap-2 py-2 md:hidden">
                <span class="cursor-pointer text-slate-200 underline">{{
                    user.name
                }}</span>
                <img
                    src="/mk-images/hero-images/3.png"
                    alt="profile"
                    class="max-w-5 rounded-full bg-white ring ring-slate-700"
                />
            </div>
            <div class="mt-3 flex items-center justify-between gap-5">
                <img
                    src="/MKLogo-White.svg"
                    alt=""
                    class="mr-3 hidden max-w-[6rem] sm:block"
                />

                <div class="inline-flex grow items-center gap-5 sm:grow-0">
                    <div
                        class="flex grow overflow-hidden rounded-md bg-white duration-500 has-[:focus]:ring-4 has-[:focus]:ring-accent sm:w-[max(35vw_+_1rem,_25rem)]"
                    >
                        <div class="my-auto grow pt-1">
                            <textarea
                                class="w-full resize-none px-4 text-primary outline-none"
                                rows="1"
                                placeholder="Search for products"
                            />
                        </div>
                        <v-button class="rounded-none bg-accent text-white">
                            <div class="px-2">
                                <v-icon
                                    name="la-search-solid"
                                    scale="1"
                                ></v-icon>
                            </div>
                        </v-button>
                    </div>
                    <div class="cursor-pointer">
                        <v-tooltip>Wishlist</v-tooltip>
                        <v-icon name="la-heart" scale="1.5" class="fill-accent">
                        </v-icon>
                    </div>
                </div>

                <div class="hidden items-center gap-2 md:flex">
                    <span class="cursor-pointer underline">{{
                        user.name
                    }}</span>
                    <img
                        src="/mk-images/hero-images/3.png"
                        alt="profile"
                        class="max-w-10 rounded-full bg-white ring ring-slate-700"
                    />
                </div>
            </div>
        </div>
        <div class="bg-slate-700">
            <div class="container mt-3 flex items-center gap-4 py-1">
                <v-menu class="p-3">
                    <template #activator="props">
                        <v-button
                            v-bind="props"
                            class="text-[.8rem] text-slate-300"
                            append-inner-icon="md-keyboardarrowdown-round"
                            >All Categories</v-button
                        >
                    </template>
                    <div class="grid max-w-[35rem] grid-cols-3 gap-3 ">
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                    </div>
                </v-menu>

                <div class="hidden flex-wrap gap-3 sm:flex">
                    <v-button
                        class="w-max px-0.5 text-[.75rem] text-slate-400"
                        no-hover-effect
                        v-for="feature in features"
                        :key="feature.title"
                    >
                        {{ feature.title }}</v-button
                    >
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { inject } from "vue";

const features = [
    { title: "Holloween" },
    { title: "Christmas" },
    { title: "Archways" },
    { title: "Summer" },
    { title: "Comics" },
    { title: "Cartoons" },
    { title: "Anime" },
    { title: "Dragons" },
    { title: "Nutcrackers" },
    { title: "Dont Blame the Kids" },
];

const headerData = [
    { title: "Contact Sales Support", icon: "ri-customer-service-2-line" },
    { title: "Report a problem", icon: "ri-bug-2-line" },
    { title: "Asia", icon: "pr-globe" },
];

const user = inject("user");
</script>

<style lang="scss" scoped></style>
