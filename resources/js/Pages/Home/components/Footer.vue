<template>
    <div
        class="flex flex-wrap gap-5 bg-stone-700 px-10 pb-3 pt-10 text-sm text-slate-300"
    >
        <div class="basis-[10rem]">
            <img
                src="/MKLogo-White.svg"
                alt="MK Themed Attractions"
                class="aspect-square"
            />
        </div>
        <div>
            <v-text-icon
                :items="locations"
                titleClass="text-slate-500 mb-2 font-medium"
                valueClass="text-slate-200"
            ></v-text-icon>
        </div>
        <div>
            <v-text-icon
                :items="socials"
                class="text-slate-500"
                valueClass="text-slate-200"
            >
                <template #title="{ item }">
                    <a
                        :href="item.link"
                        target="_blank"
                        class="text-slate-300 duration-300 hover:text-slate-100"
                        >{{ item.title }}</a
                    >
                </template>
            </v-text-icon>
        </div>
        <div class="grow self-end text-end">
            <div class="inline-flex gap-3">
                <Disclaimer />
                <PrivacyStatement />
            </div>
            <div class="text-slate-500">
                &copy; MK Themed Attractions Philippines Inc. All Rights
                Reserved.
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

import Disclaimer from "./Disclaimer.vue";
import PrivacyStatement from "./PrivacyStatement.vue";

const locations = computed(() => {
    return [
        {
            title: "Philippines",
            value: "Lot 19, 21, 23 Livelihood St Pampanga Economic Zone, Angeles City, Pampanga 2009, Philippines",
        },
        {
            title: "Denmark",
            value: "Fluebæksvej 190 4100 Ringsted Denmark",
        },
    ];
});

const socials = computed(() => {
    return [
        {
            icon: "ri-facebook-line",
            title: "Facebook",
            link: "https://facebook.com",
        },
        {
            icon: "ri-twitter-line",
            title: "Twitter",
            link: "https://twitter.com",
        },
        {
            icon: "ri-instagram-line",
            title: "Instagram",
            link: "https://instagram.com",
        },
    ];
});
</script>

<style lang="scss" scoped></style>
