import "./bootstrap";
import "../css/app.css";

import { createApp } from "vue";
import router from "./router/index";
import App from "./App.vue";
import VHeading from "./components/VHeading.vue";

import { OhVueIcon, addIcons } from "oh-vue-icons";
import {
    LaHeart,
    LaSearchSolid,
    LaCogSolid,
    LaBarsSolid,
    LaTimesSolid,
    LaArrowCircleDownSolid,
} from "oh-vue-icons/icons";

addIcons(
    LaHeart,
    LaSearchSolid,
    LaCogSolid,
    LaBarsSolid,
    LaTimesSolid,
    LaArrowCircleDownSolid,
);

const app = createApp(App);
app.use(router);
app.component("v-icon", OhVueIcon);
app.component("v-heading", VHeading);
app.mount("#app");
