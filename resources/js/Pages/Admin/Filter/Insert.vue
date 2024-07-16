<template>
    <div class="grid gap-2">
        <div>
            <v-text-field
                :prepend-inner-icon="icon"
                label="Icon"
                v-model="icon"
                readonly
            >
                <template #append-inner>
                    <v-button @click="showIconDialog = true">
                        <v-icon name="hi-solid-dots-horizontal"></v-icon>
                    </v-button>
                </template>
            </v-text-field>
            <v-text-field label="Title" v-model="title" />
            <v-text-field label="Description" v-model="description" />
        </div>
        <div class="grid grid-cols-1 gap-y-2">
            <v-text-field
                @keyup.enter="appendChoices"
                class="col-span-5"
                label="Choice"
                v-model="newChoice"
                persistent-hint
                hint="Press Enter to add"
            />

            <div class="col-span-5" v-for="(item, index) in choices">
                <v-text-field
                    class="col-span-5"
                    label="Value"
                    v-model="choices[index]"
                >
                    <template #append-inner>
                        <v-button
                            class="col-span-1 !rounded-full bg-red-500 !p-1 text-white"
                            @click="removeChoices(index)"
                        >
                            <v-icon name="md-close-round"></v-icon>
                        </v-button>
                    </template>
                </v-text-field>
            </div>
        </div>
        <div class="flex justify-between">
            <v-button @click="cancelFilter" class="bg-red-400 text-white">
                <v-icon class="me-2" name="md-close-round"></v-icon> Cancel
            </v-button>
            <v-button @click="saveFilter" class="bg-green-400 text-white">
                <v-icon class="me-2" name="md-save-round"></v-icon> Save Filter
            </v-button>
        </div>
        <v-dialog
            v-model="showIconDialog"
            persistent
            title="Icon Selector"
            @close="closeIconDialog"
        >
            <IconViewer @submit="iconSelected" :showHeader="false" :isSelection="true" />
        </v-dialog>
    </div>
</template>
<script setup>
import { onBeforeMount, inject, ref, watch } from "vue";
import { storeToRefs } from "pinia";

const router = inject("router");
const emit = defineEmits(["submit", "cancel", "close"]);

import IconViewer from "./../Icons/Index.vue";

//!SECTION -> Stores
import { useFilterStore } from "@/stores/filterStore";
const filterStore = useFilterStore();

//!SECTION -> Filter Choices
const newChoice = ref("");
const choices = ref([]);
const appendChoices = () => {
    choices.value.push(newChoice.value);
    newChoice.value = "";
};
const removeChoices = (index) => {
    choices.value.splice(index, 1);
};

//!SECTION -> Filter
const icon = ref("hi-solid-filter");
const title = ref("");
const description = ref("");

const cancelFilter = () => {
    emit("close");
    emit("cancel");
};
const saveFilter = async () => {
    filterStore.addFilter({
        icon : icon.value,
        title: title.value,
        description: description.value,
        choices: choices.value,
    });
    emit("submit");
    emit("close");
};

//!SECTION - Icon Dialog
const showIconDialog = ref(false);
const closeIconDialog = () => {
    showIconDialog.value = false;
};
const iconSelected = (selected_icon) => {
    icon.value = selected_icon;
    closeIconDialog();
};

</script>
