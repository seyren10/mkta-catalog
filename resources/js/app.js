import "./bootstrap";
import "../css/app.css";

import { createApp } from "vue";
import router from "./router/index";
import App from "./App.vue";

//components
import VHeading from "./components/VHeading.vue";
import VSvg from "./components/VSvg.vue";
import VTextField from "./components/VTextField.vue";
import VTextArea from "./components/VTextArea.vue";
import VSelect from "./components/VSelect.vue";
import VTextIcon from "./components/VTextIcon.vue";
import VButton from "./components/VButton.vue";
import VDialog from "./components/VDialog.vue";
import VToolbar from "./components/VToolbar.vue";
import VAlert from "./components/VAlert.vue";
import VTooltip from "./components/VTooltip.vue";
import VMenu from "./components/VMenu.vue";
import VDataTable from "./components/VDataTable.vue";
import VAccordion from "./components/VAccordion.vue";
import VCard from "./components/VCard.vue";
import VTextOnImage from "./components/VTextOnImage.vue";
import VHorizontalScroller from "./components/VHorizontalScroller.vue";

//custom directives
import intersect from "@/directives/intersectionObserver.js";
import hideOnScroll from "@/directives/hideOnScroll.js";

import { createPinia } from "pinia";

import OhVueIcons from "./icons";
const pinia = createPinia();
const app = createApp(App);

app.use(pinia);
app.use(router);

//components
app.component("v-icon", OhVueIcons);
app.component("v-heading", VHeading);
app.component("v-svg", VSvg);
app.component("v-text-field", VTextField);
app.component("v-textarea", VTextArea);
app.component("v-select", VSelect);
app.component("v-text-icon", VTextIcon);
app.component("v-button", VButton);
app.component("v-dialog", VDialog);
app.component("v-toolbar", VToolbar);
app.component("v-alert", VAlert);
app.component("v-accordion", VAccordion);
app.component("v-tooltip", VTooltip);
app.component("v-menu", VMenu);
app.component("v-data-table", VDataTable);
app.component("v-card", VCard);
app.component("v-text-on-image", VTextOnImage);
app.component("v-horizontal-scroller", VHorizontalScroller);

//directives
app.directive("intersect", intersect);
app.directive("hideOnScroll", hideOnScroll);

app.mount("#app");
