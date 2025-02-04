import {reactive, ref} from "vue";
import {useLoadingStore} from "@/stores/loading.js";
import axios from "axios";
import {usePots} from "@/composables/pots.js";

const state = reactive({
    amount: 0,
})

export const usePotTransactions = () => {
    const loadingStore = useLoadingStore();
    const errorMessage = ref('');
    const potService = usePots();

    const savePotTransaction = async (data) => {
        try {
            loadingStore.loading = true;
            await axios.post('api/V1/pottransactions', data);
            await potService.fetchPotsData();
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
        savePotTransaction,
    }
}