<template>
    <div class="col-span-full" :class="`${getDataClassList()}`">
        <p v-html="formattedText"></p>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    data: Object,
});

const formattedText = computed(() => {
    return props.data.text?.replace(/\n/g, "<br>");
});
function getDataClassList() {
    return Object.keys(props.data?.classList ?? {})
        .reduce((acc, cur) => {
            acc.push(props.data.classList[cur]);
            return acc;
        }, [])
        ?.join();
}
</script>

<style lang="scss" scoped></style>
