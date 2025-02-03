<script setup>
import {onMounted, provide, ref, useTemplateRef} from "vue";
import {useBudgets} from "@/composables/budgets.js";
import BudgetList from "@/components/features/budgets/BudgetList.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import Navigation from "@/components/features/navigation/Navigation.vue";
import BudgetSummaryListWithChart from "@/components/features/budgets/BudgetSummaryListWithChart.vue";
import BaseModal from "@/components/shared/modals/BaseModal.vue";
import AddBudgetForm from "@/components/features/budgets/AddBudgetForm.vue";

const addBudgetModalRef = ref(null);
const budgetService = useBudgets();

onMounted(async () => {
  await budgetService.fetchBudgetData();
  await budgetService.fetchAvailableOptions();
})
</script>

<template>
  <Navigation/>
  <main>
    <header class="model-header">
      <h1>Budgets</h1>
      <BaseButton @click="addBudgetModalRef.openModal()" text="+ Add New Budget"/>
      <BaseModal
          ref="addBudgetModalRef"
          headerText="Add New Budget"
          descriptionText="Choose a category to set a spending budget. These categories can help you monitor spending."
      >
        <AddBudgetForm @budgetCreated="addBudgetModalRef?.close()"/>
      </BaseModal>
    </header>
    <section class="budget-content">
      <div class="summary-list-chart-wrapper">
        <BudgetSummaryListWithChart/>
      </div>
      <BudgetList :budgets="budgetService.state.list"/>
    </section>
  </main>
</template>

<style>
main {
  padding-bottom: var(--spacing-200);
}

.model-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: var(--spacing-200);
}

.budget-content {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-150);

  @media screen and (min-width: 1280px) {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
  }

  & .summary-list-chart-wrapper {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: var(--spacing-250);
    background-color: var(--clr-white);
    padding: var(--spacing-150) var(--spacing-125);
    border-radius: var(--spacing-75);

    @media screen and (min-width: 768px) {
      flex-direction: row;
      padding: var(--spacing-200) var(--spacing-200);
    }


    @media screen and (min-width: 1280px) {
      flex-direction: column;
      min-width: 500px;
      height: fit-content;
    }
  }
}
</style>