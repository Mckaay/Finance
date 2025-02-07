<script setup>
import { onMounted, provide, ref, useTemplateRef } from "vue";
import { useBudgets } from "@/composables/budgets.js";
import BudgetList from "@/components/features/budgets/BudgetList.vue";
import BaseButton from "@/components/shared/buttons/BaseButton.vue";
import AppNavigation from "@/components/features/navigation/AppNavigation.vue";
import BudgetSummaryListWithChart from "@/components/features/budgets/BudgetSummaryListWithChart.vue";
import BaseModal from "@/components/shared/modals/BaseModal.vue";
import AddBudgetForm from "@/components/features/budgets/AddBudgetForm.vue";
import DoughnutChart from "@/components/shared/charts/DoughnutChart.vue";
import EditBudgetForm from "@/components/features/budgets/EditBudgetForm.vue";
import DeleteBudgetForm from "@/components/features/budgets/DeleteBudgetForm.vue";

const addBudgetModal = ref(null);
const editBudgetModal = ref(null);
const deleteBudgetModal = ref(null);
const budgetService = useBudgets();

onMounted(async () => {
  if (budgetService.state.list.length > 0) {
    return;
  }

  await budgetService.fetchBudgetData();
  await budgetService.fetchAvailableOptions();
});
</script>

<template>
  <AppNavigation />
  <main>
    <header class="model-header">
      <h1>Budgets</h1>
      <BaseButton text="+ Add New Budget" @click="addBudgetModal.openModal()" />
      <BaseModal
        ref="addBudgetModal"
        header-text="Add New Budget"
        description-text="Choose a category to set a spending budget. These categories can help you monitor spending."
      >
        <AddBudgetForm @budget-created="addBudgetModal?.close()" />
      </BaseModal>
      <BaseModal
        ref="editBudgetModal"
        header-text="Edit Budget"
        description-text="As your budgets change, feel free to update your spending limits."
      >
        <EditBudgetForm
          :budget="budgetService.state.selectedForEditOrDelete"
          :available-themes="budgetService.state.availableThemes"
          :available-categories="budgetService.state.availableCategories"
          @budget-updated="editBudgetModal.close()"
        />
      </BaseModal>
      <BaseModal
        ref="deleteBudgetModal"
        :header-text="`Delete ${budgetService.state.selectedForEditOrDelete.category.label}`"
        description-text="Are you sure you want to delete this budget? This action cannot be reversed, and all the data inside it will be removed forever."
      >
        <DeleteBudgetForm
          :id="budgetService.state.selectedForEditOrDelete.id ?? 0"
          @budget-deleted="deleteBudgetModal.close()"
        />
      </BaseModal>
    </header>
    <section class="budget-content">
      <div class="summary-list-chart-wrapper">
        <BudgetSummaryListWithChart>
          <template #chart>
            <DoughnutChart
              :budgets="budgetService.state.list"
              :data="budgetService.getMonthlySpendings()"
              :hex-colors="budgetService.getHexColorThemes()"
              :rgb-colors="budgetService.getRGBColorThemes()"
              :limit-sum="budgetService.state.limitSum"
              :expenses-sum="budgetService.state.expenseSum"
            />
          </template>
        </BudgetSummaryListWithChart>
      </div>
      <BudgetList
        :budgets="budgetService.state.list"
        @open-edit-modal="editBudgetModal.openModal()"
        @open-delete-modal="deleteBudgetModal.openModal()"
      />
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
