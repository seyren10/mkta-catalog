<template>
    <div
        class="relative col-span-full grid grid-cols-12 gap-4 rounded-lg border-2 border-slate-400 p-3"
    >
        <CMSHeading>Grid</CMSHeading>
        <div class="col-span-full flex justify-between">
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
import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";
import CMSHeading from "../CMSHeading.vue";

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
