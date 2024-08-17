<template>
    <section id="become-a-partner">
        <v-heading class="text-center">Become a Partner</v-heading>
        <div class="grid gap-10 md:grid-cols-2">
            <div>
                <v-heading type="h2">Reach us</v-heading>
                <p>
                    We'd love to hear from you! Whether you have questions, need
                    support, or want to share your feedback, feel free to reach
                    out to us. Our team is dedicated to providing you with the
                    best assistance possible.
                </p>

                <v-text-icon :items="infoList" class="my-5 grid" />

                <MKMap
                    v-once
                    class="mx-auto h-[20rem] overflow-hidden rounded-lg"
                ></MKMap>
            </div>

            <div class="space-y-3">
                <v-text-field
                    prepend-inner-icon="co-mail-ru"
                    label="Email"
                    v-model="email"
                    required
                    type="email"
                ></v-text-field>
                <v-text-field
                    prepend-inner-icon="ri-building-2-line"
                    label="Company"
                    v-model="company"
                ></v-text-field>

                <v-select
                    label="Region"
                    :items="regions"
                    item-title="region"
                    item-value="abr"
                    prepend-inner-icon="pr-globe"
                    v-model="region"
                ></v-select>
                <v-textarea
                    prepend-inner-icon="fa-regular-comment-alt"
                    label="Comment"
                    rows="7"
                >
                </v-textarea>

                <v-button
                    prepend-inner-icon="pr-send"
                    class="ml-auto bg-accent text-white"
                >
                    Send
                </v-button>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, ref } from "vue";

import MKMap from "@/components/MKMap.vue";

const email = ref("");
const region = ref("as");
const company = ref("");

const regions = computed(() => {
    return [
        { abr: "as", region: "Asia" },
        { abr: "af", region: "Africa" },
        { abr: "au", region: "Australia" },
        { abr: "eu", region: "Europe" },
        { abr: "na", region: "North America" },
        { abr: "sa", region: "South America" },
    ];
});

const infoList = computed(() => {
    return [
        {
            icon: "la-heart",
            title: "Contact (Philippines): ",
            value: "+63 917 564 9864",
        },
        {
            icon: "la-heart",
            title: "Contact (Denmark): ",
            value: "+45 41 10 64 74",
        },
        { icon: "io-mail-outline", title: "Email", value: "sales@mkta.com.ph" },
        {
            icon: "io-location-outline",
            title: "Address",
            value: "Lot 19, 21, 23 Livelihood St Pampanga Economic Zone, Angeles City, Pampanga 2009, Philippines",
        },
    ];
});
</script>

<style scoped></style>
