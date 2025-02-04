import {reactive, ref} from "vue";
import {useLoadingStore} from "@/stores/loading.js";
import axios from "axios";

const state = reactive({
    list: [],
    availableThemes: [],
    selectedForEditOrDelete: {
        id: 0,
        name: "",
        target: 0,
        theme_id: 0,
    }
})

export const usePots = () => {
    const loadingStore = useLoadingStore();
    const errorMessage = ref('');

    const fetchPotsData = async () => {
        try {
            loadingStore.loading = true;

            const response = await axios.get('api/V1/pots');
            if (!response.data?.data) {
                state.list = [];
                return;
            }

            state.list = response.data.data;
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
            await fetchPotsData();
            await fetchAvailableThemes();
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
            await fetchPotsData();
            await fetchAvailableThemes();
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
                state.availableThemes = [];
                return;
            }

            state.availableThemes = response.data.data;
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
        errorMessage,
        fetchPotsData,
        savePot,
        updatePot,
        deletePot,
        fetchAvailableThemes
    }
}