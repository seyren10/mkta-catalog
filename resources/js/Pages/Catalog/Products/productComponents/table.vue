<template>
    <table class="table-auto w-full p-2 border">
        <thead>
            <tr>
                <th v-for="(cell, index) in data.header" class="border p-2 min-h-7">{{ cell }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(rowData, rowIndex) in data.body">
                <td v-for="(cell, colIndex) in rowData" class="border p-2 min-h-7">{{ cell }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th v-for="(cell, index) in data.footer" class="border p-2 min-h-7">{{ cell }}</th>
            </tr>
        </tfoot>
    </table>
</template>
<script setup>
import { inject, computed, ref } from "vue";

const props = defineProps({
    value: {
        default: "",
        type: String,
    },
});
const data = ref(JSON.parse(props.value));
</script>
