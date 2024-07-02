<template>
    <div>
        <div>
            <ul>
                <li>
                    <v-text-field label="Download Link" v-model="model.link"></v-text-field>
                </li>
                <li>
                    <v-textarea label="Description" v-model="model.text"></v-textarea>
                </li>
            </ul>
        </div>
        <div class="mt-6" v-show="showPreview">
            Preview
            <viewer_download :title="title" v-model="model" />
        </div>
    </div>
</template>
<script setup>
import { defineModel, ref } from "vue";

import viewer_download from "./viewer_download.vue";

const model = defineModel({
});
const props = defineProps({
    title: "",
    showPreview : false

});

</script>
