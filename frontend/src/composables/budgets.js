import {computed, ref} from "vue";
import {useLoadingStore} from "@/stores/loading.js";
import axios from "axios";
import {hexToRgb} from "@/service/helpers.js";

export const useBudgets = () => {
    const loadingStore = useLoadingStore();
    const errorMessage = ref('');

    const list = ref([]);
    const limitSum = ref("0");
    const expensesSum = ref(0)

    const availableOptions = ref([]);
    const availableCategories = computed(() => {
        return availableOptions.value.categories ?? [];
    })
    const availableThemes = computed(() => {
        return availableOptions.value.themes ?? [];
    })
    const currentlyClickedBudgetToBeEditedOrDeleted = ref({
        limit: 0,
        category: {
            value: 0,
        },
        theme: {
            value: 0,
        }
    });

    const fetchBudgetData = async () => {
        try {
            loadingStore.loading = true;

            const response = await axios.get('api/V1/budgets');
            if (!response.data?.data) {
                list.value = [];
                return;
            }
            list.value = response.data.data.budgets;
            limitSum.value = response.data.data.limitSum ?? 0;
            expensesSum.value = response.data.data.expensesSum ?? 0;
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
            await fetchBudgetData();
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    const updateBudget = async (id, data) => {
        try {
            loadingStore.loading = true;

            await axios.put(`api/V1/budgets/${id}`, data);
            await fetchBudgetData();
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    const deleteBudget = async (id) => {
        try {
            await axios.delete(`api/V1/budgets/${id}`);
            await fetchBudgetData();
            await fetchAvailableOptions();
            loadingStore.loading = true;
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
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

        list.value.forEach((budget) => {
            array.push(parseFloat(budget.monthlySpendings));
        })

        return array;
    };

    const getHexColorThemes = () => {
        const array = [];
        list.value.forEach((budget) => {
            array.push(budget.theme?.color);
        });

        return array;
    }

    const getRGBColorThemes = () => {
        const array = [];
        list.value.forEach((budget) => {
            array.push(hexToRgb(budget.theme?.color, 0.75));
        });

        return array;
    }

    return {
        list,
        expensesSum,
        limitSum,
        fetchBudgetData,
        saveBudget,
        updateBudget,
        deleteBudget,
        fetchAvailableOptions,
        availableOptions,
        availableCategories,
        availableThemes,
        getRGBColorThemes,
        getHexColorThemes,
        getMonthlySpendings,
        currentlyClickedBudgetToBeEditedOrDeleted,
    }
}