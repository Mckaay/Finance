<script setup>
import Menu from "@/components/menu/Menu.vue";
import TransactionsList from "@/components/models/transactions/TransactionsList.vue";
import Loader from "@/components/buttons/Loader.vue";
import Button from "@/components/buttons/Button.vue";
import {onMounted, provide, reactive, ref, useTemplateRef, watch} from "vue";
import {useCategories} from "@/composables/categories.js";
import AddTransactionModal from "@/components/modals/AddTransactionModal.vue";
import {useTransactions} from "@/composables/transactions.js";
import {useLoadingStore} from "@/stores/loading.js";

const loadingStore = useLoadingStore();
const categoriesService = useCategories();
const transactionsService = useTransactions()

onMounted(async () => {
  await categoriesService.fetchCategoriesData();
  await transactionsService.fetchTransactionData();
})

const filterParams = reactive({
  currentPage: 1,
  searchQuery: "",
  categorySelected: 0,
  orderSelected: 'latest',
})

provide("filters", filterParams)

watch([filterParams], async () => {
  if (loadingStore.loading) return;
  await transactionsService.fetchTransactionData(
      filterParams.currentPage,
      filterParams.searchQuery,
      filterParams.categorySelected,
      filterParams.orderSelected
  );
});

const addTransactionModalRef = useTemplateRef('modal');
const refetchTransactionData = async () => {
  await transactionsService.fetchTransactionData();
}
</script>

<template>
  <Menu/>
  <main>
    <header class="model-header">
      <h1>Transactions</h1>
      <Button @click="addTransactionModalRef.openModal();" class="button-primary" text="+ Add New Transaction"/>
    </header>
    <AddTransactionModal @transactionCreated="refetchTransactionData" ref="modal" :categories="categoriesService.categoriesList.value" />
    <Suspense>
      <TransactionsList
          :transactions="transactionsService.transactionList.value"
          :categories="categoriesService.categoriesList.value"
          :pagination="transactionsService.paginationMeta.value"
      />
      <template #fallback>
        <Loader class="loading"/>
      </template>
    </Suspense>
  </main>
</template>

<style scoped>
main {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-200);
}

.loading.loader {
  height: 100px;
  width: 100px;
  margin: auto;
  border-top: 8px solid var(--clr-grey-900);
}

.model-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>