<template>
    <AppMenu :loading="cmsLoading">
        <template #activator="{ props }">
            <button
                class="flex items-center gap-2 rounded-full bg-blue-500 bg-opacity-20 px-2 py-1 text-blue-500"
                v-bind="props"
            >
                <span>{{ editingTemplate.title }}</span>

                <v-icon
                    v-if="activeTemplate.id === editingTemplate.id"
                    name="oi-dot-fill"
                    class="text-green-500"
                ></v-icon>
            </button>
        </template>

        <template #default="{ props: close }">
            <div class="min-w-[15rem] max-w-[30rem] space-y-4 p-3 text-xs">
                <div class="flex items-center justify-between">
                    <v-button
                        icon="hi-plus-sm"
                        class="rounded-lg"
                        icon-size=".8"
                        @click="handleShowAdd"
                    >
                    </v-button>
                    <v-button
                        class="rounded-lg hover:bg-red-500"
                        @click="close"
                        icon="la-times-solid"
                        icon-size=".8"
                    ></v-button>
                </div>

                <div v-show="showAdd">
                    <v-text-field
                        placeholder="title"
                        ref="textfield"
                        @blur="handleHideAdd"
                        @keydown.enter="addTemplate"
                        v-model="templateText"
                    ></v-text-field>
                </div>

                <div>
                    <ul>
                        <li
                            v-for="template in templates"
                            :key="template.key"
                            class="flex cursor-pointer items-center justify-between rounded-lg p-2 hover:bg-slate-200"
                            :class="{
                                'bg-slate-200':
                                    template.id === editingTemplate.id,
                            }"
                            @click="setEditingTemplate(template, close)"
                        >
                            <span>{{ template.title }}</span>

                            <div>
                                <v-icon
                                    name="oi-dot-fill"
                                    class="text-green-500"
                                    v-if="activeTemplate.id === template.id"
                                ></v-icon>
                                <v-icon
                                    name="bi-check"
                                    v-if="template.id === editingTemplate.id"
                                ></v-icon>
                            </div>
                        </li>
                    </ul>
                </div>

                <div>
                    <v-button
                        class="border text-primary"
                        @click="setActiveTemplate"
                        >set as active template</v-button
                    >
                </div>
            </div>
        </template>
    </AppMenu>
</template>

<script setup>
import { nextTick, ref } from "vue";
import { useCMSStore } from "../../../../stores/CMSStore";
import { storeToRefs } from "pinia";
import { useCMSUIStore } from "../../../../stores/ui/CMSUIStore";

import AppMenu from "../../../../components/AppMenu.vue";

const showAdd = ref(false);
const textfield = ref(null);
const templateText = ref("");
const {
    templates,
    setEditingTemplate,
    setActiveTemplate,
    editingTemplate,
    activeTemplate,
    addTemplate,
    cmsLoading,
} = useTemplate();

function handleShowAdd() {
    showAdd.value = true;
    nextTick(() => {
        textfield.value.textfield.focus();
    });
}

function handleHideAdd() {
    showAdd.value = false;
}

function useTemplate() {
    const cmsStore = useCMSStore();
    const cmsUIStore = useCMSUIStore();
    const {
        templates,
        editingTemplate,
        activeTemplate,
        loading: cmsLoading,
    } = storeToRefs(cmsStore);

    async function setEditingTemplate(template, cb = () => {}) {
        editingTemplate.value = template;

        if (typeof template.data === "string") {
            template.data = JSON.parse(template.data);
        }

        cmsUIStore.getNodes(template.data);

        cb();
    }

    async function addTemplate() {
        const form = {
            title: templateText.value,
        };
        await cmsStore.addContent(form);
        await cmsStore.getContents();

        templateText.value = "";
    }

    async function setActiveTemplate() {
        await cmsStore.setActiveContent(editingTemplate.value.id);
    }

    return {
        templates,
        editingTemplate,
        activeTemplate,
        setEditingTemplate,
        setActiveTemplate,
        addTemplate,
        cmsLoading,
    };
}
</script>

<style lang="scss" scoped></style>
