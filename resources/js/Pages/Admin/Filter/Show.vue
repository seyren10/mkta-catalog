<template>
    <div class="mb-2">
        <v-heading type="h2">
            <v-icon
                v-if="$route.meta.redirectTo"
                @click="
                    () => {
                        router.push({ name: $route.meta.redirectTo });
                    }
                "
                name="la-arrow-circle-left-solid"
                scale="1.8"
            ></v-icon
            >{{ $route.meta.title }}</v-heading
        >
        <p>
            {{ $route.meta.description }}
        </p>
    </div>
    <v-card class="border-0">
        <div class="ml-auto w-fit">
            <v-button
                outlined
                prepend-inner-icon="md-refresh-sharp"
                class="float-end block rounded-lg bg-accent p-2 text-white"
                @click="refresh()"
                >Refresh</v-button
            >
        </div>
        <div class="grid gap-2">
            <div>
                <v-text-field label="Title" v-model="filter.title" />
                <v-text-field
                    label="Description"
                    v-model="filter.description"
                />
            </div>
            <div>
                <v-text-field
                    @keyup.enter="appendChoices"
                    class="col-span-5"
                    label="Choice"
                    v-model="newChoice"
                    persistent-hint
                    hint="Press Enter to add"
                />
            </div>
            <div class="grid grid-cols-1 gap-y-2">
                <div>
                    <h2 class="w-full text-xl font-bold">{{ filter.choices.length }} Choice(s)</h2>
                </div>
                <div
                    class="col-span-5 my-2 border-b-2 border-l-2 py-2"
                    v-for="(item, index) in filter.choices"
                >
                    <v-text-field
                        class="col-span-5"
                        label="Value"
                        v-model="item.value"
                    >
                        <template #append-inner>
                            <v-button
                                class="col-span-1 !rounded-full bg-red-500 !p-1 text-white"
                                @click="removeChoices(index)"
                            >
                                <v-icon name="md-close-round"></v-icon>
                            </v-button>
                        </template>
                    </v-text-field>
                </div>
            </div>
            <div class="flex justify-end">
                <v-button @click="updateFilter" class="bg-green-400 text-white">
                    <v-icon class="me-2" name="md-save-round"></v-icon> Update
                    Filter
                </v-button>
            </div>
        </div>
    </v-card>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const router = inject("router");

const props = defineProps({
    id: String,
});

//!SECTION -> Store
import { useFilterStore } from "@/stores/filterStore";
const filterStore = useFilterStore();
const { filter } = storeToRefs(filterStore);
const refresh = async () => {
    await filterStore.getFilter(props.id);
};
if (!filter.length) {
    refresh();
}

//!SECTION -> Editing
const newChoice = ref("");
const appendChoices = () => {
    filter.value.choices.push(
        {
            id : -1,
            filter_id : props.id,
            value : newChoice.value
        }
    );
    newChoice.value = "";
};
const removeChoices = (index) => {
    filter.value.choices.splice(index, 1);
};

const updateFilter = async() =>{
    await filterStore.updateFilter(props.id, filter.value);
    refresh();
}
</script>

<style lang="scss" scoped></style>
