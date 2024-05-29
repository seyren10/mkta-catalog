<template>
    <div class="container my-8 space-y-10">
        <div class="grid gap-3 md:grid-cols-[1fr_auto]">
            <v-image-carousel
                class="row-span-2 aspect-[3/1]"
                :items="[
                    '/carousel-test/carousel-1.jpg',
                    '/carousel-test/carousel-2.jpg',
                    '/carousel-test/carousel-3.jpg',
                ]"
            >
            </v-image-carousel>

            <v-text-on-image
                image="/carousel-test/10416177.jpg"
                class="aspect-[3/1] h-full min-w-full rounded-lg object-cover md:max-w-[25rem]"
                no-overlay
            />
            <v-text-on-image
                image="/carousel-test/eeq.jpg"
                class="aspect-[3/1] h-full min-w-full rounded-lg object-cover md:max-w-[25rem]"
                subtitle="whitespace-nowrap overflow-hidden [text-overflow:ellipsis] mt-2 text-[.8rem] text-slate-300"
            >
                <template #overlay-title>
                    <div class="flex items-center gap-2">
                        <v-icon name="la-heart" class="fill-accent"></v-icon>
                        <span>Tap to shop more</span>
                    </div>
                </template>
            </v-text-on-image>
        </div>

        <section class="space-y-10">
            <FeaturedProducts
                :items="hotProducts"
                titleIcon="ri-fire-line"
                title="Top selling"
            >
            </FeaturedProducts>

            <FeaturedProducts
                :items="newArrivals"
                titleIcon="md-newreleases-outlined"
                title="New Arrivals"
            >
                <template #overlay="data">
                    <span
                        class="absolute left-0 top-0 bg-red-500 p-1 text-[.7rem] text-white [border-bottom-right-radius:.5rem]"
                        >new</span
                    >

                    ></template
                >
                <template #content.icon="{ item }">
                    <div
                        v-bind="item"
                        class="rounded-md bg-red-500 px-1 text-[.7rem] text-white"
                    >
                        MK Mall
                    </div>
                </template>
            </FeaturedProducts>

            <div>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum,
                animi suscipit amet eum distinctio quae ad magni ipsam. Nihil
                voluptatibus sapiente earum. Ipsam, a. Quo ratione placeat
                commodi. Pariatur, sapiente. Deserunt debitis voluptas omnis
                architecto laborum, cum accusamus non dolorem. Veniam placeat ex
                delectus, distinctio inventore explicabo ea nostrum eveniet? Aut
                laborum eum, labore molestiae debitis neque odit ullam pariatur!
                Aspernatur quas nihil sed. Recusandae modi, commodi nisi ducimus
                rerum voluptates aliquid architecto eligendi, quia illum illo
                numquam, vel rem beatae veritatis aspernatur eveniet velit
                laborum neque doloribus autem provident? Libero cupiditate,
                error nobis ullam beatae officia autem molestiae. Eveniet,
                deleniti neque hic corrupti repellendus voluptatum. Veniam
                doloribus porro beatae eius veritatis, laudantium obcaecati
                debitis modi ullam at cum dolore. Maiores ut consequatur
                voluptates, ducimus accusamus sequi exercitationem pariatur
                ullam, eligendi reprehenderit quisquam suscipit ipsum dolor
                doloremque harum autem! Cumque perspiciatis, ipsum repudiandae
                fuga obcaecati consequatur nesciunt beatae. Cupiditate, eaque.
                Libero, autem, dolores in incidunt dolore cum eaque praesentium
                at cupiditate, magnam repellendus laborum ut illum id commodi!
                Qui fugit odit quo? Magni illo atque ipsum accusamus sapiente at
                pariatur. Exercitationem, aliquid fugit architecto nulla
                excepturi distinctio qui aperiam veniam fugiat ratione voluptas
                quibusdam mollitia expedita saepe neque dolore, dolorum maxime
                esse nobis delectus laborum vero vel accusamus corrupti. Sit!
                Consequatur nobis, perspiciatis sit illum praesentium,
                repellendus ea deserunt eum atque autem corporis, explicabo
                labore officiis cumque dolor hic magnam et repudiandae? Modi
                fuga quae sequi amet voluptatibus, sit atque! Enim tempore
                architecto facilis repudiandae quia eius necessitatibus quod
                vero saepe ducimus porro fugiat natus debitis adipisci libero,
                pariatur incidunt nesciunt asperiores sint aliquam optio
                exercitationem reiciendis dolores? Odit, asperiores? Doloremque
                laborum tenetur aut obcaecati quas pariatur id molestias
                laboriosam maiores possimus, error eos accusamus beatae enim
                cupiditate. Veniam odit nisi facilis rerum, et possimus! Ipsa
                culpa quo doloribus dolorum. Quia omnis, temporibus libero
                accusantium quidem non praesentium? Vel aperiam sunt maiores
                fugit, rerum saepe aliquid beatae! Assumenda labore
                voluptatibus, aperiam nam fugiat commodi animi expedita ipsa,
                porro nostrum quibusdam. Suscipit ratione recusandae, ad quidem,
                tenetur totam veritatis fugit, quaerat impedit eum vel iste
                iusto repellendus temporibus quam vitae perspiciatis atque!
                Nihil harum quae incidunt laborum pariatur cumque dignissimos
                aliquid. Nobis veniam porro quasi voluptatibus quod quis hic
                ullam quas nesciunt eaque cupiditate praesentium explicabo iure,
                tempora est consequuntur? Quos quisquam sed voluptates labore
                quaerat itaque odio at voluptatum cupiditate! Nihil sed, magni
                iure non officia fugiat asperiores vel animi recusandae? Qui
                corporis velit eos provident quibusdam ea voluptates quod iusto,
                sapiente nihil? Consequuntur itaque magni officiis, cum deserunt
                ipsum? Minima eum aspernatur debitis sapiente mollitia dolorem
                ipsum perspiciatis unde, corrupti aliquid eligendi, ratione
                laudantium expedita eius molestiae cum optio possimus temporibus
                sint vitae consectetur rem deserunt. Animi, itaque facilis? Iure
                nesciunt minima illum? Consequuntur nemo illum culpa veritatis
                sequi est totam ea corrupti maiores suscipit dolore doloribus
                expedita nobis quidem amet, quo recusandae vitae voluptas qui
                nisi tempore! Inventore. Amet, minus adipisci assumenda nobis
                illo veniam omnis, exercitationem vel a cum distinctio? Atque
                architecto exercitationem harum ex quos molestias voluptates,
                eligendi porro. Fugiat laboriosam reprehenderit neque maxime,
                consequatur dolor? At et, porro impedit saepe pariatur maxime
                distinctio. Adipisci fuga laboriosam maxime, delectus
                perspiciatis iste quisquam, cupiditate facilis nisi
                reprehenderit mollitia nam incidunt ex enim eius eum non vel
                reiciendis! Hic blanditiis autem ratione et inventore laboriosam
                amet dolore consequuntur nihil provident! Animi pariatur, quia
                voluptas, nemo totam reprehenderit cum porro quas repellendus
                tempore iste, velit facilis labore ipsum omnis. Delectus,
                ducimus aliquid? Quisquam hic vero, autem nostrum consectetur,
                deleniti quia quidem nisi eaque impedit cupiditate aliquid quos
                reiciendis error repudiandae magnam? Suscipit, consequuntur non
                expedita accusamus aliquam eaque rerum! Neque explicabo tempore
                accusamus, debitis vel commodi voluptatem illo asperiores? Illum
                nisi, doloremque eum cumque sunt ut iste fuga repellendus,
                architecto beatae quia accusamus vero consequuntur, id explicabo
                tenetur cupiditate. Voluptatum ipsam rem laboriosam perferendis
                quia sapiente temporibus quam dolor quisquam similique placeat
                explicabo provident, incidunt magnam nemo repellat adipisci
                molestiae dolorum quidem mollitia deleniti quaerat esse libero
                qui! Labore? Impedit odio dignissimos voluptates ea maiores
                autem quis, itaque magnam vel repellendus aliquam delectus, quas
                fugit provident asperiores, ad aperiam mollitia. Ratione veniam
                nostrum sint doloremque cum maxime voluptas nam. Odit incidunt
                dolorem, fugiat recusandae, tenetur ex id omnis sint officiis
                sunt dolor tempore alias in distinctio at molestias quidem a
                voluptate impedit. Hic molestiae quos excepturi, voluptatum
                magni atque! Sunt impedit vel exercitationem soluta unde error
                cupiditate dolorem expedita odio! Excepturi aperiam odit ea!
                Dolor reiciendis eos dolorum voluptas non voluptate dicta,
                aliquam iure provident atque eligendi qui quibusdam? Aperiam
                odit beatae, sed quia laudantium laborum eligendi voluptatum
                dolore, sunt facilis quis? Fugiat porro a eius vero! Quae
                delectus voluptate dolorem culpa fuga maiores? Dolores deserunt
                enim eum est! Veniam nobis cumque illum aperiam ipsa dolorum?
                Neque, dolores accusamus! Maiores eveniet optio nesciunt a
                inventore suscipit sunt ipsa quam praesentium? Debitis, adipisci
                aliquam nisi delectus repudiandae laborum. Consequuntur,
                eveniet? Numquam temporibus id magnam repudiandae alias aut
                saepe neque, sequi, minima tenetur velit assumenda natus nemo
                recusandae illo provident voluptates distinctio explicabo
                corporis laudantium. Reiciendis ratione quos assumenda quaerat
                facilis? Soluta suscipit recusandae quod blanditiis, ab
                voluptatum accusantium officia tenetur iure placeat deserunt
                veniam at reprehenderit eius, sequi exercitationem, tempora
                itaque autem ratione quisquam consequuntur dolorem est. Vitae,
                suscipit ea! Distinctio placeat architecto, nulla vel magni
                expedita eaque odio? Molestias, cupiditate libero quia culpa
                inventore eaque facere, officia dolorem perspiciatis quo, quos
                maiores aut non provident ut nesciunt consequatur obcaecati! Ad,
                ut beatae suscipit expedita aliquam explicabo laudantium
                aliquid! Corporis exercitationem magnam, omnis pariatur quos
                quas facilis nisi dolorum totam culpa itaque, natus asperiores
                tempora? Assumenda eaque odit soluta suscipit? Ipsa, id nostrum
                ut nesciunt animi perferendis facere at nihil minus quos
                architecto, voluptatibus praesentium labore omnis iste officia
                non. Asperiores assumenda saepe necessitatibus consequatur ullam
                tenetur explicabo iusto sequi? Accusamus, fugiat debitis aliquid
                dolores labore minima enim sequi officia illum deleniti nobis
                blanditiis pariatur reiciendis excepturi ipsum! Modi tempora
                deserunt magni quos. Assumenda libero dignissimos distinctio
                illo labore hic! Illum expedita in quaerat accusamus velit nam
                voluptates iure maiores, praesentium possimus autem aliquam unde
                harum aut quae facilis, beatae ipsa fugit hic incidunt veniam
                eaque dolor natus? Dicta, sequi? Nobis veniam deserunt quod
                aliquid, nemo doloremque aliquam, voluptatibus, modi libero
                tempore quas assumenda voluptatum. Accusamus reprehenderit
                ducimus doloribus, nisi culpa sapiente rem tempora voluptates
                cum soluta alias omnis corrupti. Corrupti nam ullam quam quae
                cupiditate sequi quis a esse? Asperiores eos nihil ipsam commodi
                id molestias assumenda, eaque ipsa accusantium quaerat qui
                animi, distinctio placeat veritatis aliquid facere neque. Vitae
                molestiae facere aperiam! Velit a sed omnis neque. Nam amet
                cupiditate earum officia hic cumque possimus sequi nesciunt iure
                facere esse, dolorem quidem soluta voluptatibus dicta labore!
                In, laudantium! Laboriosam, voluptatum. Deserunt, provident, non
                inventore quo quas laboriosam rem nihil voluptatem dolores
                architecto ea nemo, veritatis facilis ipsam fuga error. Quos
                architecto, sunt quisquam reiciendis natus perferendis veritatis
                similique. Architecto aliquid quis veniam quod facere atque esse
                impedit excepturi fugiat. Sequi aspernatur, aperiam alias
                laborum veniam enim cupiditate amet esse hic error maiores ipsa
                voluptates sunt omnis reprehenderit dolores. Et delectus
                sapiente ducimus fugiat? Vero, esse. Culpa omnis dolore eveniet
                quis. Similique repellendus accusantium fugiat esse consectetur
                eius, hic ratione reiciendis nihil deleniti maiores vitae minus
                eveniet sunt. Minima! Quo, dolorem mollitia deserunt totam eius
                optio. Repudiandae, consequatur, ex maiores necessitatibus nam,
                alias id provident reprehenderit saepe magni aut ea odit?
                Asperiores ipsa quam laboriosam voluptate corrupti. Hic,
                explicabo! Eligendi accusamus totam commodi aut reprehenderit
                tenetur sed eos, enim exercitationem maiores, asperiores ullam,
                eaque deserunt voluptas placeat ab! Aspernatur totam similique
                neque laborum atque quasi, tenetur doloremque repellendus sit!
                Eos saepe cupiditate facere earum magni laboriosam! Repellendus
                similique obcaecati, laudantium repellat eum tempore velit
                doloribus reprehenderit cumque maiores ipsam inventore rem vitae
                molestias totam soluta. Illum distinctio temporibus libero.
                Eveniet, similique sed hic nam aut quibusdam numquam nulla vel
                repellendus saepe perspiciatis culpa, at ullam debitis accusamus
                ipsum odit. Neque quae recusandae sunt sequi et a nulla
                exercitationem veritatis! Exercitationem nisi ipsa facilis. Odit
                optio magnam neque perferendis provident repudiandae illum
                tempora non accusantium porro nulla, ducimus dolor iure fuga,
                delectus enim assumenda. Nisi saepe provident natus doloribus
                animi. Qui esse, ad sunt sit similique a ullam hic laboriosam,
                adipisci voluptas molestias quia labore dolor eveniet quod
                exercitationem in minima odit eum amet eligendi. Incidunt enim
                amet eveniet consectetur? Alias quos, quas non similique, dicta
                culpa deleniti ullam sequi eos soluta ab. Perspiciatis iure,
                soluta, dicta, molestias reprehenderit eum magnam numquam modi
                tenetur voluptas saepe provident tempora est rerum! Placeat
                voluptates illum qui fugit autem deleniti nemo, quae, quo
                incidunt, temporibus odio eligendi ab facilis quos. Quia, quae
                commodi eos rem, facere odit ipsum a aperiam labore vel
                accusantium? Dolorum adipisci odit nobis nulla exercitationem,
                excepturi autem eligendi voluptate corporis fugiat dicta in. Aut
                quis ex totam, magnam neque eius. Iure itaque minima rerum
                numquam odit nisi quod maxime? Libero illum corporis accusantium
                quis facere pariatur dolorum, mollitia amet itaque maxime
                provident temporibus. Architecto hic saepe amet ipsa, optio eius
                magni maxime eaque quam eum? Nobis amet ut repudiandae?
            </div>
        </section>

        <!-- <v-card density="comfortable">
            <template #header>
                <header
                    class="grid min-h-[10rem] rounded-lg bg-[url('/mk-images/inlitefi.jpg')] bg-cover bg-center bg-no-repeat text-white"
                >
                    <div class="self-end p-4">
                        <h2 class="text-[1.3rem] font-medium tracking-wide">
                            A Heading with background Image
                        </h2>
                        <p class="font-light text-slate-200">
                            If you can read this, you are gay.
                        </p>
                    </div>
                </header>
            </template>
            <div>
                We are the champion. Lorem, ipsum dolor sit amet consectetur
                adipisicing elit. Doloribus earum laudantium soluta eveniet, id
                dolorum praesentium quia, facilis sit, ab et beatae optio est
                officiis exercitationem ut tenetur? Nam, ea.
            </div>
            <template #action>
                <v-button
                    class="text-accent"
                    outlined
                    prepend-inner-icon="pr-send"
                    icon-size="1"
                    >See More</v-button
                >
            </template>
        </v-card>
        <v-text-field v-model="search"> </v-text-field>
        <v-data-table
            :items="items"
            :search="search"
            class="my-3"
            striped
            density="comfortable"
        ></v-data-table>
        <v-text-on-image
            image="/carousel-test/eeq.jpg"
            title="This is it"
            subtitle="shop now and get debunked."
        >
            <template #overlay-title="{ title }">
                <h1 class="text-red-500">{{ title }}</h1>
            </template>
        </v-text-on-image> -->
    </div>
