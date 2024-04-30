<template>
    <div>
        <header class="fixed top-0 z-50 w-full">
            <NavApp></NavApp>
        </header>

        <main class="container">
            <Index></Index>
        </main>

        <!-- extras -->
        <img
            src="/mk-images/background-pattern.png"
            alt="pattern"
            class="fixed left-[-10rem] top-0 -z-10 w-[30rem] opacity-10"
        />
        <img
            src="/mk-images/background-pattern-2.png"
            alt="pattern"
            class="fixed bottom-10 right-[-10rem] -z-10 w-[30rem] opacity-10"
        />
    </div>
</template>

<script>
import NavApp from "@/components/NavApp.vue";
import Index from "@/Pages/Home/Index.vue";
export default {
    components: { NavApp, Index },
};
</script>

<style scoped></style>
