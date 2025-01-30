<template>
    <div class="grid grid-cols-2 gap-2">
        <div
            v-for="item in customer.wishlist_products"
            class="flex rounded-md border p-2 justify-between"
        >
            <div class="flex gap-2">
                <div class="max-w-[3rem]">
                    <v-text-on-image
                        :image="s3(item.product.product_thumbnail.file.filename)"
                        no-overlay
                        class="aspect-square rounded-lg object-cover"
                    />
                </div>
                <div class="grow">
                    <div>{{ item.product.title }}</div>
                    <span class="text-slate-400">{{ item.product.id }}</span>
                </div>
            </div>
            <span class="text-xl">
                {{ item.qty }} pcs
            </span>
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const s3 = inject("s3");
const emit = defineEmits(["update"]);
const customer = inject("customer");

import Card from "../../Products/reusableComponents/Card.vue";
</script>