</template>

<script setup>
import { ref } from "vue";

import FeaturedProducts from "./components/FeaturedProducts.vue";

const hotProducts = [
    {
        image: "/carousel-test/3.jpg",
        sold: "1.5k",
        details: {
            description:
                "Lion Standing in front a of alaskan man extending his arm upto the heavens above",
            dimension: "80cm x 40cm x 20cm",
            materials: "FIBERGLASS",
            finish: "HANDPAINTED",
        },
        isBestSeller: true,
    },
    {
        image: "/carousel-test/1.jpeg",
        sold: "1.5k",
        details: {
            description: "Zoo Animals (package)",
            dimension: "80cm x 40cm x 20cm",
            materials: "FIBERGLASS",
            finish: "HANDPAINTED",
        },
    },
    {
        image: "/carousel-test/2.jpg",
        sold: "3.1k",
        details: {
            description: "Random Presents",
            dimension: "90cm x 45cm x 25cm",
            materials: "BRONZE",
            finish: "POLISHED",
        },
    },
    {
        image: "/carousel-test/4.jpg",
        sold: "1.8k",
        details: {
            description: "Tiger Prowling",
            dimension: "100cm x 50cm x 30cm",
            materials: "MARBLE",
            finish: "HANDPAINTED",
        },
    },
    {
        image: "/carousel-test/5.jpg",
        sold: "4.2k",
        details: {
            description: "Balloon Hound",
            dimension: "85cm x 40cm x 25cm",
            materials: "STONE",
            finish: "HANDCARVED",
        },
    },
    {
        image: "/carousel-test/6.jpg",
        sold: "2.9k",
        details: {
            description: "Cute Cactus",
            dimension: "95cm x 45cm x 35cm",
            materials: "RESIN",
            finish: "PAINTED",
        },
    },
    {
        image: "/carousel-test/archway1.jpg",
        sold: "88.9k",
        details: {
            description: "Flower Archway",
            dimension: "44cm x 465cm x 42cm",
            materials: "MARBLE",
            finish: "HANDPAINTED",
        },
    },
    {
        image: "/carousel-test/cat.jpg",
        sold: "2.32k",
        details: {
            description: "Bob the Cat",
            dimension: "55cm x 65cm x 422cm",
            materials: "FIBERGLASS",
            finish: "HANDPAINTED",
        },
    },
    {
        image: "/carousel-test/cat.jpg",
        sold: "2.32k",
        details: {
            description: "Bob the Cat",
            dimension: "55cm x 65cm x 422cm",
            materials: "FIBERGLASS",
            finish: "HANDPAINTED",
        },
    },
];

