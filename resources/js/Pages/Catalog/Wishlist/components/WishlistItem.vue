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
    </div>
    <div class="flex items-center gap-2 self-center">
        <div class="flex w-fit gap-2 overflow-hidden rounded-lg border">
            <button
                class="bg-slate-200 px-2 py-1 text-primary"
                @click="decreaseQty"
                :loading="loading"
            >
                -
            </button>
            <input
                class="no-appearance max-w-10"
                type="number"
                v-model="quantity"
                :disabled="loading"
                @blur="changeQuantity"
            />
            <button
                :loading="loading"
                class="bg-slate-200 px-2 py-1 text-primary"
                @click="increaseQty"
            >
                +
            </button>
        </div>
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
import { computed, inject, ref } from "vue";

const props = defineProps({
    item: Object,
});
const emits = defineEmits(["delete"]);

const s3 = inject("s3");
const wishlistStore = inject("wishlistStore");
const { loading } = storeToRefs(wishlistStore);
const quantity = ref(props.item.qty);

const product = computed(() => {
    return props.item.product;
});

const productImage = computed(() => {
    return product.value.product_thumbnail?.file.filename;
});

const wishlistId = computed(() => {
    return props.item.id;
});

async function increaseQty() {
    quantity.value += 1;
    await wishlistStore.updateWishlist(props.item.id, quantity.value);
    await wishlistStore.getWishlists();
}
async function decreaseQty() {
    if (quantity.value > 1) {
        quantity.value -= 1;
        await wishlistStore.updateWishlist(props.item.id, quantity.value);
        await wishlistStore.getWishlists();
    }
}

async function changeQuantity() {
    if (quantity.value < 1) {
        quantity.value = 1;
    } else {
        await wishlistStore.updateWishlist(props.item.id, quantity.value);
        await wishlistStore.getWishlists();
    }
}
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
