<template>
    <div class="grid gap-2 md:grid-cols-2">
        <div
            v-for="(component_data, index) in product.product_components
                .filter((obj) => obj.is_visible == 1)
                .filter((obj) =>
                    ['list', 'text', 'image', 'album', 'html', 'table', 'file'].includes(
                        obj.type,
                    ),
                )"
            :key="component_data.id"
            :class="'rounded-lg bg-transparent p-2' + ( component_data.type == 'table' ? ' col-span-2 ' : '' ) "
        >
            <h2
                class="w-full border-b-2 py-2 text-[1.5rem] font-bold tracking-wide"
            >
                {{ component_data.title }}
            </h2>
            <div class="pt-2">
                <component
                    :is="getType(component_data.type)"
                    :value="component_data.value"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { inject, computed, ref } from "vue";
const s3 = inject("s3");
const product = inject("product");

//!SECTION - Import of Components
import component_list from "../productComponents/list.vue";
import component_text from "../productComponents/text.vue";
import component_image from "../productComponents/image.vue";
import component_album from "../productComponents/album.vue";
import component_html from "../productComponents/html.vue";
import component_table from "../productComponents/table.vue";
import component_file from "../productComponents/file.vue";


const getType = (type) => {
    switch (type) {
        case "list":
            return component_list;
        case "text":
            return component_text;
        case "image":
            return component_image;
        case "album":
            return component_album;
        case "html":
            return component_html;
        case "table":
            return component_table;
            case "file":
            return component_file;
        default:
            break;
    }
};
</script>

<style lang="scss" scoped></style>
