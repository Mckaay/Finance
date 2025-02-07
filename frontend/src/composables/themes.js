import axios from "axios";
import { ref } from "vue";
import { useLoadingStore } from "@/stores/loading.js";

export function useThemes() {
  const themesList = ref([]);
  const loadingStore = useLoadingStore();

  const fetchThemesData = async () => {
    try {
      loadingStore.loading = true;

      const response = await axios.get("api/V1/themes");
      if (!response.data?.data) {
        themesList.value = [];
        return;
      }

      themesList.value = response.data.data;
    } catch (error) {
      console.error("Error fetching categories data:", error);
    } finally {
      loadingStore.loading = false;
    }
  };

  return {
    themesList,
    fetchThemesData,
  };
}
