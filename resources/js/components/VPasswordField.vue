<template>
    <v-text-field
        :type="showPassword ? 'text' : 'password'"
        v-model="model"
        label="Password"
        prepend-inner-icon="ri-key-2-line"
    >
        <template #append-inner>
            <v-button
                v-if="!showPassword"
                type="button"
                icon="pr-eye-slash"
                @click="showPassword = true"
                tabindex="-1"
            ></v-button>
            <v-button
                @click="showPassword = false"
                v-else
                type="button"
                icon="pr-eye"
                tabindex="-1"
            ></v-button>
        </template>
    </v-text-field>
</template>

<script setup>
import { ref } from "vue";

const model = defineModel();
const showPassword = ref(false);
</script>

<style lang="scss" scoped></style>
