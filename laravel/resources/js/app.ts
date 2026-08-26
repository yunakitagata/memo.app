import "../css/app.css";
import { createApp } from "vue";
import App from "./App.vue";
import pinia from "./plugins/pinia";
import router from "./router";
/*画面のurlの切り替えはvue Routerに任せますという意味*/

const app = createApp(App);
app.use(pinia);
app.use(router);
app.mount("#app");
