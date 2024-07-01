<template>
    <div class="my-2">
        <div class="border-b-2 text-xl font-semibold">{{ title }}</div>
        <div>
            <ul>
                <template v-for="data in model">
                    <li class="col-span-4 grid">
                        <div class="col-span-1">
                            <template v-if="Object.keys(data).includes('icon')">
                                <v-icon v-if="data.icon != ''" :name="data.icon"></v-icon>
                            </template>
                        </div>
                        <div class="col-span-3">
                            <div class="flex-column flex">
                                {{ data.title }}
                                {{ data.value }}
                            </div>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
const props = defineProps({
    title: "Default Title",
});

const model = defineModel();
</script>
