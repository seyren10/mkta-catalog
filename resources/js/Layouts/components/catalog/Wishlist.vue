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

        <div class="grid gap-5 p-5 text-sm md:grid-cols-2">
            <div>
                <h3 class="mb-3 text-lg font-bold">Summary:</h3>

                <ul
                    class="scrollbar grid max-h-[30rem] gap-3 overflow-y-auto py-3"
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
                        <img
                            src="/mk-images/rocket-removebg-preview.png"
                            alt=""
                        />
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

                <v-button
                    v-if="wishlists.length"
                    class="ml-auto bg-red-500 text-xs text-white"
                    @click="handleDeleteAllWishlist"
                    :loading="loading"
                    >clear all</v-button
                >
            </div>
            <form
                class="space-y-5 rounded-lg bg-slate-100 p-5"
                ref="formRef"
                @submit.prevent="submitEmail"
            >
                <p>
                    Please contact us via email, and we will respond at our
                    earliest convenience. You may use the form provided below or
                    send a direct email to
                    <a href="mailto:info@us-cg.dk" class="text-accent"
                        >sales@mkthemedattractions.com.ph</a
                    >
                </p>

                <v-text-field
                    label="email"
                    prepend-inner-icon="io-mail-outline"
                    v-model="emailJSForm.user_email"
                    hint="The above form will be used to send system-generated emails."
                    persistent-hint
                ></v-text-field>
                <v-text-field
                    label="Name"
                    prepend-inner-icon="co-user"
                    v-model="emailJSForm.user_name"
                ></v-text-field>
                <v-textarea
                    v-model="emailJSForm.message"
                    label="Message"
                    prepend-inner-icon="fa-regular-comment-alt"
                    rows="5"
                ></v-textarea>

                <v-button
                    type="submit"
                    class="bg-accent text-white"
                    prepend-inner-icon="pr-send"
                    icon-size="1"
                    :loading="emailJSLoading"
                    >Send</v-button
                >
            </form>
            <section
                class="primary-gradient rounded-lg p-3 text-[.8rem] md:col-span-2"
            >
                <v-text-icon
                    :items="infoList"
                    class="grid text-slate-400 *:items-start"
                    value-class="text-white"
                    icon-size="1"
                />
            </section>
        </div>

        <v-toast :type="toastMessage.type" v-model="showToast">
            {{ toastMessage.message }}
        </v-toast>
    </v-dialog>
</template>

<script setup>
import { ref, inject, computed } from "vue";
import { storeToRefs } from "pinia";
import { useEmailJSStore } from "../../../stores/emailJSStore";

import WishlistItem from "./WishlistItem.vue";

const wishlistDialog = ref(false);

const emailJSStore = useEmailJSStore();
const formRef = ref(null);
const {
    form: emailJSForm,
    submitEmail,
    loading: emailJSLoading,
    toastMessage,
} = useEmailJS(emailJSStore, showEmailResult);

const wishlistStore = inject("wishlistStore");
const { wishlistCount, wishlists, loading } = storeToRefs(wishlistStore);
const showToast = ref(false);

const infoList = computed(() => {
    return [
        { title: "Contact", value: "09563040025" },
        { title: "Email", value: "sales@mkta.com.ph" },
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

async function showEmailResult() {
    showToast.value = true;
    await wishlistStore.deleteAllWishlist();
    await wishlistStore.getWishlists();
    
    emailJSStore.resetForm();
    wishlistDialog.value = false;
}

/* INIT */

function useEmailJS(store, callback) {
    const user = inject("currentUser");
    const { form, loading, errors } = storeToRefs(store);

    form.value.user_name = user.value.name;
    form.value.user_email = user.value.email;
    form.value.order_id = Math.floor(Math.random() * 10000);

    const wishlistForm = computed(() => {
        return wishlists.value.map((wishlist) => {
            return {
                title: wishlist.product.title,
                id: wishlist.product.id,
            };
        });
    });

    form.value.wishlists = wishlistForm;

    const toastMessage = computed(() => {
        if (!errors.value) {
            return { type: "success", message: "Email sent." };
        } else {
            return {
                type: "danger",
                message: "Something went wrong. please try again later",
            };
        }
    });

    const submitEmail = async () => {
        await store.sendEmail();
        callback();
    };

    return { form, submitEmail, loading, errors, toastMessage };
}
</script>

<style lang="css"></style>
