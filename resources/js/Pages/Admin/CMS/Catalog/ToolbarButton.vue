<template>
    <div class="flex items-center gap-4 text-xs">
        <div>Template</div>
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
import { useCMSUIStore } from "../../../../stores/ui/CMSUIStore";

import CMSButton from "./CMSButton/CMSButton.vue";

const cmsStore = useCMSUIStore();
function handleAddComponent(node) {
    cmsStore.addToNodes(node);
}
</script>

<style lang="scss" scoped></style>
