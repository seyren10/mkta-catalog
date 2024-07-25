import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useNotificationStore = defineStore("notifications", () => {
    const { loading, errors, exec } = useAxios();

    const notifications = ref([]);
    const isRefreshing = ref(false)

    const markAsRead = async(notification_id)=>{

    }
    const markAllAsRead = async () => {

    }
    const markAsUnread = async(notification_id)=>{

    }
    const markAllAsUnread = async () => {

    }
    const getNotifications = async (user_id) => {
        try {
            isRefreshing.value = true;
            const res = await exec("/api/notifications/" + user_id, "get");
            notifications.value = res.data.data;
        } catch (e) {
            console.log(e)
        } finally {
            isRefreshing.value = false;
        }
    };
    return {
        getNotifications,

        isRefreshing,
        notifications,
    };
});
