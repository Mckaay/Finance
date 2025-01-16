import {computed, ref} from "vue";
import {useLoadingStore} from "@/stores/loading.js";
import axios from "axios";
import {hexToRgb} from "@/service/helpers.js";

export const useBudgets = () => {
    const budgetsList = ref([]);
    const availableOptions = ref([]);
    const loadingStore = useLoadingStore();
    const errorMessage = ref('');

    const fetchBudgetData = async () => {
        try {
            loadingStore.loading = true;

            const response = await axios.get('api/V1/budgets');
            if (!response.data?.data) {
                budgetsList.value = [];
                return;
            }

            budgetsList.value = response.data.data;
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    const saveBudget = async (data) => {
        try {
            loadingStore.loading = true;

            await axios.post('api/V1/budgets', data);
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    const updateBudgetData = async (id, updateData) => {
    }

    const deleteBudgetData = async () => {

    }

    const fetchAvailableOptions = async () => {
        try {
            loadingStore.loading = true;

            const response = await axios.get('api/V1/budgets/options');
            if (!response.data?.data) {
                availableOptions.value = [];
                return;
            }

            availableOptions.value = response.data.data;
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    const getMonthlySpendings = () => {
        const array = [];

        budgetsList.value.forEach((budget) => {
            array.push(parseFloat(budget.monthlySpendings));
        })

        return array;
    };

    const getHexColorThemes = () => {
        const array = [];
        budgetsList.value.forEach((budget) => {
            array.push(budget.theme?.color);
        });

        return array;
    }

    const getRGBColorThemes = () => {
        const array = [];
        budgetsList.value.forEach((budget) => {
            array.push(hexToRgb(budget.theme?.color, 0.75));
        });

        return array;
    }

    return {
        budgetsList,
        fetchBudgetData,
        saveBudget,
        updateBudgetData,
        deleteBudgetData,
        fetchAvailableOptions,
        availableOptions,
        getRGBColorThemes,
        getHexColorThemes,
        getMonthlySpendings,
    }
}