<template>
    <div>
        <v-text-field
            v-show="showSearch"
            placeholder="search"
            append-inner-icon="la-search-solid"
            ref="textfield"
            @blur="showSearch = false"
            @keydown.enter="searchProducts"
        ></v-text-field>
        <v-button
            v-if="!showSearch"
            icon="la-search-solid"
            scale="1.3"
            @click="handleShowSearch"
        ></v-button>
    </div>
</template>

<script setup>
import { nextTick, ref } from "vue";
import { useRouter } from "vue-router";
import VTextField from "./VTextField.vue";

const showSearch = ref(false);
const textfield = ref(null);
const router = useRouter();

async function handleShowSearch() {
    showSearch.value = true;
    await nextTick();
    textfield.value.textfield.focus();
}

function searchProducts(el) {
    router.push({ name: "products", query: { q: el.target.value } });
}
</script>

<style lang="scss" scoped></style>
