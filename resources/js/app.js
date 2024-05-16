import "./bootstrap";
import "../css/app.css";

import { createApp } from "vue";
import router from "./router/index";
import App from "./App.vue";

import { OhVueIcon, addIcons } from "oh-vue-icons";
import VAccordion from "./components/VAccordion.vue";

import {
    LaHeart,
    LaSearchSolid,
    LaCogSolid,
    LaBarsSolid,
    LaTimesSolid,
    LaChevronCircleDownSolid,
} from "oh-vue-icons/icons";

addIcons(
    LaHeart,
    LaSearchSolid,
    LaCogSolid,
    LaBarsSolid,
    LaTimesSolid,
    LaChevronCircleDownSolid,
);

const app = createApp(App);
app.use(router);
app.component("v-icon", OhVueIcon);
app.component("v-accordion", VAccordion);
app.mount("#app");
