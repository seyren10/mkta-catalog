<template>
    <div class="rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-4 text-gray-800">
            This section organizes products into specific Categories, helping
            customers navigate to find items that match their needs or
            interests.
        </h2>
        <div class="text-gray-700">
            
            <div class=" flex justify-end">
                <v-button
                    class=" border m-3"
                    prepend-inner-icon="md-save-round"
                    @click="
                        async () => {
                            let categories = [];
                            for( let key in collections){
                                categories = [...categories,...new Set(collections[key]) ]
                            }
                            let col_Categories = [...categories];
                            console.log(col_Categories)
                            await productStore.updateProductCategories(id, col_Categories);
                            await productStore.getProductItem(id);
                        }
                    "
                    >Update Product Categories</v-button
                >
                <v-button
                    class="my-2 ml-auto border"
                    prepend-inner-icon="md-refresh-sharp"
                    @click="
                        async () => {
                            await productStore.getProductItem(id);
                        }
                    "
                    >Refresh</v-button
                >
                
            </div>
            <template v-for="parent in categories">
                <checkboxCategory
                    @change="
                        (data) => {
                            if (
                                data.parentKey === 0 &&
                                data.method === 'remove'
                            ) {
                                collections[parent.id] = [];
                            }
                        }
                    "
                    v-model="collections[parent.id]"
                    :parent_Key="0"
                    :id="parent.id"
                    :label="parent.title"
                    :children="parent.sub_categories"
                />
            </template>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, ref, watch, inject } from "vue";
import { storeToRefs } from "pinia";

/*SECTION - Components */
import checkboxCategory from "./essentials/checkboxCategory.vue";
/*SECTION - End Components */

/*SECTION - Props */
const props = defineProps({
    id: String,
});
/*SECTION - End Props */
/*SECTION - Variables */
const collections = ref({});
/*SECTION - End Variables */

/*SECTION - Product Info */
import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_item } = storeToRefs(productStore);
if (!product_item.length) {
    await productStore.getProductItem(props.id, {includeProductCategoriesKey : true});
}
/*SECTION - End Product Info */
/*SECTION - Categories */
import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const { categories } = storeToRefs(categoryStore);
if (!categories.length) {
    await categoryStore.getCategories({ includeSubCategories: true });
    categories.value.forEach((element) => {
        let parent = element.id;
        collections.value[parent] = product_item.value.product_category_keys;
    });
}
/*SECTION - End Categories */

/*SECTION - Product Categories */

/*SECTION - End Product Categories */
</script>
