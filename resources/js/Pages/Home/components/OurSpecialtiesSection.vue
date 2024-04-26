<template>
    <section
        id="our-specialties"
        class="mt-20 grid overflow-hidden rounded-lg md:grid-cols-2"
    >
        <div class="md:order-2">
            <img
                loading="lazy"
                src="/mk-images/1.png"
                alt=""
                class="aspect-[3/2] w-[100%] object-cover"
            />
        </div>
        <div
            class="relative isolate grid place-content-center p-2 text-center md:order-1"
        >
            <div class="p-16 md:p-20">
                <v-heading type="h2" class="mb-3">Our specialties</v-heading>
                <p>
                    Custom Projects, Themed and Architectural Projects,
                    Animatronics, Lighting, Theming Design, Festive Lightning,
                    Indoor and Outdoor Theming, Fiberglass Decorations, Themed
                    Attractions, Themed Parks, Leisure and Tourism Attractions,
                    3D Design, Themed Scultptures, Themed Decorations
                </p>
            </div>
            <div class="background-plane absolute inset-0 -z-10"></div>
        </div>

        <div class="md:order-3">
            <img
                loading="lazy"
                src="/mk-images/2.png"
                alt=""
                class="aspect-[3/2] w-[100%] object-cover"
            />
        </div>
        <div class="relative isolate grid place-content-center p-20 md:order-4">
            <div class="background-pumpkin absolute inset-0 -z-10"></div>
            <div>
                <div class="text-center">
                    <v-heading type="h2">Mission</v-heading>
                    <p>
                        To be the reason of today's smile on our partners
                        visitors worldwide.
                    </p>
                </div>
                <div class="mt-10 text-center">
                    <v-heading type="h2">Vision</v-heading>
                    <p>
                        To be one of the world's leading producers and providers
                        themed turnkey solutions and using its portfolio of high
                        quality procedures to differentiate its content, service
                        and design.
                    </p>
                </div>
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
