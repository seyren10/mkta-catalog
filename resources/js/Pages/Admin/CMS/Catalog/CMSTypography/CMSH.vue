<template>
    <div class="relative col-span-full space-y-3 rounded-lg border p-3">
        <CMSHeading>Heading</CMSHeading>

        <div class="flex items-start gap-3">
            <v-select
                :items="headingTypeData"
                v-model="headingType"
                item-value="value"
            ></v-select>
            <v-text-field placeholder="Text" v-model="text"></v-text-field>
            <CMSButtonClose
                class="ml-auto"
                @click="handleDeleteNode"
            ></CMSButtonClose>
        </div>

        <div class="flex flex-wrap gap-3">
            <div class="flex overflow-hidden rounded-lg border">
                <v-button
                    v-for="justify in justifyData"
                    :key="justify.icon"
                    :icon="justify.icon"
                    class="rounded-none"
                    :class="{
                        'bg-slate-400 text-white':
                            classList.justify === justify.class,
                    }"
                    @click="setJustify(justify)"
                ></v-button>
            </div>
        </div>

        <div class="flex justify-end">
            <CMSButtonSave @click="handleUpdateNode"></CMSButtonSave>
        </div>
    </div>
</template>

<script setup>
import { inject, ref } from "vue";
import { useCMSUIStore } from "../../../../../stores/ui/CMSUIStore";

import CMSHeading from "../CMSHeading.vue";
import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";
import CMSButtonSave from "../CMSButton/CMSButtonSave.vue";

const props = defineProps({
    id: String,
    parentId: String,
    data: Object,
});
const cmsUIStore = useCMSUIStore();
const addToast = inject("addToast");
const headingType = ref(props.data?.headingType ?? "h1");
const text = ref(props.data?.text ?? "");
const classList = ref(
    props.data?.classList ?? {
        justify: "text-left",
    },
);

const headingTypeData = [
    { id: 1, title: "H1", value: "h1" },
    { id: 2, title: "H2", value: "h2" },
    { id: 3, title: "H3", value: "h3" },
];
const justifyData = [
    { icon: "co-justify-left", class: "text-left" },
    { icon: "co-justify-center", class: "text-center" },
    { icon: "co-justify-right", class: "text-right" },
];

function setJustify(justify) {
    classList.value.justify = justify.class;
}

function handleDeleteNode() {
    cmsUIStore.deleteNode(props);
}

function handleUpdateNode() {
    cmsUIStore.updateNode({
        ...props,
        data: {
            headingType: headingType.value,
            text: text.value,
            classList: classList.value,
        },
    });

    addToast({
        props: {
            type: "success",
        },
        content: "Heading Saved.",
    });
}
</script>

<style lang="scss" scoped></style>
