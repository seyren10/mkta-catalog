<template>
    <div>
        <table class="w-full">
            <thead>
                <tr>
                    <th v-for="(col, colIndex) in model.header">
                        <v-text-field
                            :label="'Header Column ' + (colIndex + 1)"
                            v-model="model.header[colIndex]"
                        >
                            <template #append-inner>
                                <v-button
                                    @click="removeColumn(colIndex)"
                                    class="mt-auto !rounded-full bg-red-500 !p-1 text-white"
                                >
                                    <v-icon
                                        scale="1.5"
                                        name="ri-delete-column"
                                    ></v-icon>
                                </v-button>
                            </template>
                        </v-text-field>
                    </th>
                    <th v-show="model.header.length < 5">
                        <v-button
                            @click="addColumn()"
                            class="ml-auto mt-auto !rounded-full bg-green-500 !p-1 text-white"
                        >
                            <v-icon
                                scale="1.5"
                                name="ri-insert-column-right"
                            ></v-icon>
                        </v-button>
                    </th>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </thead>
            <tbody v-if="model.header.length + model.footer.length != 0">
                <tr v-for="(row, rowIndex) in model.body">
                    <td v-for="(cell, cellIndex) in row" class="my-2">
                        <v-text-field
                            :label="
                                'Row ' +
                                (rowIndex + 1) +
                                ' Column ' +
                                (cellIndex + 1) +
                                ' Value'
                            "
                            v-model="model.body[rowIndex][cellIndex]"
                        >
                        </v-text-field>
                    </td>
                    <td>
                        <v-button
                            @click="removeRow(rowIndex)"
                            class="mt-auto !rounded-full bg-red-500 !p-1 text-white"
                        >
                            <v-icon
                                scale="1.5"
                                name="ri-delete-column"
                            ></v-icon>
                        </v-button>
                    </td>
                </tr>
                <tr v-show="model.header.length < 10">
                    <td
                        class="p-2"
                        :colspan="
                            model.header.length +
                            (model.header.length < 5 ? 1 : 0)
                        "
                    >
                        <v-button
                            @click="addRow()"
                            class="ml-auto mt-auto !rounded-full bg-green-500 !p-1 text-white"
                        >
                            <v-icon scale="1.5" name="ri-insert-row-bottom" />
                        </v-button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th v-for="(col, colIndex) in model.footer">
                        <v-text-field
                            :label="'Footer Column ' + (colIndex + 1)"
                            v-model="model.footer[colIndex]"
                        >
                            <template #append-inner>
                                <v-button
                                    @click="removeColumn(colIndex)"
                                    class="mt-auto !rounded-full bg-red-500 !p-1 text-white"
                                >
                                    <v-icon
                                        scale="1.5"
                                        name="ri-delete-column"
                                    ></v-icon>
                                </v-button>
                            </template>
                        </v-text-field>
                    </th>
                </tr>
            </tfoot>
        </table>
        <div class="mt-6" v-show="showPreview">
            Preview
            <viewer_table :title="title" v-model="model" />
        </div>
    </div>
</template>
<script setup>
import { defineModel, ref } from "vue";

import viewer_table from "./viewer_table.vue";

const model = defineModel({
    header: [],
    body: [],
    footer: [],
});
const props = defineProps({
    title: "",
    showPreview: false,
});

const addColumn = () => {
    model.value.header.push("");
    model.value.footer.push("");
    model.value.body.forEach((row) => {
        row.push("");
    });
};
const removeColumn = (index) => {
    model.value.header.splice(index, 1);
    model.value.footer.splice(index, 1);
    model.value.body.forEach((row) => {
        row.splice(index, 1);
    });
};
const addRow = () => {
    let obj = [];
    for (
        let index = 0;
        index <
        (model.value.header.length > model.value.footer.length
            ? model.value.header.length
            : model.value.footer.length);
        index++
    ) {
        obj.push("");
    }
    model.value.body.push(obj);
};
const removeRow = (index) => {
    model.value.body.splice(index, 1);
};
</script>
