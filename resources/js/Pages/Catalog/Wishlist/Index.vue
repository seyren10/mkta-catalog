<script setup>
import { ref, inject, computed, watch, watchEffect } from "vue";
import { storeToRefs } from "pinia";

import WishlistItem from "./components/WishlistItem.vue";

//injects
const wishlistStore = inject("wishlistStore");
const addToast = inject("addToast");

const { wishlistCount, wishlists, loading, errors } =
    storeToRefs(wishlistStore);

const form = ref({
    products: [],
    message: "",
});

watchEffect(() => {
    form.value.products = wishlists.value.map((wl) => {
        return {
            id: wl.product.id,
            qty: wl.qty,
        };
    });
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

const totalQty = computed(() => {
    return wishlists.value.reduce((acc, cur) => {
        acc += parseInt(cur.qty);

        return acc;
    }, 0);
});

const totalVolume = computed(() => {
    return wishlists.value.reduce((acc, cur) => {
        acc += parseInt(cur.qty) * parseFloat(cur.product.volume);
        return acc;
    }, 0);
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

<template>
    <div class="container space-y-4">
        <h1 class="text-head">Wishlist</h1>
        <p class="text-xs text-gray-400">
            Contains all the products in your wishlist. Modify your wishlist,
            view the summary, and send a query to the sales team.
        </p>

        <div class="mt-4 grid gap-4 p-2 lg:grid-cols-[max-content,1fr]">
            <ul
                class="scrollbar grid max-h-[25rem] gap-3 overflow-y-auto rounded-md bg-white py-3"
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
                <li>
                    <v-button
                        v-if="wishlists.length"
                        class="ml-auto mr-4 bg-red-500 text-xs text-white"
                        @click="handleDeleteAllWishlist"
                        :loading="loading"
                        >clear all</v-button
                    >
                </li>
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
                        <v-icon name="la-heart" class="text-accent"></v-icon>
                        products.
                    </div>
                </div>
            </ul>

            <div class="rounded-md bg-white p-1">
                <div
                    class="flex h-full flex-col gap-4 rounded-md border border-dashed p-3"
                >
                    <h3 class="text-lg font-bold">Summary:</h3>

                    <div class="font-thin">
                        <table class="w-full" v-if="wishlists?.length">
                            <thead>
                                <tr class="rounded bg-slate-200">
                                    <th class="p-2 text-start">Code</th>
                                    <th class="p-2 text-start">Title</th>
                                    <th class="p-2 text-start">Qty</th>
                                    <th class="p-2 text-start">Volume</th>
                                    <th class="p-2 text-start">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in wishlists" :key="item.id">
                                    <td class="p-2">{{ item.product.id }}</td>
                                    <td class="p-2">
                                        {{ item.product.title }}
                                    </td>
                                    <td class="p-2">{{ item.qty }} x</td>
                                    <td class="p-2">
                                        {{ item.product.volume }}m<sup>3</sup>
                                    </td>
                                    <td class="p-2">
                                        {{
                                            (
                                                parseFloat(
                                                    item.product.volume,
                                                ) * parseInt(item.qty)
                                            ).toFixed(2)
                                        }}m<sup>3</sup>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="border-t">
                                    <th class="p-2 text-start">Grand Total:</th>
                                    <th></th>
                                    <th class="text-start">
                                        {{ totalQty }}pcs
                                    </th>
                                    <th></th>
                                    <th class="text-start">
                                        {{ totalVolume.toFixed(2) }}m<sup
                                            >3</sup
                                        >
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        <div
                            v-else
                            class="flex items-center justify-center gap-2"
                        >
                            <v-icon name="pr-info-circle"></v-icon>
                            Nothing to show here.
                        </div>
                    </div>

                    <div class="mt-auto rounded-md bg-slate-200 p-3 text-xs">
                        <p class="mb-1 font-medium">Disclaimer:</p>
                        <p>
                            Although you are free to submit your wishlist to our
                            sales team, we recommend following the
                            <em class="font-medium">80m<sup>3</sup></em>
                            standard crate for a start.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-5 rounded-lg bg-slate-100 p-5">
            <p>
                Please contact us via email, and we will respond at our earliest
                convenience. You may use the form provided below or send a
                direct email to
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
            class="mt-auto rounded-tl-lg rounded-tr-lg bg-[#04151f] p-3 text-[.8rem]"
        >
            <v-text-icon
                :items="infoList"
                class="flex flex-wrap text-slate-400"
                value-class="text-white"
                icon-size="1"
            />
        </section>
    </div>
</template>

<style lang="css" scoped>
.no-appearance::-webkit-inner-spin-button,
.no-appearance::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
}
</style>
