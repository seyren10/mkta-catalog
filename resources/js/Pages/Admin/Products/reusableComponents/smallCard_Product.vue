<template>
    <slot name="prepend"></slot>
    <div class="aspect-square max-w-[3rem] p-1 mx-auto" v-if="product != null">
        <v-text-on-image
            class="h-full"
            :key="product.product_thumbnail?.file.filename"
            :image="s3(product.product_thumbnail?.file.filename)"
            no-overlay
        ></v-text-on-image>
    </div>
    <div>
        <p class="line-clamp-2 h-min">
            {{ product.title }}
        </p>
        <span class="text-[.7rem] text-slate-400">{{
            product.id
        }}</span>
    </div>
    <slot name="append"></slot>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
const s3 = inject("s3");
const props = defineProps({
    product: {
        type: Object,
        default: null,
    },
});
</script>
