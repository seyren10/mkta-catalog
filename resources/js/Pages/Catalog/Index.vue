<template>
    <div class="container my-8">
        <v-text-field v-model="search"> </v-text-field>
        <v-data-table
            :items="items"
            :search="search"
            class="my-3"
            striped
            density="comfortable"
         
        ></v-data-table>
    </div>
</template>

<script setup>
import { ref } from "vue";

const search = ref("");
const items = ref(null);

await fetch("https://jsonplaceholder.typicode.com/todos")
    .then((res) => res.json())
    .then((json) => items.value = json);
</script>

<style lang="scss" scoped></style>
