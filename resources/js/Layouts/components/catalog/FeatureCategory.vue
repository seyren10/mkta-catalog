<template>
    <div class="hidden flex-wrap gap-2 text-[.7rem] text-slate-400 sm:flex">
        <div
            class="flex cursor-pointer items-center overflow-hidden rounded-lg border border-slate-500 duration-300 hover:border-slate-500"
            v-for="feature in categories"
            :key="feature.id"
        >
            <div
                @click="
                    $router.push({
                        name: 'categories',
                        params: { id: feature.id },
                    })
                "
                class="p-1 px-2 duration-300 hover:bg-slate-500 hover:text-white"
            >
                {{ feature.title }}
            </div>

            <div
                class="p-1 px-2 duration-300 hover:bg-slate-500 hover:text-white"
                @click="(e) => setTarget(e, feature)"
            >
                <v-icon name="md-keyboardarrowdown-round" scale=".7"></v-icon>
            </div>
        </div>
    </div>

    <v-menu v-model="target" @close="selectedFeature = null">
        <div class="bg-primary p-5 text-xs text-slate-300">
            <ul class="grid grid-cols-2 gap-3">
                <li
                    v-if="selectedFeature?.sub_categories.length"
                    v-for="sub in selectedFeature?.sub_categories"
                    class="group flex items-center hover:text-accent"
                >
                    <v-icon
                        name="md-keyboardarrowright-round"
                        class="w-0 duration-300 group-hover:w-5"
                    ></v-icon>
                    <a href="#">
                        {{ sub.title }}
                    </a>
                </li>
                <li v-else>No sub categories</li>
            </ul>
        </div>
    </v-menu>
</template>

<script setup>
import { computed, ref } from "vue";
import { useCategoryStore } from "../../../stores/categoryStore";

//stores
const categoryStore = useCategoryStore();

const categories = computed(() => {
    return categoryStore.categories.slice(0, 8);
});

//reactives
const target = ref(null);
const selectedFeature = ref(null);

//functions
const setTarget = (event, payload) => {
    selectedFeature.value = payload;

    if (target.value === event.currentTarget) {
        unsetTarget();
    } else target.value = event.currentTarget;
};

const unsetTarget = () => {
    target.value = null;
};
</script>

<style lang="scss" scoped></style>
