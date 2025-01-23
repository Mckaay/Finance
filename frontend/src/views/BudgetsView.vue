<script setup>
import Menu from "@/components/menu/Menu.vue";
import Button from "@/components/buttons/Button.vue";
import {onMounted, useTemplateRef} from "vue";
import {useBudgets} from "@/composables/budgets.js";
import AddBudgetModal from "@/components/modals/budgets/AddBudgetModal.vue";
import BudgetItem from "@/components/models/budgets/BudgetItem.vue";
import DoughnutChart from "@/components/charts/DoughnutChart.vue";
import DeleteBudgetModal from "@/components/modals/budgets/DeleteBudgetModal.vue";
import BudgetList from "@/components/models/budgets/BudgetList.vue";

const addBudgetModalRef = useTemplateRef('modal');
const budgetService = useBudgets();

onMounted(async () => {
  await budgetService.fetchBudgetData();
})
</script>

<template>
  <Menu/>
  <main>
    <header class="model-header">
      <h1>Budgets</h1>
      <Button @click="addBudgetModalRef.openModal()" class="button-primary" text="+ Add New Budget"/>
      <AddBudgetModal ref="modal"/>
    </header>
    <div class="budget-list-wrapper">
      <div class="chart-section">
        <DoughnutChart :budgets="budgetService.budgetsList.value"
                       :data="budgetService.getMonthlySpendings()"
                       :hexColors="budgetService.getHexColorThemes()"
                       :rgbColors="budgetService.getRGBColorThemes()"
        />
      </div>
      <BudgetList :budgets="budgetService.budgetsList.value"/>
    </div>
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

.budget-list-wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-150);

  @media screen and (min-width: 1280px) {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
  }

  & .chart-section {
    display: flex;
    justify-content: center;
    background-color: var(--clr-white);
    padding: var(--spacing-150) var(--spacing-125);
    border-radius: var(--spacing-75);

    @media screen and (min-width: 1280px) {
      min-width: 500px;
      height: fit-content;
      padding: var(--spacing-200) var(--spacing-200);
    }
  }
}
</style>