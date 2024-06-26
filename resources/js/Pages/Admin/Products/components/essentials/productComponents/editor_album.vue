<template>
    <div>
        <div>
            <ul>
                <li v-for="(data, index) in model" class="my-2">
                    <v-text-field v-model="model[index]">
                        <template #append-inner>
                            <v-button
                                class="mt-auto !rounded-full bg-red-500 !p-1 text-white"
                                @click="
                                    () => {
                                        model.splice(index, 1);
                                    }
                                "
                            >
                                <v-icon name="md-close-round"></v-icon>
                            </v-button>
                        </template>
                    </v-text-field>
                </li>
                <li class="my-2">
                    <v-text-field
                        v-model="newData"
                        @keydown.enter="
                            () => {
                                model.push(newData);
                                resetNewData();
                            }
                        "
                    >
                        <template #append-inner>
                            <v-button
                                class="mt-auto !rounded-full bg-green-500 !p-1 text-white"
                                @click="
                                    () => {
                                        model.push(newData);
                                        resetNewData();
                                    }
                                "
                            >
                                <v-icon name="bi-plus"></v-icon>
                            </v-button>
                        </template>
                    </v-text-field>
                </li>
            </ul>
        </div>
        <div class="mt-6" v-show="showPreview">
            Preview
            <viewer_album :title="title" v-model="model" />
        </div>
    </div>
</template>
<script setup>
import { defineModel, ref } from "vue";

import viewer_album from "./viewer_album.vue";

const model = defineModel({});
const props = defineProps({
    title: "",
    showPreview : false
});

const newData = ref("");
const resetNewData = () => {
    newData.value = "";
};
</script>
