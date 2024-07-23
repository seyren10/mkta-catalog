<template>
    <v-text-on-image

        :image="value"
        class="aspect-square cursor-zoom-in w-full"
        @click="PreviewImage = true"
        no-overlay
    >
    </v-text-on-image>
    <LightBox v-model="PreviewImage" :items="items" :key="value"></LightBox>
</template>
<script setup>
import LightBox from "@/components/LightBox/LightBox.vue";
import { inject, computed, ref } from "vue";

const PreviewImage = ref(false)

const props = defineProps({
    value: {
        default: "",
        type: String,
    },
});
const items = ref([]);
items.value.push(props.value)
</script>
