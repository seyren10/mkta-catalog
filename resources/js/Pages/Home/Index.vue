<template>
    <header>
        <NavApp class="fixed top-0 z-[4000] w-full" />
    </header>

    <main class="container space-y-20">
        <HeroSection />
        <OurSpecialtiesSection />
        <OurProcesses />
        <WorkWithUs />
        <AboutUs />
        <BecomeAPartner />
    </main>

    <footer>
        <Footer class="mt-20" />
    </footer>
</template>

<script setup>
import HeroSection from "./components/HeroSection.vue";
import OurSpecialtiesSection from "./components/OurSpecialtiesSection.vue";
import WorkWithUs from "./components/WorkWithUs.vue";
import AboutUs from "./components/AboutUs.vue";
import OurProcesses from "./components/OurProcesses.vue";
import BecomeAPartner from "./components/BecomeAPartner.vue";
import Footer from "./components/Footer.vue";
import NavApp from "@/components/NavApp.vue";
</script>

<style scoped></style>
