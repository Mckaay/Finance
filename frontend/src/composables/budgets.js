import { computed, reactive, ref } from "vue";
import { useLoadingStore } from "@/stores/loading.js";
import axios from "axios";
import { hexToRgb } from "@/service/helpers.js";

const state = reactive({
  limitSum: 0,
  expenseSum: 0,
  list: [],
  availableCategories: [],
  availableThemes: [],
  selectedForEditOrDelete: {
    id: 0,
    limit: 0,
    category: {
      value: 0,
    },
    theme: {
      value: 0,
    },
  },
});

export const useBudgets = () => {
  const loadingStore = useLoadingStore();
  const errorMessage = ref("");

  const fetchBudgetData = async () => {
    try {
      loadingStore.loading = true;

      const response = await axios.get("api/V1/budgets");
      if (!response.data?.data) {
        state.list = [];
        return;
      }
      state.list = response.data.data.budgets;
      state.limitSum = response.data.data.limitSum ?? 0;
      state.expenseSum = response.data.data.expensesSum ?? 0;
      errorMessage.value = "";
    } catch (e) {
      console.log(e);
      e.response.data.message = errorMessage.value;
    } finally {
      loadingStore.loading = false;
    }
  };

  const saveBudget = async (data) => {
    try {
      loadingStore.loading = true;

      await axios.post("api/V1/budgets", data);
      await fetchBudgetData();
      await fetchAvailableOptions();
      errorMessage.value = "";
    } catch (e) {
      console.log(e);
      e.response.data.message = errorMessage.value;
    } finally {
      loadingStore.loading = false;
    }
  };

  const updateBudget = async (id, data) => {
    try {
      loadingStore.loading = true;

      await axios.put(`api/V1/budgets/${id}`, data);
      await fetchBudgetData();
      await fetchAvailableOptions();
      errorMessage.value = "";
    } catch (e) {
      console.log(e);
      e.response.data.message = errorMessage.value;
    } finally {
      loadingStore.loading = false;
    }
  };

  const deleteBudget = async (id) => {
    try {
      await axios.delete(`api/V1/budgets/${id}`);
      await fetchBudgetData();
      await fetchAvailableOptions();
      loadingStore.loading = true;
      errorMessage.value = "";
    } catch (e) {
      console.log(e);
      e.response.data.message = errorMessage.value;
    } finally {
      loadingStore.loading = false;
    }
  };

  const fetchAvailableOptions = async () => {
    try {
      loadingStore.loading = true;

      const response = await axios.get("api/V1/budgets/options");
      if (!response.data?.data) {
        state.availableThemes = [];
        state.availableCategories = [];
        return;
      }

      state.availableCategories = response.data.data.categories;
      state.availableThemes = response.data.data.themes;
      errorMessage.value = "";
    } catch (e) {
      console.log(e);
      e.response.data.message = errorMessage.value;
    } finally {
      loadingStore.loading = false;
    }
  };

  const getMonthlySpendings = () => {
    const array = [];

    state.list.forEach((budget) => {
      array.push(parseFloat(budget.monthlySpendings));
    });

    return array;
  };

  const getHexColorThemes = () => {
    const array = [];
    state.list.forEach((budget) => {
      array.push(budget.theme?.color);
    });

    return array;
  };

  const getRGBColorThemes = () => {
    const array = [];
    state.list.forEach((budget) => {
      array.push(hexToRgb(budget.theme?.color, 0.75));
    });

    return array;
  };

  return {
    state,
    fetchBudgetData,
    saveBudget,
    updateBudget,
    deleteBudget,
    fetchAvailableOptions,
    getRGBColorThemes,
    getHexColorThemes,
    getMonthlySpendings,
  };
};
