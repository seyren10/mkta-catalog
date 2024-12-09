<template>
    <div class="">
        <v-card class="my-2">
            <template #title>
                <p class="text-xl font-bold">Web Server Resource Limitation</p>
            </template>
            <div>
                Due to the limitation of the Hosting Services data upload will
                be limited on the local machine and follows the indicated steps
                below
            </div>
            <div class="border-b border-t p-2">
                <ul class="grid grid-cols-1 gap-2">
                    <li>Step 1</li>
                    <li class="m-0 ms-2">
                        Run the following command in the Local Environment /
                        Development Computer
                        <ul class="border border-r-2 bg-accent p-2 text-white">
                            <li>• php artisan serve</li>
                            <li>• npm run dev</li>
                            <li>• php artisan optimize:clear</li>
                            <li>• php artisan queue:listen</li>
                        </ul>
                    </li>
                    <li>Step 2</li>
                    <li class="m-0 ms-2">
                        Log in and navigate to Admin Panel -> Data Upload
                    </li>
                    <li>Step 3</li>
                    <li class="m-0 ms-2">
                        Upload the file then wait the execution is done
                    </li>
                    <li>Step 4</li>
                    <li class="m-0 ms-2">
                        Upload the affected database or table in the Web Server
                    </li>
                </ul>
            </div>
        </v-card>
        <v-accordion>
            <template #title>
                <div>
                    <h2 class="text-xl font-bold">Data Upload</h2>
                </div>
            </template>
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                <uploadData v-bind="pageData" v-for="pageData in pages" />
            </div>
        </v-accordion>
    </div>
</template>
<script setup>
import { ref } from "vue";
import uploadData from "./components/dataUpload.vue";

const pages = ref([]);
pages.value = [
    ...pages.value,
    {
        pageTitle: "Product Information",
        templateURL: null,
        actionURL: "/api/data-imports/products",
        pageNotes: [
            {
                type: "text",
                value: "Volume (cm2), Net Weight, Gross Weight, Length, Width, and Height should be numeric value only.",
            },
            {
                type: "text",
                value: "Data uploaded will be the updated value, unless there's an error.",
            },
        ],
    },
];
pages.value = [
    ...pages.value,
    {
        pageTitle: "Related and Recommended Products",
        allowMultiple: true,
        templateURL: null,
        actionURL: "/api/data-imports/related-and-recommended-products",
        pageNotes: [
            {
                type: "text",
                value: "Product Code of the Target Product should be the name of the sheet",
            },
            {
                type: "html",
                value: "<p>Column <span class='px-2 bg-red-500 rounded text-white'>A</span> is the Related Product</p>",
            },
            {
                type: "html",
                value: "<p>Column <span class='px-2 bg-red-500 rounded text-white'>B</span> is the Recommended Product</p>",
            },
        ],
    },
];
pages.value = [
    ...pages.value,
    {
        pageTitle: "Product Components",
        allowMultiple: true,
        templateURL: null,
        actionURL: "/api/data-imports/product-components",
        pageNotes: [
            {
                type: "text",
                value: "Product Code of the Target Product should be the name of the sheet",
            },
        ],
    },
];
pages.value = [
    ...pages.value,
    {
        pageTitle: "Categories",
        templateURL:
            "https://mkta-portal.s3.us-east-2.amazonaws.com/resources/categories.xlsx",
        actionURL: "/api/data-imports/categories",
        templateNotes: [
            {
                type: "html",
                value: "<p>Cell <span class='px-2 bg-red-500 rounded text-white'>A1</span> should not be changed</p>",
            },
        ],
        pageNotes: [
            {
                type: "text",
                value: "Unregistered categories will not be saved",
            },
            {
                type: "text",
                value: "Maximum of 10,000 rows per sheet",
            },
        ],
        isChecked: [
            {
                isChecked: false,
                label: "I understand that changing the highlighted cells will cause ERROR",
            },
        ],
    },
];
pages.value = [
    ...pages.value,
    {
        pageTitle: "Product Filters",
        templateURL:
            "https://mkta-portal.s3.us-east-2.amazonaws.com/resources/product-filters.xlsx",
        actionURL: "/api/data-imports/product-filters",
        templateNotes: [],
        pageNotes: [],
        isChecked: [
            {
                isChecked: false,
                label: "I understand that changing the highlighted cells will cause ERROR",
            },
        ],
    },
];
pages.value = [
    ...pages.value,
    {
        pageTitle: "Product Restriction and Exemption",
        // templateURL: "https://mkta-portal.s3.us-east-2.amazonaws.com/resources/product-restriction-and-exemptions.xlsx",
        actionURL: "/api/data-imports/product-restriction-and-exemptions",
        templateNotes: [],
        pageNotes: [],
        isChecked: [
            {
                isChecked: false,
                label: "I understand that ALL PRODUCT RESTRICTION AND EXEMPTION data will be replaced",
            },
            {
                isChecked: false,
                label: "I understand that changing the highlighted cells will cause ERROR",
            },
        ],
    },
];
</script>
