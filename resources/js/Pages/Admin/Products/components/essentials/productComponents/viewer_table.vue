<template>
    <div class="my-2">
        <div class="border-b-2 text-xl font-semibold">{{ title }}</div>
        <div>
            <table class="table w-full text-xl">
                <thead>
                    <tr class="bg-gray-300">
                        <th v-for="(col, colIndex) in model.columns">
                            {{ col }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, rowIndex) in model.rows" :class="rowIndex % 2 == 0 ? 'bg-white' : 'bg-gray-300'">
                        <td v-for="(cell) in row">
                            {{ cell }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
const props = defineProps({
    title: "Default Title",
});

const model = defineModel({ columns: [], rows: [] });

</script>
