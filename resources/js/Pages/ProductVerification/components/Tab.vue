<script setup>
import { computed, ref } from "vue";
import Button from "./Button.vue";
import { useRoute, useRouter } from "vue-router";

const props = defineProps({
    items: Array,
});
const router = useRouter();
const route = useRoute();

const selectedItem = ref(null);

function handleItemSelected(item) {
    if (item.to) {
        selectedItem.value = item;
        router.push({ name: item.to, query: { ...route.query } });
    } else selectedItem.value = item;
}

function isSelected(item) {
    return item.name === selectedItem?.name || route.name === item.to;
}
</script>
<template>
    <ul class="flex flex-wrap gap-1.5 rounded-md bg-gray-200 p-1.5">
        <Button
            v-for="item in items"
            :key="item.name"
            :icon="item.icon"
            :selected="isSelected(item)"
            @click="handleItemSelected(item)"
            >{{ item.name }}</Button
        >
    </ul>
</template>

<style lang="scss" scoped></style>
