<template>
    <div
        class="mb-5 flex items-center justify-between rounded-lg bg-slate-100 p-2 text-xs text-slate-500"
    >
        <div class="w-[30rem]">
            <v-text-field placeholder="search" v-model="model">
                <template #append-inner>
                    <v-button
                        v-if="model.trim() !== ''"
                        @click="model = ''"
                        icon="md-close-round"
                        icon-size=".6"
                    ></v-button>
                </template>
            </v-text-field>
        </div>

        <div class="mr-auto flex items-center">
            <v-button
                icon="md-keyboardarrowleft-round"
                icon-size="1"
                @click="$emit('prev')"
            ></v-button>
            <v-button
                icon="md-keyboardarrowright-round"
                icon-size="1"
                @click="$emit('next')"
            ></v-button>

            <p class="text-slate-400">
                page {{ pageInfo.currentPage }} of {{ pageInfo.totalPages }}
            </p>
        </div>

        <div>
            <v-button
                icon="md-refresh-sharp"
                icon-size="1"
                @click="$emit('refresh')"
            ></v-button>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    pageInfo: Object,
});
const emits = defineEmits(["refresh", "next", "prev"]);
const model = defineModel({ default: "" });
</script>

<style lang="scss" scoped></style>
