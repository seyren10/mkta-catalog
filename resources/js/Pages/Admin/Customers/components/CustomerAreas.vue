<template>
    <v-card>
        <div class="grid grid-cols-12 gap-2">
            <div
                class="col-span-12 grid min-h-[10rem] grid-cols-1 content-between rounded-lg border p-2 md:col-span-3 lg:col-span-2"
                v-for="area in areas"
            >
                <div>
                    <p class="text-xl">{{ area.title }}</p>
                    <span class="text-gray-400">{{ area.description }}</span>
                </div>
                <div class="text-white">
                    <v-button
                        class="mt-auto w-full bg-red-500"
                        v-if="
                            customer.user_areas
                                .map((obj) => obj['id'])
                                .includes(area.id)
                        "
                        @click="
                            () => {
                                emit('modify_area', 'remove', area.id);
                            }
                        "
                        >Remove</v-button
                    >
                    <v-button
                        class="mt-auto w-full bg-green-500"
                        @click="
                            () => {
                                emit('modify_area', 'append', area.id);
                            }
                        "
                        v-else
                        >Append</v-button
                    >
                </div>
            </div>
        </div>
    </v-card>
</template>
<script setup>
import { inject } from "vue";

const emit = defineEmits(["modify_area"]);

const areas = inject("areas");
const customer = inject("customer");
</script>
