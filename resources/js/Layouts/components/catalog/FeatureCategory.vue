<template>
    <div class="hidden flex-wrap sm:flex">
        <a
            class="rounded-lg px-2 py-1 text-[.75rem] text-slate-400 duration-300 hover:bg-white hover:bg-opacity-10 hover:text-white"
            v-for="feature in categories"
            :key="feature.name"
            href="#"
            @mouseover="setTarget"
        >
            {{ feature.name }}</a
        >
    </div>

    <v-menu v-model="target">
        <div class="max-w-[30rem]">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Id corrupti
            rerum repellat fugiat maiores nam ducimus deserunt eaque, ea saepe
            autem ipsa, laborum doloribus, quo a. Sunt sapiente a nesciunt!
        </div>
    </v-menu>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useCategoryStore } from "../../../stores/categoryStore";

//stores
const categoryStore = useCategoryStore();
const categories = categoryStore.categories.slice(0, 10);

//reactives
const target = ref(null);

//functions
const setTarget = (event) => {
    target.value = event.currentTarget;
};
</script>

<style lang="scss" scoped></style>
