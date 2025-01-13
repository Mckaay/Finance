import axios from 'axios';
import {ref} from 'vue';
import {useLoadingStore} from '@/stores/loading.js';
import router from "@/router/index.js";

export function useTransactions() {
    const transactionList = ref([]);
    const paginationMeta = ref({});
    const loadingStore = useLoadingStore();
    const errorMessage = ref('');

    const fetchTransactionData = async (
        page = 1,
        searchQuery = '',
        category = 0,
        order = 'latest'
    ) => {
        try {
            loadingStore.loading = true;
            const response = await axios.get(`/api/V1/transactions?page=${page}&name=${searchQuery}&categoryId=${category}&order=${order}`);
            if (!response.data?.data) {
                transactionList.value = [];
                paginationMeta.value = {};
                return;
            }

            transactionList.value = response.data.data;
            paginationMeta.value = response.data.meta;
            errorMessage.value = "";
        } catch (e) {
            console.error('Error fetching transactions data:', e);
            errorMessage.value = e.response.data.message;
        } finally {
            loadingStore.loading = false;
        }
    };

    const saveTransaction = async (data
    ) => {
        try {
            loadingStore.loading = true;
            await axios.post('/api/V1/transactions', data)
        } catch (e) {
            console.log(e);
        } finally {
            loadingStore.loading = false;
        }
    }

    return {
        transactionList,
        paginationMeta,
        fetchTransactionData,
        saveTransaction,
        errorMessage,
    };
}
