<template>
    <template v-if="product">
        <section class="container my-8 space-y-5">
            <v-sheet class="grid gap-5 overflow-y-hidden md:grid-cols-2">
                <div class="items flex gap-3">
                    <!-- 
                    veritical image gallery
                -->
                    <div
                        class="scrollbar hidden max-h-[30rem] max-w-[5rem] auto-rows-[min-content] gap-5 self-center overflow-y-auto p-2 lg:grid"
                    >
                        <img
                            v-for="(img, index) in productImages"
                            :key="img"
                            :src="img"
                            class="aspect-square rounded-lg object-cover"
                            :class="{
                                ' ring ring-accent ring-offset-4':
                                    currentImageIndex === index,
                            }"
                            @click="currentImageIndex = index"
                        />
                    </div>
                    <v-horizontal-scroller
                        :items="productImages"
                        item-size="100%"
                        no-indicator
                        v-model="currentImageIndex"
                        :key="id"
                    >
                        <template #default="{ item }">
                            <v-text-on-image
                                :image="item"
                                no-overlay
                                class="aspect-square cursor-zoom-in"
                                @click="lightbox = true"
                            ></v-text-on-image>
                        </template>
                    </v-horizontal-scroller>
                </div>
                <div class="mx-auto max-w-[60ch] space-y-10">
                    <BreadCrumb :items="breadCrumbData"></BreadCrumb>
                    <div class="mb-3">
                        <h1
                            class="text-head font-medium capitalize leading-tight text-primary"
                        >
                            {{ product.details.description }}
                        </h1>
                        <p class="font-light text-slate-500">
                            {{ product.details.dimension }}
                        </p>
                    </div>

                    <div class="flex items-center gap-5">
                        <div>
                            <v-button
                                icon="la-heart"
                                class="bg-accent text-white"
                            >
                            </v-button>
                            <v-tooltip activator="parent"
                                >Add to wishlist</v-tooltip
                            >
                        </div>
                        <v-button
                            prepend-inner-icon="ri-customer-service-2-line"
                            icon-size="1"
                            class="border border-accent text-accent"
                            >Contact for Price</v-button
                        >
                    </div>
                    <v-tab
                        header-class=" !px-0 bg-white border-b pb-2"
                        :tabs="[
                            { title: 'Overview', value: 'basic' },
                            { title: 'Technical Info', value: 'tech' },
                            { title: 'Download Image', value: 'download' },
                        ]"
                    >
                        <template #content.basic>
                            <div class="py-3">
                                Lorem, ipsum dolor sit amet consectetur
                                adipisicing elit. Ipsam odit quaerat explicabo
                                accusantium omnis quo tenetur veritatis debitis
                                odio fuga neque praesentium, amet a voluptatem
                                culpa totam laboriosam cum ex.
                            </div>
                        </template>
                        <template #content.tech>
                            <div class="p-3">
                                <ul class="grid gap-3">
                                    <li
                                        v-for="(detail, key) in product.details"
                                        :key="key"
                                        class="flex gap-3"
                                    >
                                        <span
                                            class="min-w-[5rem] capitalize text-slate-400"
                                            >{{ key }}:</span
                                        >
                                        <span> {{ detail }}</span>
                                    </li>
                                </ul>
                            </div>
                        </template>
                        <template #content.download>
                            <div class="mt-3 space-y-5">
                                <div
                                    class="rounded-lg bg-slate-100 p-3 text-[.8rem]"
                                >
                                    <p class="text-slate-400">
                                        <span
                                            class="flex items-center font-bold"
                                            ><v-icon
                                                name="bi-exclamation"
                                            ></v-icon>
                                            Important Note:</span
                                        >
                                        By downloading the zip file containing
                                        images from our website, you agree not
                                        to distribute these images or claim them
                                        as your own. Unauthorized use,
                                        reproduction, or distribution is
                                        prohibited and may result in legal
                                        action. Thank you for respecting our
                                        terms and supporting our work.
                                    </p>
                                </div>
                                <v-button
                                    prepend-inner-icon="oi-file-zip"
                                    class="bg-accent text-white"
                                    >Download ZIP file</v-button
                                >
                            </div>
                        </template>
                    </v-tab>
                </div>
            </v-sheet>
            <div class="flex gap-5">
                <div class="max-w-[15rem] text-slate-500">
                    <h3 class="p-3 text-[1rem] font-medium text-primary">
                        Recently Viewed
                    </h3>
                    <ul class="grid gap-2 divide-slate-300">
                        <li
                            v-for="dum in dummy"
                            class="flex cursor-pointer gap-3 rounded-lg p-2 hover:bg-slate-200"
                            @click="
                                $router.push({
                                    name: 'product',
                                    params: { id: dum.id },
                                })
                            "
                        >
                            <div class="aspect-square max-w-[5rem] p-1">
                                <v-text-on-image
                                    :image="dum.image"
                                    class="h-full"
                                    no-overlay
                                ></v-text-on-image>
                            </div>
                            <div>
                                <p class="line-clamp-2 h-min">
                                    {{ dum.details.description }}
                                </p>
                                <span class="text-[.7rem] text-slate-400">{{
                                    dum.details.dimension
                                }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <v-sheet class="grow"></v-sheet>
            </div>
        </section>
        <LightBox
            v-model="lightbox"
            :items="productImages"
            :key="id"
        ></LightBox>
    </template>
    <InpageNotFound v-else></InpageNotFound>
</template>

<script setup>
import { computed, inject, onUpdated, ref } from "vue";
import { useProductStore } from "../../../stores/productStore";

import InpageNotFound from "@/components/InpageNotFound.vue";
import BreadCrumb from "@/components/BreadCrumb.vue";
import LightBox from "@/components/LightBox/LightBox.vue";

const props = defineProps({
    id: String,
});

//stores
const productStore = useProductStore();
const { getProductWithId } = productStore;

//injects
const categoryStore = inject("categoryStore");

//reactives
const currentImageIndex = ref(0);
const lightbox = ref(false);

//computed
const product = computed(() => {
    return getProductWithId(props.id);
});

const category = categoryStore.getCategoryWithId(product.value?.category_id);

const breadCrumbData = computed(() => {
    return [
        { path: "/catalog", name: "catalog" },
        {
            path: `/catalog/categories/${product.value?.category_id}`,
            name: category.name,
        },
        {
            name: product.value?.details.dimension,
        },
    ];
});

const productImages = computed(() => {
    if (product.value?.album) {
        return [product.value?.image, ...product.value?.album];
    } else return [product.value?.image];
});

//to be deleted FOR TESTING ONJLY
const dummy = computed(() => {
    return productStore.products.slice(10, 20);
});

//hooks
onUpdated(() => {});
</script>

<style lang="scss" scoped></style>
