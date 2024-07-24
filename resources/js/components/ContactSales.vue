<template>
    <div class="grid gap-5 p-5 text-sm md:grid-cols-2" v-bind="$attrs">
        <p class="md:col-span-2">
            Please contact us via email, and we will respond at our earliest
            convenience. You may use the form provided below or send a direct
            email to
            <a href="mailto:info@us-cg.dk" class="text-accent"
                >sales@mkthemedattractions.com.ph</a
            >
        </p>
        <section class="space-y-3">
            <div class="p-1">
                <p class="mb-3">Item:</p>
                <ul class="grid gap-3">
                    <li :key="item.id" class="rounded-lg bg-slate-200 p-3">
                        <div>{{ item.title }}</div>
                        <span class="text-slate-400">{{ item.id }}</span>
                    </li>
                </ul>
            </div>

            <v-textarea
                label="Message"
                prepend-inner-icon="fa-regular-comment-alt"
            ></v-textarea>
        </section>
        <section class="hidden md:block">
            <MKMap
                v-once
                class="mx-auto h-[20rem] overflow-hidden rounded-lg"
            ></MKMap>
        </section>
    </div>

    <section class="primary-gradient p-3 text-[.8rem] md:col-span-2">
        <v-text-icon
            :items="infoList"
            class="grid text-slate-400 *:items-start"
            value-class="text-white"
            icon-size="1"
        />
    </section>
</template>

<script setup>
import MKMap from "@/components/MKMap.vue";
import { computed } from "vue";

defineProps({
    item: Object,
});

const infoList = computed(() => {
    return [
        { title: "Contact", value: "09563040025" },
        { title: "Email", value: "sales@mkta.com.ph" },
        {
            title: "Address",
            value: "Lot 19, 21, 23 Livelihood St Pampanga Economic Zone, Angeles City, Pampanga 2009, Philippines",
        },
    ];
});
</script>

<style lang="scss" scoped></style>
