<template>
    <div class="hidden flex-wrap sm:flex">
        <v-button
            class="rounded-lg px-1 py-1 text-[.70rem] text-slate-400 duration-300 hover:bg-white hover:bg-opacity-10 hover:text-white"
            append-inner-icon="md-keyboardarrowdown-round"
            iconSize=".8"
            v-for="feature in categories"
            :key="feature.id"
            :class="{
                'bg-white bg-opacity-10 text-white':
                    feature.id === selectedFeature?.id,
            }"
            @click="(e) => setTarget(e, feature)"
        >
            {{ feature.name }}</v-button
        >
    </div>

    <v-menu v-model="target" @close="selectedFeature = null">
        <div class="bg-primary p-5 text-xs text-slate-300">
            <ul class="grid grid-cols-2 gap-3">
                <li
                    v-for="sub in selectedFeature?.subCategories"
                    class="group flex items-center hover:text-accent"
                >
                    <v-icon
                        name="md-keyboardarrowright-round"
                        class="w-0 duration-300 group-hover:w-5"
                    ></v-icon>
                    <a href="#">
                        {{ sub }}
                    </a>
                </li>
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
        console.log(target.value);
        unsetTarget();
    } else target.value = event.currentTarget;
};

const unsetTarget = () => {
    target.value = null;
};
</script>

<style lang="scss" scoped></style>
