<script setup>
import { RouterView, useRoute } from "vue-router";
import { useProductVerificationStore } from "@/stores/productVerificationStore";
import { computed, inject, provide, ref } from "vue";

import Tab from "./components/Tab.vue";
import VLoader from "@/components/base_components/VLoader.vue";
import { storeToRefs } from "pinia";

const route = useRoute();
const { verify, item, verifyForm, sendProduct, formValid } = useVerify();
await verify();

provide("item", item);
provide("verifyForm", verifyForm);
const addToast = inject("addToast");
const showConfirmationDialog = ref(false);

const tabItems = [
    {
        name: "Info",
        to: "verifyProductInformation",
        icon: "pr-info",
    },
    {
        name: "Category",
        to: "verifyProductCategory",
        icon: "md-category-outlined",
    },
    {
        name: "Images",
        to: "verifyProductImages",
        icon: "pr-images",
    },
    {
        name: "Restrictions and excemptions",
        to: "verifyProductRestrictionsAndExcemptions",
        icon: "pr-lock",
    },
    {
        name: "Related and recommended",
        to: "verifyProductRelatedAndRecommended",
        icon: "pr-share-alt",
    },
];

function useVerify() {
    const productVerificationStore = useProductVerificationStore();
    const { form: verifyForm, errors } = storeToRefs(productVerificationStore);

    const token = route.query.token;
    const item = ref(null);

    async function verify() {
        item.value = await productVerificationStore.verifyProduct(token);

        /* Initialize the value of form info to be the fetched item */
        if (!errors.value) {
            verifyForm.value["info"] = {
                product_id: item.value.product_id,
                parent_code: item.value.parent_code,
                title: item.value.title,
                description: item.value.description,
                volume: item.value.volume,
                weight_net: item.value.weight_net,
                weight_gross: item.value.weight_gross,
                dimension_length: item.value.dimension_length,
                dimension_width: item.value.dimension_width,
                dimension_height: item.value.dimension_height,
            };
        }

        /* Initialize the value of form info to be the fetched item */
        const images = await productVerificationStore.getTemporaryImages(
            item.value.product_id,
        );

        if (!errors.value) {
            if (images) {
                const parsedImages = JSON.parse(images.data);
                verifyForm.value["images"] = parsedImages;
            }
        }
    }

    async function sendProduct() {
        await productVerificationStore.sendProduct(token);

        if (!errors.value) {
            showConfirmationDialog.value = false;
            addToast({
                props: {
                    type: "success",
                },
                content: "Product successfully verified.",
            });
        } else {
            console.log(errors.value.data.errors);

            const errorMessage = Object.keys(errors.value.data.errors)
                .map((key) => {
                    return errors.value.data.errors[key][0];
                })
                .join("\n");

            addToast({
                props: {
                    type: "danger",
                },
                timeout: 8000,
                content: `Product verification failed. \n ${errorMessage} `,
            });
            showConfirmationDialog.value = false;
        }
    }

    const formValid = computed(() => {
        return (
            verifyForm.value["info"] !== null &&
            verifyForm.value["category"] !== null &&
            verifyForm.value["category"].length &&
            verifyForm.value["images"] !== null &&
            verifyForm.value["images"].length &&
            verifyForm.value["info"].description &&
            verifyForm.value["info"].dimension_height &&
            verifyForm.value["info"].dimension_length &&
            verifyForm.value["info"].dimension_width &&
            verifyForm.value["info"].parent_code &&
            verifyForm.value["info"].product_id &&
            verifyForm.value["info"].title &&
            verifyForm.value["info"].volume &&
            verifyForm.value["info"].weight_gross &&
            verifyForm.value["info"].weight_net
        );
    });

    return {
        token,
        verify,
        item,
        verifyForm,
        sendProduct,
        formValid,
    };
}
</script>

<template>
    <div class="container mt-10 space-y-5 rounded-md bg-white py-5 text-xs">
        <div>
            <h1 class="text-lg">Product Verification</h1>
            <p class="text-xs text-gray-500">
                Click on each tab and fill in the missing data
            </p>
        </div>

        <div class="space-y-2">
            <Tab :items="tabItems">
                <div class="ml-auto">
                    <v-button
                        class="bg-accent text-white shadow-sm"
                        :class="{ 'bg-gray-300': !formValid }"
                        @click="showConfirmationDialog = true"
                        :disabled="!formValid"
                        >Save</v-button
                    >
                </div>
            </Tab>
            <div class="rounded-md border p-3">
                <RouterView v-slot="{ Component }">
                    <template v-if="Component">
                        <KeepAlive>
                            <Suspense timeout="0">
                                <component :is="Component" />
                                <template v-slot:fallback>
                                    <div class="mx-auto w-fit">
                                        <VLoader></VLoader>
                                    </div>
                                </template>
                            </Suspense>
                        </KeepAlive>
                    </template>
                </RouterView>
            </div>
        </div>

        <v-dialog v-model="showConfirmationDialog" max-width="500">
            <template #header="props">
                <div class="flex items-center justify-between p-3">
                    <h3 class="text-sm font-medium">Review</h3>
                    <v-button
                        icon="md-close-round"
                        icon-size="1"
                        v-bind="props"
                    ></v-button>
                </div>
            </template>
            <div class="p-3 text-sm">
                <p>
                    Are you sure you have filled out all the required fields and
                    assigned the correct data to the product? Please note that
                    once submitted, this action cannot be undone.
                </p>
                <div class="mt-4 flex items-center gap-2">
                    <v-button
                        class="w-[5rem] border shadow-sm"
                        @click="sendProduct"
                        >Yes</v-button
                    >
                    <v-button
                        class="w-[5rem] bg-gray-100 px-4 shadow-sm"
                        @click="showConfirmationDialog = false"
                        >No</v-button
                    >
                </div>
            </div>
        </v-dialog>
    </div>
</template>

<style lang="scss" scoped></style>
