<template>
    <div class="my-2">
        <div class="border-b-2 text-xl font-semibold">{{ title }}</div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th v-for="col in model.header">{{ col }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(rowData,rowIndex) in model.body">
                        <td v-for="item in rowData" :key="item">
                            {{ item }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th v-for="col in model.footer">{{ col }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
const props = defineProps({
    title: "Default Title",
});

const model = defineModel({
    header: [],
    body: {},
    footer: [],
});

</script>
