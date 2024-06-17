<template>
    <v-card>
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-6">
                <v-text-field
                    label="Name"
                    v-model="form.name"
                    prepend-inner-icon="fa-user-alt"
                    clearable
                />
            </div>
            <div class="col-span-12 md:col-span-6">
                <v-text-field
                    type="email"
                    prepend-inner-icon="pr-globe"
                    v-model="form.email"
                    label="Email"
                    disabled
                />
            </div>
            <div class="col-span-12 md:col-span-6">
                <v-select
                    label="Status"
                    prepend-inner-icon="fa-user-cog"
                    v-model="form.is_active"
                    :items="[
                        { title: 'Active', value: true },
                        { title: 'Inactive', value: false },
                    ]"
                    itemTitle="title"
                    itemValue="value"
                />
            </div>
            <div class="col-span-12 md:col-span-6">
                <v-select
                    label="Role"
                    v-model="form.role_id"
                    :items="
                        roles.filter((el) => {
                            return el.id !== 2;
                        })
                    "
                    itemTitle="title"
                    itemValue="id"
                />
            </div>
            
            <div class="col-span-12">
                <v-button
                @click="userStore.updateUser(id)"
                    prepend-inner-icon="md-save-round"
                    class="ml-auto bg-accent text-white"
                    >Save</v-button
                >
            </div>
        </div>
    </v-card>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";



const emit = defineEmits(["update"]);
const props = defineProps({
    id: String,
});

import { useUserStore } from "@/stores/userStore";
const userStore = useUserStore();
const { user, form } = storeToRefs(userStore);
if (!user.length) {
    await userStore.getUser(props.id, {
        includeRoleData: true,
        includePermissions: true,
        includePermissionKeys: true,
        includeRolePermissions: true,
    });
}


import { useRoleStore } from "@/stores/roleStore";
const roleStore = useRoleStore();
const { roles } = storeToRefs(roleStore);
if (!roles.length) {
    await roleStore.getRoles();
}
</script>
