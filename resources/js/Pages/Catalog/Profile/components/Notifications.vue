<template>
    <div class="grid">
        <div class="flex justify-end">
            <v-button
                :loading="isRefreshing"
                @click="notificationStore.getNotifications(user.id)"
                class="border hover:bg-slate-600 hover:text-white"
                prepend-inner-icon="md-refresh-sharp"
                >Refresh</v-button
            >
        </div>
        <div class="w-full py-2">
            <div class="grid max-h-[60vh] grid-cols-1 gap-2 overflow-y-auto">
                <template v-if="notifications.length > 0">
                    <div v-for="notif in notifications" :key="notif.id">
                        <component :is="getComponent(notif.type)" :data="notif.data" :key="notif.id" />
                    </div>
                </template>
                <template v-else>
                    No Notifications
                </template>
            </div>
        </div>
    </div>
</template>
<script setup>
//!SECTION -> Required Init
import { inject, ref } from "vue";
import { storeToRefs } from "pinia";

//!SECTION -> Injects
const user = inject("currentUser");
const s3 = inject("s3");
//!SECTION - Stores
import { useNotificationStore } from "@/stores/notificationStore.js";
const notificationStore = useNotificationStore();
const { notifications, isRefreshing } = storeToRefs(notificationStore);
notificationStore.getNotifications(user.value.id);

//!SECTION -> Components
import ZipProductImages from "./notificationType/zip-product-images.vue";
const getComponent = (type)=>{
    switch (type) {
        case 'ZipProductImages_Download':
            return ZipProductImages;
            break;
    
        default:
            break;
    }
}

</script>
