<template>
    <div class="max-w-[3rem]">
        <v-text-on-image
            :image="s3(productImage)"
            no-overlay
            class="aspect-square rounded-lg object-cover"
        />
    </div>
    <div class="grow">
        <div>{{ product.title }}</div>
        <span class="text-slate-400">{{ product.id }}</span>
        <!-- <div class="mt-2 flex w-fit gap-2 overflow-hidden rounded-lg border">
            <button class="bg-slate-200 px-2 py-1 text-primary">-</button>
            <input class="no-appearance max-w-10" type="number" />
            <button class="bg-slate-200 px-2 py-1 text-primary">+</button>
        </div> -->
    </div>
    <div class="self-center">
        <v-button
            icon="pr-trash"
            class="text-red-500"
            @click.stop="$emit('delete', wishlistId)"
            :loading="loading"
        ></v-button>
    </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { computed, inject } from "vue";

const props = defineProps({
    item: Object,
});
const emits = defineEmits(["delete"]);

const s3 = inject("s3");
const wishlistStore = inject("wishlistStore");
const { loading } = storeToRefs(wishlistStore);

const product = computed(() => {
    return props.item.product;
});

const productImage = computed(() => {
    return product.value.product_thumbnail?.file.filename;
});

const wishlistId = computed(() => {
    return props.item.id;
});
</script>

<style lang="css" scoped>
.no-appearance::-webkit-inner-spin-button,
.no-appearance::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
}
</style>
