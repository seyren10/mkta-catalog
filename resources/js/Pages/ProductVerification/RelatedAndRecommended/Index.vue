<script setup>
import { inject, ref } from "vue";
import Dialog from "./Dialog.vue";
import Selection from "./Selection.vue";

const form = inject("verifyForm");

const showRelatedDialog = ref(false);
const showRecommendedDialog = ref(false);

form.value["related"] = [];
form.value["recommended"] = [];
</script>
<template>
    <div class="space-y-10 p-4">
        <Selection
            title="Related Products"
            description="Select the products related to this item. These may include variants
            or products that share similarities."
            v-model:showDialog="showRelatedDialog"
            v-model:selectedProducts="form['related']"
        />

        <Selection
            title="Recommended Products"
            v-model:showDialog="showRecommendedDialog"
            v-model:selectedProducts="form['recommended']"
        >
            <template #description>
                <p class="mb-2 max-w-[80ch] text-gray-500">
                    Select the products you want to recommend to the user. These
                    may include products with similar titles or themes. For
                    example, if the product is a Santa Chair, you could
                    recommend a Santa Sleigh or a Wooden Chair.
                </p>
            </template>
        </Selection>

        <Dialog
            v-model:dialog="showRelatedDialog"
            v-model:selected="form['related']"
            title="Select related products"
        />
        <Dialog
            v-model:dialog="showRecommendedDialog"
            v-model:selected="form['recommended']"
            title="Select recommended products"
        />
    </div>
</template>

<style lang="scss" scoped></style>
