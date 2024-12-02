<template>
    <v-card class="relative border-none">
        <template #header>
            <div
                class="sticky top-0 z-[10] rounded-lg bg-white py-5 text-primary"
                :class="
                    environment === 'catalog'
                        ? 'top-[7.5rem] sm:top-[14.5rem] md:top-[12.7rem] xl:top-[12.5rem] 2xl:top-[11rem]'
                        : ''
                "
            >
                <div class="item-center flex justify-between gap-2">
                    <div class="flex flex-1 items-center justify-center gap-2">
                        <v-icon
                            :name="titleIcon"
                            scale="1.5"
                            class="fill-accent"
                        ></v-icon>
                        <h3 class="text-lg font-light uppercase tracking-wider">
                            {{ title }}
                        </h3>
                    </div>
                    <button
                        @click="featuredDialog = true"
                        class="flex items-center gap-2 text-blue-400"
                    >
                        <span> View all </span>
                        <v-icon name="md-keyboardarrowright-round"></v-icon>
                    </button>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-6">
            <div
                v-for="item in displayItems"
                class="overflow-hidden rounded-lg border bg-primary text-white"
            >
                <Product :item="item" class="bg-slate-1000" no-overlay>
                    <template
                        v-for="(_, slotName) in $slots"
                        #[slotName]="{ item: props }"
                    >
                        <slot :name="slotName" :item="props" />
                    </template>
                </Product>
            </div>
        </div>

        <AppDialog
            v-model="featuredDialog"
            class="scrollbar max-h-[90%] overflow-hidden rounded-lg bg-white"
            max-width="1200"
            fixed-toolbar
        >
            <template #title>
                <div class="flex items-center gap-2">
                    <v-icon :name="titleIcon"></v-icon>
                    <h3 class="text-sm font-bold">{{ title }}</h3>
                </div>
            </template>
            <FeaturedProductsDialog :items="items"></FeaturedProductsDialog>
        </AppDialog>
    </v-card>
</template>

<script setup>
import { computed, ref } from "vue";
import { useCMSUIStore } from "@/stores/ui/CMSUIStore";
import { storeToRefs } from "pinia";

import Product from "../../../components/Product.vue";
import AppDialog from "@/components/Dialog/AppDialog.vue";
import FeaturedProductsDialog from "./FeaturedProductsDialog.vue";

const props = defineProps({
    items: Array,
    titleIcon: String,
    title: String,
    imageProps: Object,
    displayLimit: Number,
});
const { environment } = storeToRefs(useCMSUIStore());
const featuredDialog = ref(false);

const displayItems = computed(() => {
    if (props.displayLimit <= 0 || props.displayLimit > props.items.length) {
        return props.items;
    } else {
        return props.items.slice(0, props.displayLimit);
    }
});
</script>

<style lang="scss" scoped></style>
