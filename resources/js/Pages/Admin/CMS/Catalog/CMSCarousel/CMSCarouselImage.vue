<template>
    <div>
        <ul class="flex grow flex-wrap gap-3">
            <li
                v-for="item in items"
                :key="item.id"
                role="button"
                @click="handleSelection(item)"
            >
                <v-text-on-image
                    :image="s3(item.filename)"
                    class="w-32"
                    :class="{
                        'outline outline-2 outline-offset-2 outline-accent':
                            selectedItem?.id === item.id,
                    }"
                    no-overlay
                ></v-text-on-image>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { inject, ref } from "vue";

const props = defineProps({
    items: Array,
});
const emits = defineEmits(["select"]);
const s3 = inject("s3");
const selectedItem = ref(null);

function handleSelection(item) {
    selectedItem.value = item;
    emits("select", item);
}
</script>

<style lang="scss" scoped></style>
