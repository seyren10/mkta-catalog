<template>
    <div class="relative flex basis-full flex-wrap gap-3 rounded-lg border p-3">
        <CMSHeading>Layout</CMSHeading>
        <div class="flex basis-full justify-between">
            <CMSButton @select="handleAddNode"></CMSButton>
            <CMSButtonClose @click="handleDeleteNode(props)"></CMSButtonClose>
        </div>

        <component
            v-for="child in children"
            :key="child.component.props.id"
            :is="child.component.type"
            v-bind="child.component.props"
        ></component>
    </div>
</template>

<script setup>
import { useCMSStore } from "../../../../../stores/ui/CMSStore";

import CMSButton from "../CMSButton/CMSButton.vue";
import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";
import CMSHeading from "../CMSHeading.vue";

const props = defineProps({
    id: String,
    parentId: String,
    children: Array,
});
const cmsStore = useCMSStore();

function handleAddNode(node) {
    cmsStore.addToNodes(node, props.id);
}

function handleDeleteNode(node) {
    cmsStore.deleteNode(node);
}
</script>

<style lang="scss" scoped></style>
