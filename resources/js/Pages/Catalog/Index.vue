<template>
    <div class="container my-8 grid grid-cols-12 gap-4">
        <component
            v-for="node in nodes"
            :key="node.component.props.id"
            :is="node.component.type"
            v-bind="node.component.props"
            :data="node.data"
        />

        <v-dialog
            v-model="firstTimeLogin"
            max-width="500"
            persistent
            v-if="user.first_time_login"
        >
            <template #header="data">
                <div class="flex items-center justify-between p-4 pb-0">
                    <h3 class="font-medium">First time login</h3>
                    <v-button
                        icon="la-times-solid"
                        icon-size=".9"
                        v-bind="data"
                    ></v-button>
                </div>
            </template>
            <div class="p-4 text-sm">
                Hi {{ user.name }}, since this is your first time logging in, we
                recommend that you set your password immediately.
                <em class="text-xs text-slate-400">
                    ( or set it later by clicking on your profile )
                </em>
                <FirstTimeLoginForm class="mt-4 p-3"></FirstTimeLoginForm>
            </div>
        </v-dialog>
    </div>
</template>

<script setup>
import { inject, ref } from "vue";
import { storeToRefs } from "pinia";

import { useCMSStore } from "@/stores/CMSStore";
import { useCMSUIStore } from "@/stores/ui/CMSUIStore";

import FirstTimeLoginForm from "./FirstTimeLoginForm.vue";

const user = inject("currentUser");
const firstTimeLogin = ref(true);
const cmsSTore = useCMSStore();
const cmsUIStore = useCMSUIStore();
const { nodes } = storeToRefs(cmsUIStore);

const databaseNodes = await cmsSTore.getContent(13);
cmsUIStore.getNodes(databaseNodes, "catalog");
</script>

<style lang="scss" scoped></style>
