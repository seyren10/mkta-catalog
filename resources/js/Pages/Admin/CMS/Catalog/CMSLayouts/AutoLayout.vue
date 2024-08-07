<template>
    <div class="relative flex-1 space-y-3 rounded-lg border p-3">
        <CMSHeading>Auto-Layout</CMSHeading>

        <div class="flex basis-full justify-between">
            <CMSButton @select="handleAddNode"></CMSButton>
            <CMSButtonClose @click="handleDeleteNode(props)"></CMSButtonClose>
        </div>

        <component
            v-for="child in children"
            :key="child.component.props.id"
            :is="child.component.type"
            v-bind="child.component.props"
            :data="child.data"
        ></component>
    </div>
</template>

<script setup>
import { useCMSUIStore } from "../../../../../stores/ui/CMSUIStore";

import CMSButton from "../CMSButton/CMSButton.vue";
import CMSHeading from "../CMSHeading.vue";
import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";

const props = defineProps({
    id: String,
    parentId: String,
    children: Array,
});
const cmsStore = useCMSUIStore();

function handleAddNode(node) {
    cmsStore.addToNodes(node, props.id);
}

function handleDeleteNode(node) {
    cmsStore.deleteNode(node);
}
</script>

<style lang="scss" scoped></style>
