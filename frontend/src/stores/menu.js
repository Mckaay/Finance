import { ref } from "vue";
import { defineStore } from "pinia";

export const useMenuStore = defineStore("menu", () => {
    const narrow = ref(false);

    return { narrow };
});