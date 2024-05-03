import "./bootstrap";
import "../css/app.css";

import { createApp } from "vue";
import router from "./router/index";
import App from "./App.vue";
import VHeading from "./components/VHeading.vue";
import VSvg from "./components/VSvg.vue";
import VTextField from "./components/VTextField.vue";
import VTextArea from "./components/VTextArea.vue";
import VSelect from "./components/VSelect.vue";

import { OhVueIcon, addIcons } from "oh-vue-icons";
import {
    LaHeart,
    LaSearchSolid,
    LaCogSolid,
    LaBarsSolid,
    LaTimesSolid,
    LaArrowCircleDownSolid,
    BiHeartFill,
    LaArrowCircleLeftSolid,
    LaArrowCircleRightSolid,
    FaQuoteRight,
    FaQuoteLeft,
    IoMailOutline,
    OiComment,
    LaArrowsAltVSolid,
    LaCheckSolid,
} from "oh-vue-icons/icons";

addIcons(
    LaHeart,
    LaSearchSolid,
    LaCogSolid,
    LaBarsSolid,
    LaTimesSolid,
    LaArrowCircleDownSolid,
    BiHeartFill,
    LaArrowCircleLeftSolid,
    LaArrowCircleRightSolid,
    FaQuoteRight,
    FaQuoteLeft,
    IoMailOutline,
    OiComment,
    LaArrowsAltVSolid,
    LaCheckSolid,
);

const app = createApp(App);
app.use(router);
app.component("v-icon", OhVueIcon);
app.component("v-heading", VHeading);
app.component("v-svg", VSvg);
app.component("v-text-field", VTextField);
app.component("v-textarea", VTextArea);
app.component("v-select", VSelect);
app.mount("#app");
