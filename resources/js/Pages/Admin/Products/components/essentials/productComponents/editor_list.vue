<template>
    <div>
        <ul>
            <li v-for="(data, index) in model" class="grid grid-cols-12 gap-2">
                <div class="col-span-11 grid grid-cols-3">
                    <v-text-field v-model="data.icon" label="Icon" />
                    <v-text-field v-model="data.title" label="Title" />
                    <v-text-field
                        v-model="data.value"
                        label="Description"
                    />
                </div>
                <div class="grid place-items-center">
                    <v-button
                        class="!rounded-full bg-red-500 !p-1 text-white"
                        @click="
                            () => {
                                model.splice(index, 1);
                            }
                        "
                    >
                        <v-icon name="md-close-round"></v-icon>
                    </v-button>
                </div>
            </li>
            <li class="grid grid-cols-12 gap-2">
                <div class="col-span-11 grid grid-cols-3">
                    <v-text-field v-model="newData.icon" label="Icon" />
                    <v-text-field v-model="newData.title" label="Title" />
                    <v-text-field
                        v-model="newData.value"
                        label="Description"
                    />
                </div>
                <div class="grid place-items-center">
                    <v-button
                        @click="
                            () => {
                                model.push(newData);
                                resetNewData();
                            }
                        "
                        class="!rounded-full bg-green-500 !p-1 text-white"
                    >
                        <v-icon name="bi-plus"></v-icon>
                    </v-button>
                </div>
            </li>
        </ul>
        <div class="mt-6" v-show="showPreview">
            Preview
            <viewer_list :title="title" v-model="model" />
        </div>
    </div>
</template>
<script setup>
import { defineModel, ref } from "vue";

import viewer_list from "./viewer_list.vue";

const model = defineModel({});
const props = defineProps({
    title: "",
    showPreview: false,
});

const newData = ref({
    icon: "",
    title: "",
    value: "",
});
const resetNewData = () => {
    newData.value = {
        icon: "",
        title: "",
        value: "",
    };
};
</script>
