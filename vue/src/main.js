import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "./index.css";

import { OhVueIcon, addIcons } from "oh-vue-icons";
import * as RiIcons from "oh-vue-icons/icons/ri";

const Ri = Object.values({ ...RiIcons });
addIcons(...Ri);

const app = createApp(App);
app.component("v-icon", OhVueIcon);

app.use(router).use(store).mount("#app");
