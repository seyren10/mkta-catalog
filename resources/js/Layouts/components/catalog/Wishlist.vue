<template>
    <v-dialog v-model="wishlistDialog">
        <template #activator="props">
            <div class="cursor-pointer" v-bind="props">
                <v-badge v-if="wishlistCount">{{ wishlistCount }}</v-badge>
                <v-tooltip activator="parent">Wishlist</v-tooltip>
                <v-icon name="la-heart" scale="1.5" class="fill-accent">
                </v-icon>
            </div>
        </template>

        <template #header="props">
            <div class="flex items-center justify-between p-3">
                <h3 class="font-medium">Wishlist</h3>
                <v-button v-bind="props" icon="md-close-round"></v-button>
            </div>
        </template>

        <div class="grid gap-5 p-5 text-sm lg:grid-cols-3">
            <div>
                <h3 class="mb-3 text-lg font-bold">Summary:</h3>

                <ul
                    class="scrollbar grid max-h-[25rem] gap-3 overflow-y-auto py-3"
                >
                    <li
                        v-for="item in wishlists"
                        :key="item.id"
                        class="flex gap-3 border-b p-3"
                    >
                        <WishlistItem
                            :item="item"
                            @delete="handleDeleteWishlist"
                        ></WishlistItem>
                    </li>
                    <li></li>

                    <div
                        v-if="!wishlists.length"
                        class="text-center text-[1rem] tracking-wide text-slate-500"
                    >
                        <v-icon
                            name="pr-box"
                            scale="8"
                            class="fill-gray-300"
                        ></v-icon>
                        <div>
                            Your wishlist is empty. start adding by clicking on
                            <v-icon
                                name="la-heart"
                                class="text-accent"
                            ></v-icon>
                            products.
                        </div>
                    </div>
                </ul>

                <div class="mt-auto">
                    <v-button
                        v-if="wishlists.length"
                        class="bg-red-500 text-xs text-white"
                        @click="handleDeleteAllWishlist"
                        :loading="loading"
                        >clear all</v-button
                    >
                </div>
            </div>
            <div class="space-y-5 rounded-lg bg-slate-100 p-5">
                <p>
                    Please contact us via email, and we will respond at our
                    earliest convenience. You may use the form provided below or
                    send a direct email to
                    <a href="mailto:info@us-cg.dk" class="text-accent"
                        >sales@mkthemedattractions.com.ph</a
                    >
                </p>

                <v-textarea
                    label="Message"
                    prepend-inner-icon="fa-regular-comment-alt"
                    rows="5"
                    v-model="form.message"
                ></v-textarea>

                <v-button
                    class="bg-accent text-white"
                    prepend-inner-icon="pr-send"
                    icon-size="1"
                    @click="handleSendWishlist"
                    :loading="loading"
                    >Send</v-button
                >
            </div>
            <section
                class="grid grid-cols-[1fr,18rem] rounded-lg bg-[#04151f] p-3 text-[.8rem] lg:grid-cols-1"
            >
                <v-text-icon
                    :items="infoList"
                    class="grid place-content-start text-slate-400 *:items-start"
                    value-class="text-white"
                    icon-size="1"
                />

                <MKMap class="overflow-hidden rounded-lg lg:aspect-square">
                </MKMap>
            </section>
        </div>
    </v-dialog>
</template>

<script setup>
import { ref, inject, computed, watch, watchEffect } from "vue";
import { storeToRefs } from "pinia";

import WishlistItem from "./WishlistItem.vue";
import MKMap from "@/components/MKMap.vue";

const wishlistDialog = ref(false);

//injects
const wishlistStore = inject("wishlistStore");
const addToast = inject("addToast");

const { wishlistCount, wishlists, loading, errors } =
    storeToRefs(wishlistStore);

const form = ref({
    productCodes: [],
    message: "",
});

watchEffect(() => {
    form.value.productCodes = wishlists.value.reduce((acc, cur) => {
        acc.push(cur.product.id);
        return acc;
    }, []);
});

const infoList = computed(() => {
    return [
        { title: "Contact (Philippines)", value: "+63 917 564 9864" },
        { title: "Email", value: "sales@mkthemedattractions.com.ph" },
        {
            title: "Address",
            value: "Lot 19, 21, 23 Livelihood St Pampanga Economic Zone, Angeles City, Pampanga 2009, Philippines",
        },
    ];
});

const handleDeleteWishlist = async (item) => {
    await wishlistStore.deleteWishlist(item);
    await wishlistStore.getWishlists();
};

const handleDeleteAllWishlist = async () => {
    await wishlistStore.deleteAllWishlist();
    await wishlistStore.getWishlists();
};

const handleSendWishlist = async () => {
    await wishlistStore.sendWishlist(form.value);

    if (errors.value?.status === 400) {
        addToast({
            props: {
                type: "danger",
            },
            content: "Something went wrong. Please try again later",
        });
    } else {
        await wishlistStore.deleteAllWishlist();
        await wishlistStore.getWishlists();
        form.value.message = "";

        addToast({
            props: {
                type: "success",
            },
            content: `Your request has been successfully submitted. Our team will review it and contact you shortly.
                 Thank you for reaching out to us, and we appreciate your patience while we process your request.`,
            timeout: 5000,
        });
    }
};
</script>

<style lang="css"></style>
