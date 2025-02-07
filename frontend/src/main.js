import "./assets/main.css";
import { createApp, h } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import vSelect from "vue-select";
import { Chart as ChartJS } from "chart.js";

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.component("VSelect", vSelect);

import axios from "axios";

import { useAuthStore } from "@/stores/auth.js";

const authStore = useAuthStore();

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.baseURL = "http://localhost";
axios.defaults.headers.post["Content-Type"] = "application/json";
axios.defaults.headers.post["Accept"] = "application/json";

router.beforeEach((to, from, next) => {
  if (
    to.meta.requiresAuth &&
    !authStore.authenticated &&
    to.name !== "login" &&
    to.name !== "register"
  ) {
    return next({ name: "login" });
  }

  if (
    (to.name === "login" || to.name === "register") &&
    authStore.authenticated
  ) {
    return next({ name: "dashboard" });
  }

  if (!authStore.authenticated && to.meta.requiresAuth) {
    return next("/login");
  }

  next();
});

app.mount("#app");
