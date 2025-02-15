<script setup>
import { inject, ref } from "vue";

const item = inject("item", null);
const form = inject("verifyForm");


</script>
<template>
    <div>
        <form class="space-y-4">
            <div class="grid md:grid-cols-3">
                <h3 class="col-span-full mb-1 text-gray-500">General</h3>
                <v-text-field
                    v-model="form['info'].product_id"
                    label="SKU/code"
                ></v-text-field>
                <v-text-field
                    v-model="form['info'].parent_code"
                    label="Parent code"
                ></v-text-field>
                <v-text-field
                    v-model="form['info'].title"
                    label="title"
                ></v-text-field>
                <div class="col-span-full">
                    <v-textarea
                        v-model="form['info'].description"
                        label="description"
                    ></v-textarea>
                </div>
            </div>
            <div class="grid md:grid-cols-3">
                <h3 class="col-span-full mb-1 text-gray-500">Weight</h3>

                <v-text-field
                    v-model="form['info'].volume"
                    type="number"
                    label="volume"
                >
                    <template #append-inner>
                        <span class="text-gray-500">m<sup>3</sup></span>
                    </template>
                </v-text-field>
                <v-text-field
                    v-model="form['info'].weight_net"
                    type="number"
                    label="Net"
                >
                    <template #append-inner>
                        <span class="text-gray-500">kg</span>
                    </template>
                </v-text-field>
                <v-text-field
                    v-model="form['info'].weight_gross"
                    type="number"
                    label="Gross"
                >
                    <template #append-inner>
                        <span class="text-gray-500">kg</span>
                    </template>
                </v-text-field>
            </div>
            <div class="grid md:grid-cols-3">
                <h3 class="col-span-full mb-1 text-gray-500">Dimension</h3>

                <v-text-field
                    v-model="form['info'].dimension_length"
                    type="number"
                    label="Length"
                >
                    <template #append-inner>
                        <span class="text-gray-500">cm</span>
                    </template>
                </v-text-field>
                <v-text-field
                    v-model="form['info'].dimension_width"
                    type="number"
                    label="Width"
                >
                    <template #append-inner>
                        <span class="text-gray-500">cm</span>
                    </template>
                </v-text-field>
                <v-text-field
                    v-model="form['info'].dimension_height"
                    type="number"
                    label="Height"
                >
                    <template #append-inner>
                        <span class="text-gray-500">cm</span>
                    </template>
                </v-text-field>
            </div>
        </form>
    </div>
</template>

<style lang="scss" scoped></style>
