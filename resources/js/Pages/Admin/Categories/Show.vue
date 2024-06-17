<template>
    <div class="mb-2">
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
    <v-card class="border-0">
        <template #header>
            <div class="flex">
                <v-button
                    :prepend-inner-icon="tab.icon"
                    @click="selectedTab = tab.key"
                    v-for="tab in [
                        {
                            icon: 'md-category',
                            title: 'Category Information',
                            key: 'CategoryInformation',
                        },
                        {
                            icon: 'md-accounttree-sharp',
                            title: 'Category Tree',
                            key: 'CategoryTree',
                        },
                    ]"
                    :class="
                        '  ' +
                        (selectedTab == tab.key ? 'bg-accent text-white' : '')
                    "
                >
                    {{ tab.title }}
                </v-button>
            </div>
        </template>
        <CategoryInformation v-show="selectedTab === 'CategoryInformation'" :id="id" />
        <CategoryTree v-show="selectedTab === 'CategoryTree'" :id="id" />
    </v-card>
</template>
<script setup>
import CategoryInformation from "./components/CategoryInformation.vue";
import CategoryTree from "./components/CategoryTree.vue";

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const props = defineProps({
    id: String,
});

const router = inject("router");

import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const { category, form, loading, errors } = storeToRefs(categoryStore);
if (!category.length) {
    await categoryStore.getCategory(props.id);
}
const selectedTab = ref("CategoryInformation");
</script>

<style lang="scss" scoped></style>
