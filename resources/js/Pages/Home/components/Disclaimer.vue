<template>
    <v-dialog v-model="dialog" max-width="500" title="Hello Sample">
        <template #activator>
            <div
                class="cursor-pointer hover:text-slate-200"
                @click="dialog = true"
            >
                Disclaimer
            </div>
        </template>

        <div>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum ut
            ea quia, sed sint magnam, reiciendis suscipit inventore asperiores
            cupiditate expedita, nam ullam minima a nulla dignissimos dolor
            accusantium praesentium?
        </div>
    </v-dialog>
</template>

<script setup>
import { ref } from "vue";

const dialog = ref(false);
</script>

<style lang="scss" scoped></style>
