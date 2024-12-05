<template>
    <div class="mx-auto max-w-[60ch] space-y-10">
        <BreadCrumb :items="breadCrumbData" v-if="category"></BreadCrumb>

        <div
            v-else
            class="w-fit rounded-xl bg-red-200 px-2 py-1 text-xs text-red-500"
        >
            No Category for this Product
        </div>
        <div class="mb-3">
            <h1
                class="text-head font-medium capitalize leading-tight text-primary"
            >
                {{ product.title }}
            </h1>
            <p class="font-light text-slate-500">
                {{ product.id }}
            </p>
        </div>
        <div class="flex items-center gap-5">
            <div v-show="product.show_wishlist_button">
                <v-button
                    :loading="loading"
                    :icon="
                        isIncludedInWishlist() ? 'la-heart-solid' : 'la-heart'
                    "
                    :class="
                        isIncludedInWishlist() ? 'text-red-500' : 'text-accent'
                    "
                    @click.stop="
                        isIncludedInWishlist()
                            ? removeFromWishlist()
                            : addToWishlist()
                    "
                >
                </v-button>

                <v-tooltip activator="parent">{{
                    isIncludedInWishlist()
                        ? "Remove from Wishlist"
                        : "Add to wishlist"
                }}</v-tooltip>
            </div>
            <v-dialog v-model="contact" max-width="700" persistent>
                <template #header>
                    <div class="flex justify-between p-5">
                        <VIconWrapper prepend-icon="ri-customer-service-2-line"
                            ><h2 class="font-medium text-primary">
                                Contact Sales Support
                            </h2></VIconWrapper
                        >
                        <v-button
                            @click="contact = false"
                            icon="md-close-round"
                        ></v-button>
                    </div>
                </template>
                <template #activator="props">
                    <v-button
                        v-bind="props"
                        prepend-inner-icon="ri-customer-service-2-line"
                        icon-size="1"
                        class="border border-accent text-accent"
                        >Contact for Price</v-button
                    >
                </template>

                <ContactSales class="p-5" :item="product"></ContactSales>
            </v-dialog>
        </div>
        <div v-if="variants.length" class="">
            <h3 class="mb-3 text-slate-500">Variants:</h3>
            <ul class="flex flex-wrap gap-2">
                <li
                    v-for="variant in variants"
                    class="overflow-hidden rounded-lg border hover:border-accent"
                >
                    <router-link
                        :to="{ name: 'product', params: { id: variant.id } }"
                        class="flex items-center gap-3"
                    >
                        <v-text-on-image
                            :image="
                                s3Thumbnail(
                                    variant.product_images?.at(0)?.file
                                        .filename,
                                )
                            "
                            no-overlay
                            class="max-w-24"
                        ></v-text-on-image>
                    </router-link>
                    <v-tooltip activator="parent"
                        >{{ variant.title }}
                    </v-tooltip>
                </li>
            </ul>
        </div>
        <div class="py-3">
            {{ product.description }}
        </div>
        <Download />
    </div>
</template>

<script setup>
import { inject, computed, ref } from "vue";
import { useWishlistStore } from "../../../../stores/wishlistStore";
import { useProductStore } from "../../../../stores/productStore.js";

import { storeToRefs } from "pinia";

import ContactSales from "@/components/ContactSales.vue";
import BreadCrumb from "@/components/BreadCrumb.vue";
import VIconWrapper from "@/components/base_components/VIconWrapper.vue";

import TechInfo from "./ProductInfo/TechInfo.vue";
import Download from "./ProductInfo/Download.vue";

//reactives
const injectedProduct = inject("product");
const category = inject("category");
const categoryX = inject("category");

const s3Thumbnail = inject("s3Thumbnail");

const conversion = ref("metric");
const contact = ref(false);
const wishlistStore = useWishlistStore();
const productStore = useProductStore();

const { loading, wishlists } = storeToRefs(wishlistStore);
const IMPERIAL_lENGTH = 2.54;
const IMPERIAL_POUND = 2.205;
const addToast = inject("addToast");

const isIncludedInWishlist = () =>
    wishlistStore.isIncludedOnWishlist(product.value);

const addToWishlist = async () => {
    await wishlistStore.addToWishlist(product.value);
    await wishlistStore.getWishlists();

    addToast({
        props: {
            type: "success",
            closable: true,
        },
        content: `${product.value.title} added to wishlist`,
    });
};

const removeFromWishlist = async () => {
    /* find the corresponding wishlist base on product id
    since wishlist id is needed to delete */
    const wishlist = wishlists.value.find(
        (e) => e.product.id === product.value.id,
    );

    if (wishlist) await wishlistStore.deleteWishlist(wishlist.id);
    await wishlistStore.getWishlists();
    // toast.value = true;
    addToast({
        props: {
            type: "info",
        },
        content: `${product.value.title} removed from wishlist`,
    });
};

const breadCrumbData = computed(() => {
    console.clear();
    const category = product.value.product_categories?.map((el) => {
        el["text"] = el["title"]; // Rename 'title' to 'name'
        el["name"] = "categories";
        if (el.parent_id != 0) {
            el["params"] = { id: el.parent_id };
            el["query"] = { sub: el.id };
        } else {
            el["params"] = { id: el.id };
        }

        return el; // Return the modified object
    });

    let cat = category.reduce((acc, cur) => {
        const foundItem = acc.find((e) => {
            return e.title === cur.title;
        });
        if (foundItem == null) {
            acc.push(cur);
        }
        return acc;
    }, []);

    console.log("Category", cat);

    return [
        { name: "catalog", text: "Catalog" },
        ...cat,
        {
            name: product.value?.id,
        },
    ];
});
const product = computed(() => {
    return {
        ...injectedProduct.value,
        details: {
            code: injectedProduct.value.id,
            height: `${conversion.value === "metric" ? injectedProduct.value.dimension_height : (+injectedProduct.value.dimension_height / IMPERIAL_lENGTH).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "cm" : "inch"}</span>`,
            length: `${conversion.value === "metric" ? injectedProduct.value.dimension_length : (+injectedProduct.value.dimension_length / IMPERIAL_lENGTH).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "cm" : "inch"}</span>`,
            width: `${conversion.value === "metric" ? injectedProduct.value.dimension_width : (+injectedProduct.value.dimension_width / IMPERIAL_lENGTH).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "cm" : "inch"}</span>`,
            volume: `${injectedProduct.value.volume} <span class='text-slate-400'> m<sup>3</sup></span>`,
            "weight(gross)": `${conversion.value === "metric" ? injectedProduct.value.weight_gross : (+injectedProduct.value.weight_gross / IMPERIAL_POUND).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "kg" : "lbs"}</span>`,
            "weight(net)": `${conversion.value === "metric" ? injectedProduct.value.weight_net : (+injectedProduct.value.weight_net / IMPERIAL_POUND).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "kg" : "lbs"}</span>`,
        },
    };
});

const variants = computed(() => {
    return product.value.variants;
});

const showDownloadToast = ref(false);
</script>

<style lang="scss" scoped></style>
