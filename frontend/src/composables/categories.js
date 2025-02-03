import axios from 'axios';
import {reactive, ref} from 'vue';
import {useLoadingStore} from '@/stores/loading.js';


const state = reactive({
    list: [],
});

export function useCategories() {
    const loadingStore = useLoadingStore();

    const fetchCategoriesData = async () => {
        try {
            loadingStore.loading = true;

            const response = await axios.get('api/V1/categories');
            if (!response.data?.data) {
                state.list.value = [];
                return;
            }

            state.list = response.data.data;
        } catch (error) {
            console.error('Error fetching categories data:', error);
        } finally {
            loadingStore.loading = false;
        }
    };

    return {
        state,
        fetchCategoriesData,
    };
}
