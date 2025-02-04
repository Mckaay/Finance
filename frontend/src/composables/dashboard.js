import {reactive, ref} from "vue";
import {useLoadingStore} from "@/stores/loading.js";
import axios from "axios";

const state = ref({
    balance: "0.00",
    incomeSum: "0.00",
    expenseSum: "0.00",
    transactions: [],
    pots: []
});

export const useDashboard = () => {
    const loadingStore = useLoadingStore();
    const errorMessage = ref('');

    const fetchData = async () => {
        try {
            loadingStore.loading = true;
            const response = await axios.get('api/V1/dashboard');
            state.value = response.data.data;
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    return {
        state,
        fetchData,
    }
}