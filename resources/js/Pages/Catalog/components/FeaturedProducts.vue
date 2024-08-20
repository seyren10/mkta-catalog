<template>
    <v-card class="relative border-none">
        <template #header>
            <div
                class="sticky top-0 z-[10] rounded-lg bg-white py-5 text-primary"
                :class="
                    environment === 'catalog'
                        ? 'top-[7.5rem] sm:top-[16.5rem] md:top-[14rem] xl:top-[14rem] 2xl:top-[12.5rem]'
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
                    <router-link
                        to="#"
                        class="flex items-center gap-2 text-blue-400"
                    >
                        <span> See all </span>
                        <v-icon name="md-keyboardarrowright-round"></v-icon
                    ></router-link>
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
    </v-card>
</template>

<script setup>
import { computed } from "vue";
import { useCMSUIStore } from "@/stores/ui/CMSUIStore";
import { storeToRefs } from "pinia";

import Product from "../../../components/Product.vue";

const props = defineProps({
    items: Array,
    titleIcon: String,
    title: String,
    imageProps: Object,
    displayLimit: Number,
});
const { environment } = storeToRefs(useCMSUIStore());

const displayItems = computed(() => {
    if (props.displayLimit <= 0 || props.displayLimit > props.items.length) {
        return props.items;
    } else {
        return props.items.slice(0, props.displayLimit);
    }
});
</script>

<style lang="scss" scoped></style>
