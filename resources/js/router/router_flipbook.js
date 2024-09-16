import MainLayout from "@/Layouts/MainLayout.vue";

const home_routes = [
    {
        path: "/flipbook",
        name: "index",
        component: MainLayout,
        beforeEnter(to, from, next) {
            if (to.hash) {
                next(); // No need to redirect
            } else {
                // Redirect to the same route with the hash fragment added
                next({ path: "/", hash: "#home" });
            }
        },
    },
];

export default home_routes;
