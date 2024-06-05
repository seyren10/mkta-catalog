<template>
    <div class="overflow-x-auto rounded-lg border">
        <table class="w-full">
            <thead v-if="!noHeader">
                <tr class="border-b">
                    <th
                        v-for="item in headers.length
                            ? headers
                            : Object.keys(items[0])"
                        :key="item"
                        :class="`text-start ${densityValues} `"
                        v-show="!item.hidden"
                    >
                        <div
                            :class="`${isSortable(item) ? 'group cursor-pointer hover:underline' : ''}`"
                            @click="
                                () => {
                                    if (isSortable(item))
                                        handleSort(item.key ?? item);
                                }
                            "
                        >
                            <span class="my-auto">{{
                                headers.length ? item.value : item
                            }}</span>

                            <v-icon
                                v-if="
                                    currentSortTypeIndex !== 2 &&
                                    isSortable(item) &&
                                    currentSortKey === (item.key ?? item)
                                "
                                :name="`${currentSortTypeIndex === 0 ? 'md-arrowdropup-round' : currentSortTypeIndex === 1 ? 'md-arrowdropdown-round' : ''}`"
                            ></v-icon>
                            <v-icon
                                v-else
                                name="md-arrowdropup-round"
                                class="invisible fill-slate-400 group-hover:visible"
                            ></v-icon>
                        </div>
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white">
                <tr
                    v-for="item in paginated"
                    :key="item.id ?? item"
                    :class="`${striped ? 'even:bg-slate-50' : ''} ${border ? 'border-b last:border-b-0 ' : ''}`"
                >
                    <td
                        v-for="data in Object.keys(item)"
                        :class="`${densityValues}`"
                        v-show="!headers.find((e) => e.key === data)?.hidden"
                    >
                        <slot
                            :name="`item.${data}`"
                            :item="{ value: item[data], raw: item }"
                        ></slot>

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
                        density="compact"
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
    noHeader: {
        type: Boolean,
        default: false,
    },
    striped: {
        type: Boolean,
        default: false,
    },
    border: {
        type: Boolean,
        default: false,
    },
});
const sortType = ["asc", "desc", "none"];

//reactives
const paginator = ref("10");
const page = ref(0);
const densityValues = useDensityValues(props.density);
const currentSortTypeIndex = ref(2); // base on filterType Index = none
const currentSortKey = ref(null);

//computed

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

const sortedItems = computed(() => {
    if (currentSortTypeIndex.value === 2) return transformedItems.value;

    return transformedItems.value.slice().sort((a, b) => {
        if (a[currentSortKey.value] < b[currentSortKey.value]) {
            return currentSortTypeIndex.value === 0 ? -1 : 1;
        }
        if (a[currentSortKey.value] > b[currentSortKey.value]) {
            return currentSortTypeIndex.value === 0 ? 1 : -1;
        }
    });
});
const searchedItems = computed(() => {
    //set page to 0 everytime this function is triggered to prevent unecessary behavior
    page.value = 0;

    //return the original items when search is null or emptyString
    if (props.search === null || String(props.search).trim() === "")
        return sortedItems.value;

    return sortedItems.value.filter((item) => {
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
const isSortable = (item) => {
    return typeof item.sortable === "undefined" || item.sortable;
};

const handleSort = (key) => {
    //if the current active filter key changes
    //reset the filter type index to none or 2
    if (currentSortKey.value !== key) {
        currentSortKey.value = key;
        currentSortTypeIndex.value = 2;
    }

    //prevent the filter type index from exeeding the filter type length
    if (currentSortTypeIndex.value < sortType.length - 1)
        currentSortTypeIndex.value++;
    else currentSortTypeIndex.value = 0;
};
</script>

<style lang="scss" scoped></style>
