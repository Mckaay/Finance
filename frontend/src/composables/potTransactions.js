import {ref} from "vue";
import {useLoadingStore} from "@/stores/loading.js";
import axios from "axios";

export const usePotTransactions = () => {
    const loadingStore = useLoadingStore();
    const errorMessage = ref('');

    const savePotTransactions = async (data) => {
        try {
            console.log(data);
            loadingStore.loading = true;
            console.log('Im herexd');
            await axios.post('api/V1/pottransactions', data);
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }


    return {
        savePotTransactions,
    }
}