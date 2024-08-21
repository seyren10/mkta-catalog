<template>
    <div
        class="relative grid gap-3 space-y-3 self-start rounded-lg border p-3 md:grid-cols-12"
        :style="{ gridColumn: `span ${size}/ span ${size}` }"
    >
        <CMSHeading>Grid Item</CMSHeading>

        <div class="col-span-full flex basis-full justify-between self-start">
            <CMSButton @select="handleAddNode"></CMSButton>
            <div>
                <label :for="selectId" class="mr-2 text-xs">grid size</label>
                <select
                    class="rounded-lg border p-1"
                    :id="selectId"
                    :value="size"
                    @change="handlePropsChange"
                >
                    <option v-for="(_, index) in Array(12)" :value="index + 1">
                        {{ index + 1 }}
                    </option>
                </select>
            </div>
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
    size: {
        type: Number,
        default: 1,
    },
});
const cmsStore = useCMSUIStore();
const selectId = Math.random().toString();

function handleAddNode(node) {
    cmsStore.addToNodes(node, props.id);
}

function handleDeleteNode(node) {
    cmsStore.deleteNode(node);
}

function handlePropsChange(event) {
    const newProps = {
        ...props,
        size: +event.target.value,
    };
    cmsStore.setComponentProps(newProps);
}
</script>

<style lang="scss" scoped></style>
