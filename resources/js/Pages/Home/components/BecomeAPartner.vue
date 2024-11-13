<template>
    <section id="become-a-partner">
        <v-heading class="text-center">Become a Partner</v-heading>
        <div class="grid gap-10 md:grid-cols-2">
            <div>
                <v-heading type="h2">Reach us</v-heading>
                <p>
                    We'd love to hear from you! Whether you have questions, need
                    support, or want to share your feedback, feel free to reach
                    out to us. Our team is dedicated to providing you with the
                    best assistance possible.
                </p>

                <v-text-icon :items="infoList" class="my-5 grid" />

                <MKMap
                    v-once
                    class="mx-auto h-[20rem] overflow-hidden rounded-lg"
                ></MKMap>
            </div>

            <div class="space-y-3">
                <v-alert type="error" v-if="errors">{{ errors }}</v-alert>
                <v-text-field
                    prepend-inner-icon="co-mail-ru"
                    label="Email"
                    v-model="emailRegistrationFrom.email"
                    type="email"
                ></v-text-field>

                <v-text-field
                    prepend-inner-icon="ri-building-2-line"
                    label="Company"
                    v-model="emailRegistrationFrom.company"
                ></v-text-field>

                <v-select
                    label="Region"
                    :items="regions"
                    item-title="region"
                    item-value="abr"
                    prepend-inner-icon="pr-globe"
                    v-model="emailRegistrationFrom.region"
                ></v-select>
                <v-textarea
                    prepend-inner-icon="fa-regular-comment-alt"
                    label="Comment"
                    v-model="emailRegistrationFrom.comment"
                    rows="7"
                >
                </v-textarea>

                <v-button
                    prepend-inner-icon="pr-send"
                    class="ml-auto bg-accent text-white"
                    :loading="loading"
                    @click="registerEmail"
                >
                    Send
                </v-button>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, inject, ref } from "vue";
import { useEmailRegistrationStore } from "@/stores/emailRegistrationStore";
import { storeToRefs } from "pinia";
import MKMap from "@/components/MKMap.vue";

const { emailRegistrationFrom, registerEmail, errors, loading } =
    useEmailRegistration();
const addToast = inject("addToast");
const regions = computed(() => {
    return [
        { abr: "as", region: "Asia" },
        { abr: "af", region: "Africa" },
        { abr: "au", region: "Australia" },
        { abr: "eu", region: "Europe" },
        { abr: "na", region: "North America" },
        { abr: "sa", region: "South America" },
    ];
});

const infoList = computed(() => {
    return [
        {
            icon: "la-heart",
            title: "Contact (Philippines): ",
            value: "+63 917 564 9864",
        },
        {
            icon: "la-heart",
            title: "Contact (Denmark): ",
            value: "+45 41 10 64 74",
        },
        { icon: "io-mail-outline", title: "Email", value: "sales@mkta.com.ph" },
        {
            icon: "io-location-outline",
            title: "Address",
            value: "Lot 19, 21, 23 Livelihood St Pampanga Economic Zone, Angeles City, Pampanga 2009, Philippines",
        },
    ];
});

function useEmailRegistration() {
    const emailRegistrationStore = useEmailRegistrationStore();
    const { loading, errors } = storeToRefs(emailRegistrationStore);

    const emailRegistrationFrom = ref({
        email: null,
        company: null,
        region: "as",
        comment: null,
    });

    async function registerEmail() {
        await emailRegistrationStore.registerEmail(emailRegistrationFrom);

        if (!errors.value)
            addToast({
                props: {
                    type: "success",
                },
                timeout: 5000,
                content:
                    "We have received your registration, we will send you an email once we confirmed your credentials. Thank you",
            });
    }

    return {
        emailRegistrationFrom,
        registerEmail,
        loading,
        errors,
    };
}
</script>

<style scoped></style>
