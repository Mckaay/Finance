import { ref } from "vue";
import { defineStore } from "pinia";

export const useNavigationStore = defineStore("menu", () => {
  const narrow = ref(false);

  return { narrow };
});
