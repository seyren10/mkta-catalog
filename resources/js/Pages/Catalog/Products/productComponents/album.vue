<template>
    <div :class="container_class()">
        <v-text-on-image
            v-for="(img, imgIndex) in items.slice(0, 3)"
            :image="img"
            class="aspect-square w-full cursor-zoom-in"
            @click="PreviewImage = true"
            no-overlay
        />
        <div class="grid content-center" v-if="items.length > 3">
            <v-button @click="PreviewImage = true">
                <v-icon class="self" name="fa-images" scale="6"></v-icon>
            </v-button>
        </div>
    </div>
    <LightBox v-model="PreviewImage" :items="items" :key="value" />
</template>
<script setup>
import LightBox from "@/components/LightBox/LightBox.vue";
import { inject, computed, ref } from "vue";

const PreviewImage = ref(false);

const props = defineProps({
    value: {
        default: "",
        type: String,
    },
});
const items = ref([]);
items.value = JSON.parse(props.value);
const container_class = () => {
    switch (items.value.length) {
        case 1:
            return "grid grid-cols-1";
            break;
        case 2:
            return "grid grid-cols-2";
            break;
        case 3:
            return "grid grid-cols-3";
            break;
        default:
            return "grid grid-cols-4";
            break;
    }
};
</script>
