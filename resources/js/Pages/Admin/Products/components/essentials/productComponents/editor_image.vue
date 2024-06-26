<template>
    <div>
        <div>
            <ul>
                <li>
                    <v-textarea label="Image Link" v-model="model"></v-textarea>
                </li>
            </ul>
        </div>
        <div class="mt-6" v-show="showPreview">
            Preview
            <viewer_image :title="title" v-model="model" />
        </div>
    </div>
</template>
<script setup>
import { defineModel, ref } from "vue";

import viewer_image from "./viewer_image.vue";

const model = defineModel({
});
const props = defineProps({
    title: "",
    showPreview : false

});

</script>
