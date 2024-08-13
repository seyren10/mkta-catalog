<template>
    <div class="mb-6 pt-2">
        <div class="overflow scrollbar mx-auto !max-w-[85vw] border">
            <ul>
                <li v-for="(parentCat, catIndex) in categories">
                    {{ parentCat.title }}
                </li>
            </ul>
        </div>
    </div>
   
</template>
<style scoped>
table td {
    border: 1px black !important;
}
.fixed-column {
    position: sticky;
    left: 0;
    background: #fff; /* Ensure it’s visible */
    z-index: 1; /* Ensure it stays above other content */
}
.scrollable-table {
    display: block;
    overflow-x: auto;
}
.table-wrapper {
    display: block;
    max-width: 100%;
    overflow-x: auto;
}
.overflow {
    overflow-x: scroll !important;
}
.autofit {
    width: auto;
    white-space: nowrap;
}
</style>
<script setup>
import smallCard from "../../Products/reusableComponents/smallCard_Product.vue";
import ProductList from "../../Products/reusableComponents/Index.vue";

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

/*SECTION - Categories */
const collections = ref({});


import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const { categories } = storeToRefs(categoryStore);
if (!categories.length) {
    await categoryStore.getCategories({ includeSubCategories: true, includeCoverHTML: false, });
}
/*SECTION - End Categories */

</script>
