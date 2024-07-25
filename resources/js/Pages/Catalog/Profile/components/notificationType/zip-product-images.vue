<template>
    <div v-if="data === null">no Data</div>
    <div v-else>
        <div>
            <h2 class="text-lg">Product Image Download</h2>
            <div class="flex items-center gap-3 border">
                <div class="aspect-square max-w-[5rem] p-1">
                    <v-text-on-image
                        class="h-full"
                        :key="dataContent.product.product_thumbnail?.file_id"
                        :image="
                            s3(
                                dataContent.product.product_thumbnail?.file
                                    ?.filename,
                            )
                        "
                        no-overlay
                    ></v-text-on-image>
                </div>
                <div>
                    <p class="line-clamp-2 h-min">
                        {{ dataContent.product.title }}
                    </p>
                    <span class="text-[.7rem] text-slate-400">{{
                        dataContent.product.id
                    }}</span>
                </div>
                <div class="ml-auto">
                    <a :href="s3(dataContent.filename)" target="_blank">
                        <v-button class="" prepend-inner-icon="fa-download"
                            >Download</v-button
                        >
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { inject, ref } from "vue";

const props = defineProps({
    data: {
        Type: String,
        default: "{}",
    },
});

const dataContent = ref([]);
if (props.data !== null) {
    dataContent.value = JSON.parse(props.data).data;
}

const s3 = inject("s3");
</script>
