import { defineStore } from "pinia";
import { computed, reactive } from "vue";

export const useProductStore = defineStore("products", () => {
    //states
    const products = reactive([
        {
            id: 1,
            image: "/carousel-test/animal1.jpeg",
            details: {
                description:
                    "Tiger sitting on a rock with a serene jungle background",
                dimension: "90cm x 50cm x 25cm",
                materials: "RESIN",
                finish: "HANDPAINTED",
            },
            meta: {
                sold: "1.5k",
                isHot: true,
                isNew: true,
                illuminated: true,
            },
            category_id: 5,
            created_at: "2024-01-15 12:34:56",
        },
        {
            id: 2,
            image: "/carousel-test/animal2.jpg",
            details: {
                description:
                    "Eagle soaring over a mountain range with wings spread wide",
                dimension: "120cm x 60cm x 30cm",
                materials: "BRONZE",
                finish: "HANDPAINTED",
            },
            category_id: 5,
            created_at: "2024-01-25 14:23:45",
        },
        {
            id: 3,
            image: "/carousel-test/animal3.jpg",
            details: {
                description:
                    "Dolphin leaping out of the water with a sunset in the background",
                dimension: "70cm x 35cm x 20cm",
                materials: "POLYESTER",
                finish: "HANDPAINTED",
            },
            category_id: 5,
            created_at: "2024-02-05 09:12:34",
        },
        {
            id: 4,
            image: "/carousel-test/animal4.jpg",
            details: {
                description:
                    "Horse galloping through an open field with mane flowing",
                dimension: "100cm x 50cm x 30cm",
                materials: "FIBERGLASS",
                finish: "HANDPAINTED",
            },
            category_id: 5,
            created_at: "2024-02-15 11:45:23",
        },
        {
            id: 5,
            image: "/carousel-test/animal5.jpg",
            details: {
                description: "Giraffe bending down to drink from a waterhole",
                dimension: "150cm x 80cm x 40cm",
                materials: "CERAMIC",
                finish: "HANDPAINTED",
            },
            category_id: 5,
            created_at: "2024-03-01 16:23:12",
        },
        {
            id: 6,
            image: "/carousel-test/animal6.jpg",
            details: {
                description: "Elephant raising its trunk in a sign of joy",
                dimension: "200cm x 100cm x 50cm",
                materials: "PLASTIC",
                finish: "HANDPAINTED",
            },
            category_id: 5,
            created_at: "2024-03-10 10:34:45",
        },
        {
            id: 7,
            image: "/carousel-test/animal7.jpg",
            details: {
                description:
                    "Penguin standing on ice with a baby penguin by its side",
                dimension: "50cm x 30cm x 20cm",
                materials: "ALUMINUM",
                finish: "HANDPAINTED",
            },
            category_id: 5,
            created_at: "2024-03-25 08:23:34",
        },
        {
            id: 8,
            image: "/carousel-test/animal8.png",
            details: {
                description:
                    "Peacock displaying its colorful feathers in a garden",
                dimension: "75cm x 40cm x 20cm",
                materials: "WOOD",
                finish: "HANDPAINTED",
            },
            category_id: 5,
            created_at: "2024-04-05 15:45:12",
        },
        {
            id: 9,
            image: "/carousel-test/animal9.avif",
            details: {
                description: "Bear standing on its hind legs roaring",
                dimension: "180cm x 90cm x 45cm",
                materials: "STONE",
                finish: "HANDPAINTED",
            },
            category_id: 5,
            created_at: "2024-04-15 13:34:56",
        },
        {
            id: 10,
            image: "/carousel-test/archway1.jpg",
            details: {
                description: "Wolf howling at the full moon in a snowy forest",
                dimension: "110cm x 55cm x 25cm",
                materials: "FIBERGLASS",
                finish: "HANDPAINTED",
            },
            category_id: 11,
            created_at: "2024-04-20 18:45:23",
        },
        {
            id: 11,
            image: "/carousel-test/archway2.jpg",
            details: {
                description: "Koala clinging to a eucalyptus tree",
                dimension: "60cm x 30cm x 20cm",
                materials: "RESIN",
                finish: "HANDPAINTED",
            },
            category_id: 11,
            created_at: "2024-04-25 17:34:45",
        },
        {
            id: 12,
            image: "/carousel-test/archway3.jpg",
            details: {
                description: "Panda sitting and eating bamboo in a lush forest",
                dimension: "80cm x 40cm x 25cm",
                materials: "BRONZE",
                finish: "HANDPAINTED",
            },
            category_id: 11,
            created_at: "2024-05-01 11:23:12",
        },
        {
            id: 13,
            image: "/carousel-test/archway4.jpg",
            details: {
                description:
                    "Kangaroo jumping across the outback with a joey in its pouch",
                dimension: "130cm x 70cm x 35cm",
                materials: "POLYESTER",
                finish: "HANDPAINTED",
            },
            category_id: 11,
            created_at: "2024-05-05 14:23:45",
        },
        {
            id: 14,
            image: "/carousel-test/archway5.jpg",
            details: {
                description: "Fox sitting in a meadow with wildflowers",
                dimension: "90cm x 45cm x 25cm",
                materials: "FIBERGLASS",
                finish: "HANDPAINTED",
            },
            category_id: 11,
            created_at: "2024-05-10 12:34:56",
        },
        {
            id: 15,
            image: "/carousel-test/archway6.jpg",
            details: {
                description: "Deer standing majestically in a forest clearing",
                dimension: "140cm x 70cm x 35cm",
                materials: "CERAMIC",
                finish: "HANDPAINTED",
            },
            category_id: 11,
            created_at: "2024-05-15 16:23:12",
        },
        {
            id: 16,
            image: "/carousel-test/christmas1.jpg",
            details: {
                description: "Monkey swinging from a tree branch",
                dimension: "100cm x 50cm x 25cm",
                materials: "PLASTIC",
                finish: "HANDPAINTED",
            },
            category_id: 1,
            created_at: "2024-05-20 10:34:45",
        },
        {
            id: 17,
            image: "/carousel-test/christmas2.jpg",
            details: {
                description: "Swan gliding across a serene lake",
                dimension: "80cm x 40cm x 20cm",
                materials: "ALUMINUM",
                finish: "HANDPAINTED",
            },
            category_id: 1,
            created_at: "2024-05-25 09:12:34",
        },
        {
            id: 18,
            image: "/carousel-test/christmas3.jpg",
            details: {
                description: "Rabbit hopping through a garden",
                dimension: "60cm x 30cm x 20cm",
                materials: "WOOD",
                finish: "HANDPAINTED",
            },
            category_id: 1,
            created_at: "2024-05-28 14:23:45",
        },
        {
            id: 19,
            image: "/carousel-test/christmas4.jpg",
            details: {
                description: "Owl perched on a tree branch at night",
                dimension: "50cm x 25cm x 20cm",
                materials: "STONE",
                finish: "HANDPAINTED",
            },
            category_id: 1,
            created_at: "2024-05-30 16:45:23",
        },
        {
            id: 20,
            image: "/carousel-test/christmas5.jpg",
            details: {
                description: "Leopard resting on a tree limb",
                dimension: "110cm x 55cm x 30cm",
                materials: "FIBERGLASS",
                finish: "HANDPAINTED",
            },
            category_id: 1,
            created_at: "2024-05-29 12:34:56",
        },
        {
            id: 21,
            image: "/carousel-test/christmas6.jpg",
            details: {
                description: "Flamingo standing in a shallow pond",
                dimension: "130cm x 70cm x 40cm",
                materials: "RESIN",
                finish: "HANDPAINTED",
            },
            category_id: 1,
            created_at: "2024-05-25 11:23:12",
            meta: {
                illuminated: true,
            },
        },
        {
            id: 22,
            image: "/carousel-test/halloween1.jpg",
            details: {
                description:
                    "Cheetah running at full speed across the savannah",
                dimension: "180cm x 90cm x 50cm",
                materials: "BRONZE",
                finish: "HANDPAINTED",
            },
            category_id: 2,
            created_at: "2024-01-14 10:34:45",
        },
        {
            id: 23,
            image: "/carousel-test/halloween2.jpg",
            details: {
                description: "Zebra grazing in an open plain",
                dimension: "100cm x 50cm x 30cm",
                materials: "POLYESTER",
                finish: "HANDPAINTED",
            },
            category_id: 2,
            created_at: "2024-01-20 08:23:34",
        },
        {
            id: 24,
            image: "/carousel-test/halloween3.jpg",
            details: {
                description: "Moose standing in a dense forest",
                dimension: "160cm x 80cm x 40cm",
                materials: "FIBERGLASS",
                finish: "HANDPAINTED",
            },
            category_id: 2,
            created_at: "2024-02-10 17:34:45",
        },

        {
            id: 31,
            image: "/carousel-test/halloween4.jpg",
            details: {
                description:
                    "Camel walking through a desert with sand dunes in the background",
                dimension: "150cm x 75cm x 40cm",
                materials: "RESIN",
                finish: "HANDPAINTED",
            },
            category_id: 2,
            created_at: "2024-03-01 09:12:34",
        },
        {
            id: 32,
            image: "/carousel-test/halloween5.jpg",
            details: {
                description:
                    "Whale breaching out of the ocean with a dramatic splash",
                dimension: "200cm x 100cm x 50cm",
                materials: "BRONZE",
                finish: "HANDPAINTED",
            },
            category_id: 2,
            created_at: "2024-03-15 08:23:34",
        },
        {
            id: 33,
            image: "/carousel-test/halloween6.jpg",
            details: {
                description: "Octopus spreading its tentacles in the deep sea",
                dimension: "130cm x 65cm x 30cm",
                materials: "POLYESTER",
                finish: "HANDPAINTED",
            },
            category_id: 2,
            created_at: "2024-04-01 14:23:45",
        },
        {
            id: 34,
            image: "/carousel-test/easter1.jpg",
            details: {
                description: "Shark swimming near a coral reef",
                dimension: "170cm x 85cm x 40cm",
                materials: "FIBERGLASS",
                finish: "HANDPAINTED",
            },
            category_id: 3,
            created_at: "2024-04-05 11:23:12",
        },
        {
            id: 35,
            image: "/carousel-test/easter2.jpg",
            details: {
                description: "Gorilla beating its chest in the jungle",
                dimension: "190cm x 95cm x 50cm",
                materials: "CERAMIC",
                finish: "HANDPAINTED",
            },
            category_id: 3,
            created_at: "2024-04-15 15:45:12",
        },
        {
            id: 36,
            image: "/carousel-test/easter3.jpg",
            details: {
                description: "Pelican diving into the water to catch fish",
                dimension: "100cm x 50cm x 25cm",
                materials: "PLASTIC",
                finish: "HANDPAINTED",
            },
            category_id: 3,
            created_at: "2024-05-01 12:34:56",
        },
        {
            id: 37,
            image: "/carousel-test/easter4.jpg",
            details: {
                description:
                    "Seahorse floating gracefully in an underwater garden",
                dimension: "60cm x 30cm x 20cm",
                materials: "ALUMINUM",
                finish: "HANDPAINTED",
            },
            category_id: 3,
            created_at: "2024-05-05 09:12:34",
        },
        {
            id: 38,
            image: "/carousel-test/easter5.jpg",
            details: {
                description: "Walrus lounging on an ice floe",
                dimension: "150cm x 75cm x 40cm",
                materials: "WOOD",
                finish: "HANDPAINTED",
            },
            category_id: 3,
            created_at: "2024-05-10 16:45:23",
        },
    ]);

    //actions
    const getProductsWithCategoryId = (categoryId) => {
        return products.filter((e) => e.category_id === categoryId);
    };

    const getNewProducts = (count = products.length) => {
        const productsCopy = [...products];

        return productsCopy
            .sort((a, b) => {
                const dateA = new Date(a.created_at);
                const dateB = new Date(b.created_at);

                return dateB - dateA;
            })
            .splice(0, count);
    };

    return { products, getProductsWithCategoryId, getNewProducts };
});
