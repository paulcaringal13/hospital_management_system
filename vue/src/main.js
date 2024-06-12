import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import { createVuestic } from "vuestic-ui";
import "vuestic-ui/styles/essential.css";
import "vuestic-ui/styles/typography.css";
import "./index.css";

import { OhVueIcon, addIcons } from "oh-vue-icons";
import * as RiIcons from "oh-vue-icons/icons/ri";
import * as FaIcons from "oh-vue-icons/icons/fa";

const RiFa = Object.values({ ...RiIcons, ...FaIcons });
addIcons(...RiFa);

const app = createApp(App);
app.component("v-icon", OhVueIcon);
app.use(
  createVuestic({
    config: {
      sizesConfig: {
        sizes: { small: 576, medium: 768, large: 1500, xlarge: 1700 },
      },
      colors: {
        variables: {
          // Default colors
          primary: "#5eead4",
          background: "#f8fafc",
          white: "#fff",
        },
      },
    },
  })
);
app.use(router).use(store).mount("#app");
