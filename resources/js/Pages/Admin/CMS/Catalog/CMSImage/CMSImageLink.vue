<template>
    <div class="space-y-2">
        <v-checkbox label="attach link" v-model="link"></v-checkbox>
        <div v-if="link">
            <v-text-field
                :class="`${isRouteValid ? 'text-green-500' : 'text-red-500'}`"
                prepend-inner-icon="ri-link"
                :disabled="!link"
                hint="dont include the domain and protocol e.g. (http://domain.com/catalog/categories/2) to just (/catalog/categories/3)"
                persistent-hint
                v-model="path"
            >
                <template #append-inner>
                    <v-icon
                        name="bi-check-circle-fill"
                        class="fill-green-500"
                        v-if="isRouteValid"
                    ></v-icon>
                    <v-icon
                        name="pr-times-circle"
                        class="fill-red-500"
                        v-else
                    ></v-icon>
                </template>
            </v-text-field>

            <v-button
                class="bg-slate-400 text-xs text-white"
                @click="handleCheckRoute"
                >verify and save</v-button
            >
        </div>
    </div>
</template>

<script setup>
import { inject, ref } from "vue";
import { useRouter } from "vue-router";

const link = defineModel("link");
const path = defineModel("path", { default: "/" });
const isRouteValid = ref(false);
const addToast = inject("addToast");
const router = useRouter();

function handleCheckRoute() {
    isRouteValid.value = checkRoute();
    addToast({
        props: {
            type: isRouteValid.value ? "success" : "danger",
        },
        content: isRouteValid.value
            ? "Link is valid"
            : "Invalid link (changes may not apply when save)",
    });
}
function checkRoute() {
    const resolved = router.resolve(path.value);

    console.log(resolved.matched);
    return (
        resolved.matched.length > 0 &&
        resolved.matched.at(0).name !== "notFound"
    );
}
</script>

<style lang="scss" scoped></style>
