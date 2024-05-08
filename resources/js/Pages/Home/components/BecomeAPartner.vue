<template>
    <section id="become-a-partner">
        <v-heading class="text-center">Become a Partner</v-heading>
        <div class="grid gap-10 md:grid-cols-2">
            <div>
                <v-heading type="h2">Reach us</v-heading>
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    Omnis magnam quam sequi corrupti in, cupiditate sapiente
                    voluptas, at consectetur, ad commodi recusandae
                    necessitatibus aliquam facilis? Minima quam molestias labore
                    accusantium.
                </p>

                <v-text-icon :items="infoList" class="my-5 grid gap-3" />

                <div class="mx-auto h-[20rem] overflow-hidden rounded-md">
                    <LMap
                        :useGlobalLeaflet="false"
                        v-model:zoom="zoom"
                        :center="location"
                    >
                        <LTileLayer
                            url="https://tiles.stadiamaps.com/tiles/stamen_toner/{z}/{x}/{y}{r}.png"
                            :min-zoom="8"
                        ></LTileLayer>

                        <LMarker
                            :lat-lng="location"
                            ref="marker"
                            @ready="ready"
                        >
                            <LPopup class="font-sans text-accent">
                                MK Themed Attractions Phils.
                            </LPopup>
                        </LMarker>
                    </LMap>
                </div>
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
                >
                </v-textarea>

                <v-button
                    prepend-inner-icon="pr-send"
                    class="bg-red-500"
                    parent-class="bg-red-500"
                    >Send</v-button
                >
            </div>
        </div>
    </section>
</template>

<script setup>
import "leaflet/dist/leaflet.css";
import { computed, ref } from "vue";
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";

const email = ref("");
const region = ref("as");
const company = ref("");
const zoom = ref(18);
const marker = ref(null);
const location = ref([15.171049271462008, 120.61120805583381]);

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
        { icon: "la-heart", title: "Contact", value: "09563040025" },
        { icon: "io-mail-outline", title: "Email", value: "sales@mkta.com.ph" },
        {
            icon: "io-location-outline",
            title: "Address",
            value: "Lot 19, 21, 23 Livelihood St Pampanga Economic Zone, Angeles City, Pampanga 2009, Philippines",
        },
    ];
});

const ready = () => {
    setTimeout(() => {
        marker.value.leafletObject.openPopup();
    }, 200);
};
</script>

<style scoped></style>
