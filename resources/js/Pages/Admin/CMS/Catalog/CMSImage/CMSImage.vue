<template>
    <div class="grow rounded-lg border p-3">
        <v-button
            class="bg-accent text-xs text-white"
            prepend-inner-icon="pr-file"
            @click="dialog = !dialog"
            >Select Image
        </v-button>
        <v-dialog v-model="dialog" persistent max-width="800">
            <template #header="props">
                <div class="flex items-center justify-between p-3">
                    <h3 class="text-sm font-medium">Select an Image file</h3>
                    <v-button
                        icon="md-close-round"
                        icon-size="1"
                        v-bind="props"
                    ></v-button>
                </div>
            </template>
            <CMSImageFileSelection></CMSImageFileSelection>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useCMSStore } from "../../../../../stores/ui/CMSStore";

import CMSImageFileSelection from "./CMSImageFileSelection.vue";

const props = defineProps({
    id: String,
    parentId: String,
    type: String,
});
const dialog = ref(false);
const CMSStore = useCMSStore();

function handleRemoveNode(node) {
    CMSStore.removeNode({ props: { id: props.id, parentId: props.parentId } });
}
</script>

<style lang="scss" scoped></style>
