import "./assets/main.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import vSelect from "vue-select";

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.component("VSelect", vSelect);

import axios from "axios";

import { useAuthStore } from "@/stores/auth.js";
axios.defaults.baseURL = import.meta.env.VITE_BACKEND_BASE_URL ?? "http://localhost";
axios.defaults.headers.post["Content-Type"] = "application/json";
axios.defaults.headers.post["Accept"] = "application/json";

axios.interceptors.request.use(function (config) {
  const token = localStorage.getItem('token');
  config.headers.Authorization =  token ? `Bearer ${token}` : '';
  return config;
});

const authStore = useAuthStore();

router.beforeEach((to, from, next) => {
  if (
    to.meta.requiresAuth &&
    !authStore.token &&
    to.name !== "login" &&
    to.name !== "register"
  ) {
    return next({ name: "login" });
  }

  if (
    (to.name === "login" || to.name === "register") &&
    authStore.token
  ) {
    return next({ name: "dashboard" });
  }

  if (!authStore.token && to.meta.requiresAuth) {
    return next("/login");
  }

  next();
});

app.mount("#app");
