<template>
    <div :class="$attrs.class">
        <router-link :to="{ name: 'product', params: { id: item.id } }">
            <v-text-on-image
                v-bind="$attrs"
                :class="`aspect-square cursor-pointer rounded-none`"
                :image="s3Thumbnail(item?.product_thumbnail?.file?.filename)"
            >
                <template #overlay="overlayProps">
                    <slot name="overlay" :item="item">
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
        </router-link>

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
                    <v-button
                        v-show="item.show_wishlist_button"
                        :loading="loading"
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
                    >
                    </v-button>
                </div>
            </div>
        </slot>
    </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { inject, ref } from "vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    item: {
        type: Object,
        default: {},
    },
});

const wishlistStore = inject("wishlistStore");
const { loading, wishlists } = storeToRefs(wishlistStore);
const addToast = inject("addToast");

const isIncludedOnWishlist = () => {
    return wishlistStore.isIncludedOnWishlist(props.item);
};

const handleAddToWishlist = async () => {
    await wishlistStore.addToWishlist(props.item);
    await wishlistStore.getWishlists();

    //show add toast
    addToast({
        props: {
            type: "success",
        },

        content: `${props.item.title} added to wishlist`,
    });
};

const handleRemoveFromWishlist = async () => {
    /* find the corresponding wishlist base on product id
    since wishlist id is needed to delete */
    const wishlist = wishlists.value.find(
        (e) => e.product.id === props.item.id,
    );

    if (wishlist) await wishlistStore.deleteWishlist(wishlist.id);
    await wishlistStore.getWishlists();

    //show delete toast
    addToast({
        props: {
            type: "info",
        },

        content: `${props.item.title} removed from wishlist`,
    });
};
const s3Thumbnail = inject("s3Thumbnail");
</script>

<style lang="scss" scoped></style>
