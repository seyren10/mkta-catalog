<template>
    <div>
        <div>
            <table class="table-auto rounded-sm">
                <thead>
                    <tr>
                        <th v-for="(col, index) in model.columns">
                            <v-button
                                @click="removeColumn(index)"
                                class="mx-auto"
                            >
                                <v-icon
                                    scale="1.5"
                                    name="ri-delete-column"
                                ></v-icon>
                            </v-button>
                        </th>
                    </tr>
                    <tr class="bg-gray-300">
                        <th v-for="(col, index) in model.columns">
                            <v-text-field
                                label="Column Text"
                                v-model="model.columns[index]"
                            />
                        </th>
                        <td>
                            <v-button
                                v-if="model.columns.length < 5"
                                @click="addColumn"
                            >
                                <v-icon
                                    scale="1.5"
                                    name="ri-insert-column-right"
                                ></v-icon
                            ></v-button>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(rows, rowIndex) in model.rows"
                        :class="rowIndex % 2 == 0 ? 'bg-white' : 'bg-gray-300'"
                    >
                        <td v-for="(col, colIndex) in model.columns">
                            <div class="col-span-2 grid">
                                <v-text-field
                                    label="Cell Value"
                                    v-model="model.rows[rowIndex][colIndex]"
                                />
                            </div>
                        </td>
                        <td>
                            <v-button
                                @click="removeRow(rowIndex)"
                                class="my-auto"
                            >
                                <v-icon
                                    scale="1.5"
                                    name="ri-delete-row"
                                ></v-icon>
                            </v-button>
                        </td>
                    </tr>
                    <tr class="">
                        <td :colspan="model.columns.length + 2">
                            <v-button class="mx-auto"
                                v-if="
                                    model.rows.length < 5 &&
                                    model.columns.length > 0
                                "
                                @click="addRow"
                            >
                                <v-icon
                                    scale="1.5"
                                    name="ri-insert-row-bottom"
                                ></v-icon>
                            </v-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6" v-show="showPreview">
            Preview
            <viewer_table :title="title" v-model="model" />
        </div>
    </div>
</template>
<script setup>
import { defineModel, ref } from "vue";

import viewer_table from "./viewer_table.vue";

const model = defineModel({ columns: [], rows: [] });
const props = defineProps({
    title: "",
    showPreview : false

});

const addColumn = () => {
    model.value.columns.push("");
    model.value.rows.forEach((element) => {
        element.push("");
    });
};
const removeColumn = (index) => {
    model.value.columns.splice(index, 1);
    model.value.rows.forEach((element) => {
        element.splice(index, 1);
    });
    if (model.value.columns.length == 0) {
        model.value.rows = [];
    }
};
const addRow = () => {
    let rowValue = [];
    model.value.columns.forEach((element) => {
        rowValue.push("");
    });
    model.value.rows.push(rowValue);
};
const removeRow = (index) => {
    model.value.rows.splice(index, 1);
};
</script>
