import axios from 'axios';
import {reactive, ref, watch} from 'vue';
import {useLoadingStore} from '@/stores/loading.js';

const state = reactive({
    list: [],
    pagination: {
        last_page: 1
    },
    filters: {
        currentPage: 1,
        searchQuery: "",
        categorySelected: 0,
        orderSelected: 'latest',
    }
});

watch(
    () => [
        state.filters.currentPage,
        state.filters.searchQuery,
        state.filters.orderSelected,
        state.filters.categorySelected
    ],
    async function () {
        await useTransactions().fetchTransactions();
    },
);

export function useTransactions() {
    const loadingStore = useLoadingStore();
    const errorMessage = ref('');

    const fetchTransactions = async () => {
        try {
            loadingStore.loading = true;
            const response = await axios.get('/api/V1/transactions', {
                params: {
                    page: state.filters.currentPage,
                    name: state.filters.searchQuery,
                    categoryId: state.filters.categorySelected,
                    order: state.filters.orderSelected
                }
            });

            state.list = response.data?.data || [];
            state.pagination = response.data?.meta || {last_page: 1};
            errorMessage.value = "";
        } catch (e) {
            console.error('Error fetching transactions:', e);
            errorMessage.value = e.response?.data?.message || 'Failed to fetch transactions';
        } finally {
            loadingStore.loading = false;
        }
    };

    const createTransaction = async (data) => {
        try {
            loadingStore.loading = true;
            await axios.post('/api/V1/transactions', data);
            await fetchTransactions();
            errorMessage.value = "";
        } catch (e) {
            errorMessage.value = e.response?.data?.message || 'Failed to create transaction';
        } finally {
            loadingStore.loading = false;
        }
    };

    const updateFilter = (key, value) => {
        if (key !== 'currentPage') state.filters.currentPage = 1;
        state.filters[key] = value;
    };

    return {
        state,
        errorMessage,
        fetchTransactions,
        createTransaction,
        updateFilter
    };
}