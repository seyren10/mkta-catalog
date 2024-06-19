<template>
    <v-chip-group :items="['tae', 'mamae', 'lol']"></v-chip-group>
    <v-chip-group
        :items="[
            {
                id: '1',
                value: 'roy',
                icon: 'la-heart',
            },
            {
                id: '2',
                value: 'ricky',
            },
            {
                id: '3',
                value: 'melvin',
            },
            {
                id: '4',
                value: 'prince',
            },
        ]"
    ></v-chip-group>
    <v-chip-input
        clearable
        v-model="tae"
        :items="[
            {
                id: '1',
                value: 'roy',
            },
            {
                id: '2',
                value: 'ricky',
            },
            {
                id: '3',
                value: 'melvin',
            },
            {
                id: '4',
                value: 'prince',
            },
        ]"
        @remove="(item) => console.log('remove', item)"
        @add="(item) => console.log('add', item)"
    ></v-chip-input>
</template>

<script setup>
import { ref } from "vue";

const tae = ref([
    {id: 1, value: 'roy'},
    {id: 42, value: 'bebeh'},
]);
</script>

<style lang="scss" scoped></style>
