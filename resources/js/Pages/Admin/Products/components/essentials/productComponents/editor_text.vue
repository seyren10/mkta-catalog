<template>
    <div>
        <div>
            <ul>
                <li>
                    <v-textarea label="Description" v-model="model"></v-textarea>
                </li>
            </ul>
        </div>
        <div class="mt-6" v-show="showPreview">
            Preview
            <viewer_text :title="title" v-model="model" />
        </div>
    </div>
</template>
<script setup>
import { defineModel, ref } from "vue";

import viewer_text from "./viewer_text.vue";

const model = defineModel({
});
const props = defineProps({
    title: "",
    showPreview : false

});

</script>
