<template>
    <div>
        <div>
            <v-textarea label="HTML Code" rows="10" v-model="model" />
            <p>Note: Inline CSS and Tailwind CSS is working, JavaScript is disabled</p>
        </div>
        <div class="mt-6" v-show="showPreview">
            Preview
            <viewer_html :title="title" v-model="model"/>
        </div>
    </div>
</template>
<script setup>
import { defineModel, ref } from "vue";

import viewer_html from "./viewer_html.vue";

const model = defineModel();
const props = defineProps({
    title: "",
    showPreview : false
});
</script>
