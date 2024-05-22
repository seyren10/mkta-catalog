<template>
    <div class="overflow-x-auto rounded-md border">
        <div class="">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th
                            v-for="item in Object.keys(paginated[0])"
                            :key="item"
                            :class="`text-start ${densityValues} `"
                        >
                            {{ item }}
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    <tr
                        v-for="item in paginated"
                        :key="item[Object.keys(item)[0]]"
                        class="even:bg-slate-50"
                    >
                        <td
                            v-for="data in Object.keys(item)"
                            :class="`${densityValues}`"
                        >
                            {{ item[data] }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="ml-auto w-fit">
                <div class="flex items-center gap-1 p-1">
                    <div class="flex items-center text-slate-500">
                        <span>Items per page:</span>
                        <v-select
                            :items="[
                                { title: '10', value: '10' },
                                { title: '25', value: '25' },
                                { title: '50', value: '50' },
                                { title: '75', value: '75' },
                                { title: 'All', value: 'all' },
                            ]"
                            item-title="title"
                            item-value="value"
                            v-model="itemsPerPage"
                        ></v-select>
                    </div>
                    <v-button
                        @click="firstPage"
                        icon="md-keyboarddoublearrowleft-round"
                        no-hover-effect
                    ></v-button>
                    <v-button
                        @click="prevPage"
                        icon="md-keyboardarrowleft-round"
                        no-hover-effect
                    ></v-button>
                    <v-button
                        @click="nextPage"
                        icon="md-keyboardarrowright-round"
                        no-hover-effect
                    ></v-button>
                    <v-button
                        @click="lastPage"
                        icon="md-keyboarddoublearrowright-round"
                        no-hover-effect
                    ></v-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useDensity, useDensityValues } from "@/composables/useInput";
import { computed, ref } from "vue";

const props = defineProps({
    ...useDensity(),
    items: {
        type: Array,
        default: [
            { id: 0, name: "Roy Victor", age: 25 },
            { id: 1, name: "John Ricky", age: 21 },
            { id: 2, name: "Mathew", age: 30 },
            { id: 3, name: "Melvin", age: 18 },
        ],
        headers: {
            type: Array,
        },
    },
});

//reactives
const itemsPerPage = ref("10");
const page = ref(0);
const densityValues = useDensityValues(props.density);

//methods
const paginated = computed(() => {
    const startIndex = page.value * Number(itemsPerPage.value);
    const endIndex = startIndex + Number(itemsPerPage.value);

    return props.items.slice(startIndex, endIndex);
});

const prevPage = () => {
    if (page.value > 0) {
        page.value--;
    }
};

const nextPage = () => {
    if ((page.value + 1) * Number(itemsPerPage.value) < props.items.length) {
        page.value++;
    }
};

const firstPage = () => {
    page.value = 0;
};

const lastPage = () => {
    page.value = Math.ceil(props.items.length / Number(itemsPerPage.value)) - 1;
};
</script>

<style lang="scss" scoped></style>
