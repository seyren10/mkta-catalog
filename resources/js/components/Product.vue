<template>
    <div :class="$attrs.class">
        <v-text-on-image
            v-bind="$attrs"
            :class="`aspect-square cursor-pointer rounded-none`"
            :image="s3(item?.product_images?.at(0)?.file.filename)"
            @click="$router.push({ name: 'product', params: { id: item.id } })"
        >
            <template #overlay="overlayProps">
                <slot name="overlay" :item="item">
                    <!-- <div
                        v-bind="overlayProps"
                        class="absolute bottom-1 left-1 max-w-[96%] rounded-lg bg-black bg-opacity-50 p-3 text-white"
                    >
                        <p
                            class="text-[.8rem]"
                            v-for="(detail, key) in item.details"
                            :key="key"
                        >
                            <span class="capitalize">{{ key }}</span> :
                            <span class="text-slate-300"> {{ detail }}</span>
                        </p>
                    </div> -->

                    <!-- #region new -->
                    <div
                        v-if="item.meta?.isNew"
                        class="absolute left-0 top-0 bg-accent p-0.5 text-[.7rem] tracking-wide text-white [border-bottom-right-radius:0.5rem]"
                    >
                        new
                    </div>
                    <!-- #endregion new -->

                    <!-- #region inlitefi -->
                    <div
                        v-if="item.meta?.illuminated"
                        class="absolute bottom-0 right-0 flex items-center bg-accent p-0.5 text-[.7rem] tracking-wide text-white [border-top-left-radius:0.5rem]"
                    >
                        <v-icon name="gi-fox"></v-icon>
                        <span>InliteFi</span>
                    </div>
                    <!-- #endregion inlitefi -->
                </slot>
            </template>
        </v-text-on-image>

        <slot name="content" :item="item">
            <div class="p-2">
                <div class="line-clamp-2">
                    <slot
                        name="content.icon"
                        :item="{ ...item, class: 'float-left mr-2' }"
                    >
                    </slot>
                    <h3 class="text-[.8rem] font-bold [text-overflow:ellipsis]">
                        {{ item.title }}
                    </h3>
                </div>
                <div class="flex items-center justify-between">
                    <p class="mt-1 text-[.8rem] text-gray-400">
                        {{ item.id }}
                    </p>

                    <v-toast
                        :type="isIncludedOnWishlist() ? 'success' : 'danger'"
                    >
                        <template #activator="props">
                            <v-button
                                v-bind="props"
                                :icon="
                                    isIncludedOnWishlist()
                                        ? 'la-heart-solid'
                                        : 'la-heart'
                                "
                                iconSize="1"
                                :class="
                                    isIncludedOnWishlist()
                                        ? 'text-red-500'
                                        : 'text-accent'
                                "
                                @click="
                                    isIncludedOnWishlist()
                                        ? handleRemoveFromWishlist()
                                        : handleAddToWishlist()
                                "
                            ></v-button>
                        </template>

                        <template v-if="isIncludedOnWishlist()">
                            Item added to wishlist.
                        </template>
                        <template v-else>
                            Item removed from wishlist.
                        </template>
                    </v-toast>
                </div>
            </div>
        </slot>
    </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { inject } from "vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    item: {
        type: Object,
        default: {},
    },
});

const wishlistUIStore = inject("wishlistUIStore");

const isIncludedOnWishlist = () => {
    return wishlistUIStore.isIncludedOnWishlist(props.item);
};

const handleAddToWishlist = () => {
    wishlistUIStore.addToWishlist(props.item);
};

const handleRemoveFromWishlist = () => {
    wishlistUIStore.removeFromWishlist(props.item);
};
const s3 = inject("s3");
</script>

<style lang="scss" scoped></style>
