<template>
    <div class="space-y-4">
        <div class="flex items-center gap-3">
            <v-button class="bg-slate-400 text-white" @click="iconDialog = true"
                >Add icon</v-button
            >
            <template v-if="selectedIcon">
                <v-icon :name="selectedIcon"></v-icon>
                <div class="text-slate-500">
                    {{ selectedIcon }}
                </div>
            </template>
        </div>

        <div class="flex items-center gap-3">
            <v-text-field hint="title" persistent-hint v-model="title">
            </v-text-field>
            <v-text-field
                v-if="!showAll"
                type="number"
                hint="display limit"
                persistent-hint
                v-model="limit"
                @input="handleLimit"
            ></v-text-field>
            <v-checkbox label="show all" v-model="showAll"></v-checkbox>
        </div>

        <v-dialog v-model="iconDialog" max-width="1000">
            <template #header="props">
                <div class="flex items-center justify-between p-3">
                    <h3 class="text-sm font-medium">Select an Icon</h3>
                    <v-button
                        icon="md-close-round"
                        icon-size="1"
                        v-bind="props"
                    ></v-button>
                </div>
            </template>
            <CMSIconList
                class="p-3 text-xs"
                v-model="selectedIcon"
                @close="iconDialog = false"
            ></CMSIconList>
        </v-dialog>
    </div>
</template>

<script setup>
import { inject, ref, watch } from "vue";

import CMSIconList from "../CMSIconList.vue";

const selectedProductsCount = inject("selectedProductsCount", 0);
const data = inject("data");
const iconDialog = ref(false);
const selectedIcon = ref(data.value?.selectedIcon ?? null);
const title = ref(data.value?.title ?? "");
const limit = ref(data.value?.limit ?? 0);
const showAll = ref(data.value?.showAll ?? false);

/* to expose values when used by ref */
defineExpose({
    selectedIcon,
    title,
    limit,
    showAll,
});

/* when show all is active and the user happens to update the selected products,
it will watch for changes and apply it to limit variable  */
watch(selectedProductsCount, (newvalue) => {
    if (showAll.value) {
        limit.value = selectedProductsCount.value;
    }
});

/* show all the products with no limit */
watch(showAll, (newValue) => {
    if (newValue) {
        limit.value = selectedProductsCount.value;
    }
});

function handleLimit(event) {
    const inputValue = event.target.value;

    if (inputValue > selectedProductsCount.value)
        limit.value = selectedProductsCount.value;

    if (inputValue < 0) {
        limit.value = 0;
    }
}
</script>

<style lang="scss" scoped></style>
