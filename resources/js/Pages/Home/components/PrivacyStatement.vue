<template>
    <v-dialog v-model="dialog" max-width="1000" title="Privacy Statement">
        <template #activator>
            <div
                class="cursor-pointer hover:text-slate-200"
                @click="dialog = true"
            >
                Privacy Statement
            </div>
        </template>

        <div class="p-8">
            <p>
                At our manufacturing company, we take your privacy and the
                protection of your personal information very seriously. This
                privacy statement explains how we collect, use, and protect your
                personal information when you visit our website.
            </p>

            <ul class="mt-5">
                <li
                    v-for="(item, index) in items"
                    :key="index"
                    class="my-5 space-y-1"
                >
                    <h3 class="font-bold">{{ item.title }}</h3>
                    <p class="text-slate-500">{{ item.value }}</p>
                </li>
            </ul>
        </div>
    </v-dialog>
</template>

<script setup>
import { computed, ref } from "vue";

//reactive
const dialog = ref(false);

//derivred
const items = computed(() => {
    return [
        {
            title: "Collection of Personal Information:",
            value: `We may collect personal information such as your name, email address,
              postal address, phone number, and other relevant information when you fill out a form on our website.
             This information is collected for the purpose of fulfilling your request and providing you with the best possible service.`,
        },
        {
            title: "Use of Personal Information:",
            value: `
            We use your personal information to provide you with the services and products you have requested, to communicate with you about your orders, 
            to send you important updates and promotional materials about our company, and to improve our website and the products and services we offer.
             We may also use your personal information to conduct market research and to better understand our customers' needs.
            `,
        },
        {
            title: "Protection of Personal Information:",
            value: `We take appropriate measures to protect your personal information from unauthorized access, 
            disclosure, or misuse. We use secure servers and encryption technologies to safeguard your information, 
            and we restrict access to your information to only those employees who need it to perform their jobs.`,
        },
        {
            title: "Disclosure of Personal Information:",
            value: `We may share your personal information with third-party service providers who assist us in providing you with our products and services.
             These service providers are contractually obligated to keep your information confidential and use it only for the purposes of providing their services to us.
             We may also share your personal information if required by law or if we believe that such disclosure is necessary to protect our rights, property, or safety or that of others.
             `,
        },
        {
            title: "Cookies:",
            value: `We may use cookies to enhance your experience on our website.
             Cookies are small files that are stored on your computer and allow us to remember your preferences, such as your language preferences or the items in your shopping cart. 
            You can choose to disable cookies in your browser settings, but this may affect the functionality of our website.
            `,
        },
        {
            title: "Links to Other Websites:",
            value: `
            Our website may contain links to other websites that are not under our control. 
            We are not responsible for the privacy practices or the content of these websites. 
            We encourage you to review the privacy policies of these websites before providing them with any personal information.
            `,
        },
        {
            title: "Changes to this Privacy Statement:",
            value: `We reserve the right to modify or update this privacy statement at any time without prior notice. 
            Any changes to this statement will be posted on our website.`,
        },
        {
            title: "Contact Information:",
            value: `If you have any questions or concerns about our privacy statement or the way we collect and use your personal information, please contact us.`,
        },
    ];
});
</script>

<style lang="scss" scoped></style>
