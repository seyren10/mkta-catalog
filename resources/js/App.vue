<template>
    <Maintenance v-if="currentUser?.role_data?.id === 2" />
    <RouterView v-slot="{ Component }">
        <template v-if="Component">
            <Suspense timeout="0">
                <component :is="Component" />
                <template v-slot:fallback>
                    <!-- <Spinner /> -->
                    <div class="absolute inset-0 grid place-content-center">
                        <VLoader scale="2"></VLoader>
                    </div>
                </template>
            </Suspense>
        </template>
    </RouterView>

    <VToaster v-bind="toaster"></VToaster>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { provide, ref } from "vue";
import { useUserStore } from "@/stores/userStore";
import { useCategoryStore } from "@/stores/categoryStore";
import { useWishlistStore } from "./stores/wishlistStore";
import { useFilterStore } from "@/stores/filterStore";
import { useProductStore } from "./stores/productStore";
import { useNotificationStore } from "./stores/notificationStore.js";

import { RouterView, useRouter } from "vue-router";
import { useToaster } from "./composables/useToaster";

import VLoader from "./components/base_components/VLoader.vue";
import VToaster from "./components/Toast/VToaster.vue";
import Maintenance from "./Maintenance.vue";

const userStore = useUserStore();
const { currentUser } = storeToRefs(userStore);
const router = useRouter();
const { toaster, addToast, deleteToast } = useToaster({ timeout: 3000 });

const categoryStore = useCategoryStore();
const productStore = useProductStore();
const wishlistStore = useWishlistStore();
const filterStore = useFilterStore();
const notificationStore = useNotificationStore();
const { notifications, isRefreshing } = storeToRefs(notificationStore);

provide("categoryStore", categoryStore);
provide("productStore", productStore);
provide("router", router);
provide("currentUser", currentUser);
provide("wishlistStore", wishlistStore);
provide("filterStore", filterStore);
provide("s3", (img) => {
    return `https://mkta-portal.s3.us-east-2.amazonaws.com/${img}`;
});
provide("s3Thumbnail", (img) => {
    return `https://mkta-portal.s3.us-east-2.amazonaws.com/thumbs/${img}`;
});
provide("copyText", (text) => {
    const el = document.createElement("textarea"); // Create a <textarea> element
    el.value = text; // Set its value to the text that needs to be copied
    el.setAttribute("readonly", ""); // Make it readonly to be tamper-proof
    el.style.position = "absolute";
    el.style.left = "-9999px"; // Move outside the screen to make it invisible
    document.body.appendChild(el); // Append the <textarea> element to the HTML document
    const selected =
        document.getSelection().rangeCount > 0
            ? document.getSelection().getRangeAt(0)
            : false; // Save the current selection
    el.select(); // Select the content of the <textarea> element
    document.execCommand("copy"); // Copy the selected text to the clipboard
    document.body.removeChild(el); // Remove the <textarea> element from the HTML document

    if (selected) {
        // Restore the original selection
        document.getSelection().removeAllRanges();
        document.getSelection().addRange(selected);
    }
});

provide("addToast", addToast);
provide("deleteToast", deleteToast);

const sec = ref(60);
setInterval(async () => {
    if (!router.currentRoute.value.fullPath.includes("admin")) {
        if (currentUser.value !== null && isRefreshing) {
            // await notificationStore.getNotifications(currentUser.value.id);
        }
    } else {
        // console.log('Skipped Notification Updates')
    }
}, 1000 * sec.value);
</script>
