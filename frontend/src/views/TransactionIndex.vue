<script setup>
import {onMounted, provide, ref} from "vue";
import { useCategories } from "@/composables/categories.js";
import { useTransactions } from "@/composables/transactions.js";
import Navigation from "@/components/features/navigation/Navigation.vue";
import AddTransactionModal from "@/components/features/transactions/AddTransactionModal.vue";
import TransactionList from "@/components/features/transactions/TransactionList.vue";
import TransactionListFilters from "@/components/features/transactions/TransactionListFilters.vue";
import Pagination from "@/components/shared/pagination/Pagination.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import Spinner from "@/components/shared/buttons/Spinner.vue";

const categoriesService = useCategories();
const transactionsService = useTransactions();
const addTransactionModalRef = ref(null);

onMounted(async () => {
  await Promise.all([
    categoriesService.fetchCategoriesData(),
    transactionsService.fetchTransactions()
  ]);
});

provide('transactions', transactionsService);
provide('categories', categoriesService);
</script>

<template>
  <Navigation />
  <main>
    <header class="model-header">
      <h1>Transactions</h1>
      <BaseButton
          @click="addTransactionModalRef?.openModal()"
          text="+ Add New Transaction"
      />
    </header>

    <AddTransactionModal
        ref="addTransactionModalRef"
        @transaction-created="transactionsService.createTransaction"
    />
    <Suspense>
      <section class="transactions-section">
        <TransactionListFilters />
        <TransactionList :transactions="transactionsService.state.list" />
        <Pagination
            :current-page="transactionsService.state.filters.currentPage"
            :last-page="transactionsService.state.pagination.last_page"
            @update:current-page="transactionsService.updateFilter('currentPage', $event)"
        />
      </section>
      <template #fallback>
        <Spinner class="loading" />
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

.transactions-section {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-150);
  padding: var(--spacing-150) var(--spacing-125);
  background-color: var(--clr-white);
  border-radius: var(--spacing-75);

  @media screen and (min-width: 768px) {
    padding: var(--spacing-200) var(--spacing-200);
  }
}
</style>