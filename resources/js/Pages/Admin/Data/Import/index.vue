<template>
    <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
        <uploadData v-bind="pageData" v-for="pageData in pages" />
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
]
pages.value = [
    ...pages.value,
    {
        pageTitle: "Related and Recommended Products",
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
]
pages.value = [
    ...pages.value,
    {
        pageTitle: "Categories",
        templateURL: "https://mkta-portal.s3.us-east-2.amazonaws.com/resources/categories.xlsx",
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
        isChecked : [
            {
                isChecked : false,
                label : 'I understand that changing the highlighted cells will cause ERROR'
            }
        ]
    },
]
pages.value = [
    ...pages.value,
    {
        pageTitle: "Product Filters",
        templateURL: "https://mkta-portal.s3.us-east-2.amazonaws.com/resources/product-filters.xlsx",
        actionURL: "/api/data-imports/product-filters",
        templateNotes: [

        ],
        pageNotes: [
            
        ],
        isChecked : [
            {
                isChecked : false,
                label : 'I understand that changing the highlighted cells will cause ERROR'
            }
        ]
    },
]
pages.value = [
    ...pages.value,
    {
        pageTitle: "Product Restriction and Exemption",
        templateURL: "https://mkta-portal.s3.us-east-2.amazonaws.com/resources/product-restriction-and-exemptions.xlsx",
        actionURL: "/api/data-imports/product-restriction-and-exemptions",
        templateNotes: [

        ],
        pageNotes: [
            
        ],
        isChecked : [
            {
                isChecked : false,
                label: 'I understand that ALL PRODUCT RESTRICTION AND EXEMPTION data will be replaced'
            },
            {
                isChecked : false,
                label : 'I understand that changing the highlighted cells will cause ERROR'
            }
        ]
    },
]
</script>