const newArrivals = [
    {
        image: "/carousel-test/elephant.jpg",
        data: "",
        details: {
            description: "Elephant",
            dimension: "80cm x 40cm x 20cm",
            materials: "FIBERGLASS",
            finish: "HANDPAINTED",
        },
    },
    {
        image: "/carousel-test/archway2.jpg",
        data: "",
        details: {
            description: "Archway 2",
            dimension: "90cm x 45cm x 25cm",
            materials: "BRONZE",
            finish: "POLISHED",
        },
    },
    {
        image: "/carousel-test/greek.jpg",
        data: "",
        details: {
            description: "Julius Ceasar",
            dimension: "100cm x 50cm x 30cm",
            materials: "MARBLE",
            finish: "HANDPAINTED",
        },
    },
    {
        image: "/carousel-test/rhino.png",
        data: "",
        details: {
            description: "Rhinocerous",
            dimension: "44cm x 465cm x 42cm",
            materials: "MARBLE",
            finish: "HANDPAINTED",
        },
    },
    {
        image: "/carousel-test/tiger.avif",
        data: "",
        details: {
            description: "Tiger Cartoon",
            dimension: "90cm x 45cm x 25cm",
            materials: "BRONZE",
            finish: "POLISHED",
        },
    },
    {
        image: "/carousel-test/archway3.jpg",
        data: "",
        details: {
            description: "Archway 3",
            dimension: "100cm x 50cm x 30cm",
            materials: "MARBLE",
            finish: "HANDPAINTED",
        },
    },
    {
        image: "/carousel-test/halloween1.jpg",
        data: "",
        details: {
            description: "Scary Scary One",
            dimension: "90cm x 45cm x 25cm",
            materials: "BRONZE",
            finish: "POLISHED",
        },
    },
    {
        image: "/carousel-test/halloween6.jpg",
        data: "",
        details: {
            description: "The Haunting (Large)",
            dimension: "80cm x 40cm x 20cm",
            materials: "FIBERGLASS",
            finish: "HANDPAINTED",
        },
    },
];

const items = ref(null);

await fetch("https://jsonplaceholder.typicode.com/todos")
    .then((res) => res.json())
    .then((json) => (items.value = json));
</script>

<style lang="scss" scoped></style>
