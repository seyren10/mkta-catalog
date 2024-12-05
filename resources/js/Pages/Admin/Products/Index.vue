<template>
    <div class="pt-2">
        <div>
            <v-heading type="h2">
                <v-icon
                    v-if="$route.meta.redirectTo"
                    @click="
                        () => {
                            router.push({ name: $route.meta.redirectTo });
                        }
                    "
                    name="la-arrow-circle-left-solid"
                    scale="1.8"
                ></v-icon
                >{{ $route.meta.title }}</v-heading
            >
            <p>
                {{ $route.meta.description }}
            </p>
        </div>
        <div class="">
            <v-button
                outlined
                prepend-inner-icon="bi-cart4"
                class="ml-auto rounded-lg bg-accent p-2 text-white"
                @click="(showInsert = true), productStore.resetForm()"
                >New Product Item</v-button
            >
        </div>
        <div class="my-2">
            <v-text-field
                @keyup.enter="refresh(true)"
                prepend-inner-icon="la-search-solid"
                v-model="search"
            />
        </div>
        <div class="grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
            <div v-for="item in product_items" class="rounded-lg border" :key="item.id">
                <v-text-on-image
                    :noOverlay="true"
                    :class="`aspect-square cursor-pointer rounded-none`"
                    :image="s3Thumbnail(item.product_thumbnail?.file?.filename)"
                >
                </v-text-on-image>
                <div class="p-2">
                    <div class="line-clamp-2">
                        <slot
                            name="content.icon"
                            :item="{ ...item, class: 'float-left mr-2' }"
                        >
                        </slot>
                        <h3
                            class="text-[.8rem] font-bold [text-overflow:ellipsis]"
                        >
                            {{ item.title }}
                        </h3>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="mt-1 text-[.8rem] text-gray-400">
                            {{ item.id }}
                        </p>
                    </div>
                    <v-button
                        class="w-full bg-accent text-white"
                        @click="
                            () => {
                                router.push({
                                    name: 'productItemShow',
                                    params: { id: item.id },
                                });
                            }
                        "
                        prepend-inner-icon="fa-folder-open"
                        >View Product Item</v-button
                    >
                </div>
            </div>
            
        </div>
        
        <pagination  @page-change="handlePageChange" :items="paginationLinks" />
        <v-dialog
            v-model="showInsert"
            persistent
            title="Product Item"
            @close="
                () => {
                    productStore.resetForm();
                    showInsert = false;
                }
            "
        >
            <div class="min-w-[800px] p-5">
                <productItemForm />
                <div>
                    <v-button
                        v-show="isValid"
                        @click="
                            async () => {
                                await productStore.addProductItem();
                                productStore.resetForm();
                                productStore.getProductItems();
                                showInsert = false;
                            }
                        "
                        prepend-inner-icon="md-save-round"
                        class="ml-auto bg-accent text-white"
                        >Save Product Item</v-button
                    >
                </div>
            </div>
        </v-dialog>
    </div>
</template>

<script setup>
import pagination from "@/components/PaginationLinks.vue"
import productItemForm from "./components/productItemForm.vue";

const router = inject("router");
const s3Thumbnail = inject("s3Thumbnail");
import { useQuery } from "../../../composables/useQuery";



import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";
import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_items, isValid, paginationLinks } = storeToRefs(productStore);
const showInsert = ref(false);
const [page, setPage] = useQuery("page", () => refresh());
const [searchQuery, setSearchQuery] = useQuery("search", () => refresh());
const search = ref(searchQuery.value);
const refresh = async(resetPage = false)=>{
    if (resetPage) {
        router.push({
            name: "productItemIndex",
            query: {  
                search: search.value,
            },
        });
        return;
    }

    setSearchQuery(search.value)
    await productStore.getProductItems({ q: searchQuery.value, page: page.value,});
}
if (!product_items.length) {
    refresh();
}


const handlePageChange = (page) => {
    if (page.url === null) return;
    const pageNumber = page.url.match(/[?&]page=(\d+)/)?.at(1);
    
    setPage(+pageNumber);
};

</script>

<style lang="scss" scoped></style>
