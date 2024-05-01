<template>
    <section id="our-processes" class="rounded-md bg-stone-200 p-3">
        <v-heading class="text-center">Our Processes</v-heading>
        <div class="grid gap-5 md:grid-cols-2">
            <div class="grid">
                <video
                    controls
                    src="/videos/werewolf fin2 1.mp4"
                    class="h-full rounded-md"
                    poster="/Logo.svg"
                ></video>

                <div class="relative isolate mt-5 self-end">
                    <v-heading type="h2" class="mb-3"
                        >Witness Our Manufacturing Journey</v-heading
                    >
                    <p class="italic">
                        Embark on a visual journey through our meticulous
                        process. Witness firsthand the careful steps each item
                        undergoes, ensuring precision and excellence at every
                        stage.
                    </p>
                    <span class="block text-right font-bold italic"
                        >~Someone's name here</span
                    >

                    <v-icon
                        name="fa-quote-right"
                        scale="4"
                        class="absolute bottom-0 right-0 -z-10 fill-accent opacity-50"
                    ></v-icon>
                    <v-icon
                        name="fa-quote-left"
                        scale="4"
                        class="absolute left-0 top-4 -z-10 fill-accent opacity-50"
                    ></v-icon>
                </div>
            </div>
            <VCarousel :items="carouselData" />
        </div>
    </section>
</template>

<script setup>
import VCarousel from "@/components/VCarousel.vue";
import { computed } from "vue";

const carouselData = computed(() => {
    return [
        {
            img: "/mk-images/werewolf/1. Concept.png",
            title: "Concept",
            caption: `This is the initial stage where ideas are brainstormed and concepts are developed.
             It involves gathering inspiration, sketching out designs, and defining the vision for the final product.`,
        },
        {
            img: "/mk-images/werewolf/2. 3D.png",
            title: "3D Modeling",
            caption: `Using advanced software, the concepts are translated into detailed three-dimensional models. 
                This process allows for a thorough exploration of the design and ensures that every aspect is carefully considered before moving forward`,
        },
        {
            img: "/mk-images/werewolf/3. Sculpting.png",
            title: "Sculpting",
            caption: `Skilled artisans then bring the digital designs to life by sculpting physical prototypes. 
                This hands-on process adds depth and character to the models, allowing for fine-tuning and adjustments as needed`,
        },
        {
            img: "/mk-images/werewolf/4. Molding.png",
            title: "Molding",
            caption: `Once the sculpting phase is complete and the design is finalized, molds are created to replicate the product on a larger scale. 
                These molds serve as templates for mass production, ensuring consistency and quality across multiple units.`,
        },
        {
            img: "/mk-images/werewolf/5. Assembly.png",
            title: "Assembly",
            caption: `Components and parts are meticulously assembled according to the design specifications.
                 This stage requires precision and attention to detail to ensure that each piece fits together seamlessly to form the final product.`,
        },
        {
            img: "/mk-images/werewolf/6. Sanding (Primer).png",
            title: "Sanding (Primer)",
            caption: `After assembly, the product undergoes thorough sanding to smooth out any imperfections and refine its surface texture.
                 This process results in a flawless finish and prepares the product for painting or other finishing techniques.`,
        },
        {
            img: "/mk-images/werewolf/7. Painting (Final).png",
            title: "Painting (Final)",
            caption: `Skilled painters apply color and finish to the product, bringing it to life with vibrant hues and detailed textures. 
                This stage allows for customization and personalization, adding depth and character to each piece.`,
        },
        {
            img: "/mk-images/werewolf/8. Packing.png",
            title: "Packing",
            caption: `The finished products are carefully packed and prepared for shipment or distribution.
                 This involves selecting appropriate packaging materials to ensure that the products arrive safely and securely at their final destination.`,
        },
    ];
});
</script>

<style lang="scss" scoped></style>
