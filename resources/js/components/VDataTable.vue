<template>
    <div class="overflow-x-auto rounded-md border">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th
                        v-for="item in headers.length
                            ? headers
                            : Object.keys(items[0])"
                        :key="item"
                        :class="`text-start ${densityValues} last-of-type:text-end`"
                        v-show="!item.hidden"
                    >
                        {{ headers.length ? item.value : item }}
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
                        :class="`${densityValues} last-of-type:text-end`"
                        v-show="!headers.find((e) => e.key === data)?.hidden"
                    >
                        <slot :name="`item.${data}`" :item="item[data]"></slot>

                        <span v-if="!$slots[`item.${data}`]">
                            {{ item[data] }}
                        </span>
                    </td>
                </tr>

                <tr v-if="!paginated.length">
                    <td
                        :colspan="Object.keys(items[0]).length"
                        class="w-fit p-3 text-center"
                    >
                        {{ noDataText }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="ml-auto w-fit">
            <div class="flex items-center gap-1 p-1">
                <div
                    class="flex items-center gap-2 text-[.8rem] text-slate-500"
                >
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
                        v-model="paginator"
                    ></v-select>
                    <span
                        >{{ page + 1 }} of
                        {{
                            Math.ceil(
                                searchedItems.length / Number(itemsPerPage),
                            )
                        }}</span
                    >
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
    },
    headers: {
        type: Array,
        default: [],
    },
    search: {
        type: String,
        default: "",
    },
    noDataText: {
        type: String,
        default: "No Data Available",
    },
});

//reactives
const paginator = ref("10");
const page = ref(0);
const densityValues = useDensityValues(props.density);

//computed

const transformedItems = computed(() => {
    //when theres no headerkeys , it means that there's no custom header
    if (!headerKeys.value.length) return props.items;

    //include only the keys for items the is included in props.headers
    return props.items.map((item) => {
        let itemCollection = {};
        headerKeys.value.forEach((key) => {
            itemCollection[key] = item[key];
            // if (key in item) {
            //     itemCollection[key] = item[key];
            // }
        });

        return itemCollection;
    });
});
const headerKeys = computed(() => {
    return props.headers.reduce((acc, cur) => {
        acc.push(cur.key);
        return acc;
    }, []);
});
const itemsPerPage = computed(() => {
    //set page to 0 everytime this function is triggered to prevent unecessary behavior
    page.value = 0;

    if (paginator.value === "all") return searchedItems.value.length;
    return Number(paginator.value);
});
const startIndex = computed(() => {
    return page.value * itemsPerPage.value;
});

const endIndex = computed(() => {
    return startIndex.value + itemsPerPage.value;
});

const searchedItems = computed(() => {
    //set page to 0 everytime this function is triggered to prevent unecessary behavior
    page.value = 0;

    //return the original items when search is null or emptyString
    if (props.search === null || String(props.search).trim() === "")
        return transformedItems.value;

    return transformedItems.value.filter((item) => {
        //itirate through all of the items' key values , when some of the values
        //matches the search prop, then return that item
        return Object.values(item).some((value) => {
            return String(value).toLowerCase().includes(props.search);
        });
    });
});

const paginated = computed(() => {
    return searchedItems.value.slice(startIndex.value, endIndex.value);
});

//watchers

//methods
const prevPage = () => {
    if (page.value > 0) {
        page.value--;
    }
};

const nextPage = () => {
    if ((page.value + 1) * itemsPerPage.value < searchedItems.value.length) {
        page.value++;
    }
};

const firstPage = () => {
    page.value = 0;
};

const lastPage = () => {
    page.value = Math.ceil(searchedItems.value.length / itemsPerPage.value) - 1;
};
</script>

<style lang="scss" scoped></style>
