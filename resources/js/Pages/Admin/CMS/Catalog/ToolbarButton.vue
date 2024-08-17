<template>
    <div class="flex items-center gap-4 text-xs">
        <div class="flex items-center gap-3">
            <span>Template:</span>
            <ToolbarButtonMenu></ToolbarButtonMenu>
        </div>

        <CMSButton @select="handleAddComponent" class="rounded-lg bg-accent">
            <template #button="buttonProps">
                <v-button
                    class="py-1 text-white"
                    v-bind="buttonProps"
                    prepend-inner-icon="bi-plus"
                    icon-size="1"
                    >add content</v-button
                >
            </template>
        </CMSButton>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useCMSUIStore } from "../../../../stores/ui/CMSUIStore";

import CMSButton from "./CMSButton/CMSButton.vue";
import ToolbarButtonMenu from "./ToolbarButtonMenu.vue";

const cmsStore = useCMSUIStore();
const templateMenu = ref(false);

function handleAddComponent(node) {
    cmsStore.addToNodes(node);
}
</script>

<style lang="scss" scoped></style>
