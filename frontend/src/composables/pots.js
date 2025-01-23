import {ref} from "vue";
import {useLoadingStore} from "@/stores/loading.js";
import axios from "axios";

export const usePots = () => {
    const potsList = ref([]);
    const availableThemes = ref([]);
    const loadingStore = useLoadingStore();
    const errorMessage = ref('');

    const fetchPotsData = async () => {
        try {
            loadingStore.loading = true;

            const response = await axios.get('api/V1/pots');
            if (!response.data?.data) {
                potsList.value = [];
                return;
            }

            potsList.value = response.data.data;
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    const savePot = async (data) => {
        try {
            loadingStore.loading = true;

            await axios.post('api/V1/pots', data);
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    const updatePot = async (id, data) => {
        try {
            loadingStore.loading = true;

            await axios.put(`api/V1/pots/${id}`, data);
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    const deletePot = async (id) => {
        try {
            loadingStore.loading = true;
            await axios.delete(`api/V1/pots/${id}`);
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    const fetchAvailableThemes = async () => {
        try {
            loadingStore.loading = true;

            const response = await axios.get('api/V1/pots/options');
            if (!response.data?.data) {
                availableThemes.value = [];
                return;
            }

            availableThemes.value = response.data.data;
            errorMessage.value = '';
        } catch (e) {
            console.log(e);
            e.response.data.message = errorMessage.value;
        } finally {
            loadingStore.loading = false;
        }
    }

    return {
        potsList,
        availableThemes,
        errorMessage,
        fetchPotsData,
        savePot,
        updatePot,
        deletePot,
        fetchAvailableThemes
    }
}