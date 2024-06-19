<template>
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
                <v-button icon="la-heart" class="bg-accent text-white">
                </v-button>
                <v-tooltip activator="parent">Add to wishlist</v-tooltip>
            </div>

            <v-dialog v-model="contact" max-width="600" persistent>
                <template #header="props">
                    <div class="flex justify-between p-5">
                        <VIconWrapper prepend-icon="ri-customer-service-2-line"
                            ><h2 class="font-medium text-primary">
                                Contact Sales Support
                            </h2></VIconWrapper
                        >
                        <v-button
                            v-bind="props"
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

                <ContactSales class="p-5"></ContactSales>
            </v-dialog>
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
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Ipsam odit quaerat explicabo accusantium omnis quo tenetur
                    veritatis debitis odio fuga neque praesentium, amet a
                    voluptatem culpa totam laboriosam cum ex.
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
                            <span class="min-w-[5rem] capitalize text-slate-400"
                                >{{ key }}:</span
                            >
                            <span> {{ detail }}</span>
                        </li>
                    </ul>
                </div>
            </template>
            <template #content.download>
                <div class="mt-3 space-y-5">
                    <div class="rounded-lg bg-slate-100 p-3 text-[.8rem]">
                        <p class="text-slate-400">
                            <span class="flex items-center font-bold"
                                ><v-icon name="bi-exclamation"></v-icon>
                                Important Note:</span
                            >
                            By downloading the zip file containing images from
                            our website, you agree not to distribute these
                            images or claim them as your own. Unauthorized use,
                            reproduction, or distribution is prohibited and may
                            result in legal action. Thank you for respecting our
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
</template>

<script setup>
import { inject, computed, ref } from "vue";

import ContactSales from "@/components/ContactSales.vue";
import BreadCrumb from "@/components/BreadCrumb.vue";
import VIconWrapper from "@/components/base_components/VIconWrapper.vue";

//reactives
const product = inject("product");
const category = inject("category");
const contact = ref(false);

//derived
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
</script>

<style lang="scss" scoped></style>
