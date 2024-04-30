<template>
    <section id="our-specialties" class="grid gap-5 md:grid-cols-2">
        <div class="-z-10 col-start-1 row-start-1 overflow-hidden rounded-md">
            <img
                loading="lazy"
                src="/mk-images/2.png"
                alt=""
                class="h-full w-full object-cover object-bottom"
            />
        </div>
        <div
            class="z-10 col-start-1 row-start-1 my-auto rounded-md p-3 text-white backdrop-blur-sm md:mx-20"
        >
            <v-heading type="h2" class="mb-3 border-b-2 text-white"
                >Our specialties</v-heading
            >
            <p>
                Custom Projects, Themed and Architectural Projects,
                Animatronics, Lighting, Theming Design, Festive Lightning,
                Indoor and Outdoor Theming, Fiberglass Decorations, Themed
                Attractions, Themed Parks, Leisure and Tourism Attractions, 3D
                Design, Themed Scultptures, Themed Decorations
            </p>
        </div>
        <div>
            <div class="overflow-hidden rounded-md bg-stone-200 text-center">
                <div class="md:order-2">
                    <img
                        loading="lazy"
                        src="/illustrations/mission.jpg"
                        class="aspect-[1/.4] object-cover"
                        alt=""
                    />
                </div>
                <v-heading type="h2">Mission</v-heading>
                <p class="px-5 pb-5">
                    To be the reason of today's smile on our partners visitors
                    worldwide.
                </p>
            </div>
            <div
                class="mt-10 overflow-hidden rounded-md bg-stone-200 text-center"
            >
                <img
                    loading="lazy"
                    src="/illustrations/vision.jpg"
                    class="aspect-[1/.4] object-cover object-top"
                    alt=""
                />
                <v-heading type="h2">Vision</v-heading>
                <p class="px-5 pb-5">
                    To be one of the world's leading producers and providers
                    themed turnkey solutions and using its portfolio of high
                    quality procedures to differentiate its content, service and
                    design.
                </p>
            </div>
        </div>
    </section>
</template>

<script>
export default {};
</script>

<style scoped>
.background-plane {
    /* background: linear-gradient(
            135deg,
            #ffffff 20%,
            transparent 20%,
            transparent 80%,
            #ffffff 80%
        ),
        linear-gradient(
            45deg,
            #ffffff 40%,
            #d6d3d1 40%,
            #d6d3d1 60%,
            #d6d3d1 60%,
            #ffffff 60%
        ),
        linear-gradient(
            135deg,
            #ffffff 20%,
            #d6d3d1 20%,
            #d6d3d1 80%,
            #ffffff 80%
        );
    background-size: 6em 6em;
    background-attachment: fixed;
    background-color: #ffffff;
    opacity: 0.5; */
    background: url("/mk-images/plane-removebg-preview.png") no-repeat;
    background-position: bottom;
    opacity: 0.2;
}
.background-pumpkin {
    /* background: radial-gradient(circle, #d6d3d1 10%, transparent 11%);
    background-size: 6em 6em;
    background-color: #ffffff;
    background-attachment: fixed;

    opacity: 1; */
    background: url("/mk-images/pumpkin-removebg-preview.png") no-repeat;
    background-position: bottom;
    opacity: 0.2;
}
</style>
