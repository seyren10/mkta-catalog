<template>
    <div>
        <LMap :useGlobalLeaflet="false" v-model:zoom="zoom" :center="location">
            <LTileLayer
                url="https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png"
                :min-zoom="8"
            ></LTileLayer>

            <LMarker :lat-lng="location" ref="marker" @ready="ready">
                <LPopup class="font-sans text-accent">
                    MK Themed Attractions Phils.
                </LPopup>
            </LMarker>
        </LMap>
    </div>
</template>

<script setup>
import "leaflet/dist/leaflet.css";
import { ref } from "vue";
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";

const zoom = ref(18);
const marker = ref(null);
const location = ref([15.171049271462008, 120.61120805583381]);

const ready = () => {
    setTimeout(() => {
        marker.value.leafletObject.openPopup();
    }, 200);
};
</script>

<style lang="scss" scoped></style>
