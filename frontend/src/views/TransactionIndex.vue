<script setup>
import { onMounted, ref } from "vue";
import { useCategories } from "@/composables/categories.js";
import { useTransactions } from "@/composables/transactions.js";
import AppNavigation from "@/components/features/navigation/AppNavigation.vue";
import TransactionList from "@/components/features/transactions/TransactionList.vue";
import TransactionListFilters from "@/components/features/transactions/TransactionListFilters.vue";
import BasePagination from "@/components/shared/pagination/BasePagination.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import BaseSpinner from "@/components/shared/buttons/BaseSpinner.vue";
import BaseModal from "@/components/shared/modals/BaseModal.vue";
import AddTransactionForm from "@/components/features/transactions/AddTransactionForm.vue";

const categoriesService = useCategories();
const transactionsService = useTransactions();
const addTransactionModalRef = ref(null);

onMounted(async () => {
  if (transactionsService.state.list.length > 0) {
    return;
  }

  await categoriesService.fetchCategoriesData();
  await transactionsService.fetchTransactions();
});
</script>

<template>
  <AppNavigation />
  <main>
    <header class="model-header">
      <h1>Transactions</h1>
      <BaseButton
        text="+ Add New Transaction"
        @click="addTransactionModalRef?.openModal()"
      />
    </header>
    <BaseModal
      ref="addTransactionModalRef"
      header-text="Add New Transaction"
      description-text="Create transactions to manage, control your spendings and incomes."
    >
      <AddTransactionForm
        @transaction-created="addTransactionModalRef?.close()"
      />
    </BaseModal>
    <Suspense>
      <section class="transactions-section">
        <TransactionListFilters />
        <TransactionList :transactions="transactionsService.state.list" />
        <BasePagination
          :current-page="transactionsService.state.filters.currentPage"
          :last-page="transactionsService.state.pagination.last_page"
          @update:current-page="
            transactionsService.updateFilter('currentPage', $event)
          "
        />
      </section>
      <template #fallback>
        <BaseSpinner class="loading" />
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
