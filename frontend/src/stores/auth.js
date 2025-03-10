import { ref } from "vue";
import { defineStore } from "pinia";
import useAuth from "../composables/auth.js";
import router from "@/router/index.js";
import { useLoadingStore } from "@/stores/loading.js";

export const useAuthStore = defineStore("auth", () => {
  const token = ref(localStorage.getItem("token") ?? false);
  const errorMessage = ref("");
  const auth = useAuth();
  const loadingStore = useLoadingStore();

  const login = async (email, password) => {
    try {
      loadingStore.loading = true;
      const response = await auth.login(email, password);
      localStorage.setItem("token", response.data.token);
      token.value = response.data.token;
      errorMessage.value = "";
      await router.push("/");
    } catch (e) {
      errorMessage.value = e.response.data.message;
      console.log(e);
      localStorage.removeItem("token");
    } finally {
      loadingStore.loading = false;
    }
  };

  const register = async (name, email, password) => {
    try {
      loadingStore.loading = true;
      await auth.register(name, email, password);
      errorMessage.value = "";
      await router.push("/");
    } catch (e) {
      console.log(e);
      errorMessage.value = e.response.data.message;
    } finally {
      loadingStore.loading = false;
    }
  };

  const logout = async () => {
    try {
      loadingStore.loading = true;
      await auth.logout();
      token.value = false;
      await router.push("/");
    } catch (e) {
      errorMessage.value = e.response.data.message;
    } finally {
      loadingStore.loading = false;
      token.value = false;
      localStorage.removeItem("token");
    }
  };

  return { token, register, login, logout, errorMessage };
});
