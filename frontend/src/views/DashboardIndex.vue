<script setup>
import { useDashboard } from "@/composables/dashboard.js";
import { onBeforeMount } from "vue";
import AmountCard from "@/components/shared/cards/AmountCard.vue";
import AppNavigation from "@/components/features/navigation/AppNavigation.vue";
import TransactionSummaryList from "@/components/features/transactions/TransactionSummaryList.vue";
import { useBudgets } from "@/composables/budgets.js";
import BudgetSummaryListWithChart from "@/components/features/budgets/BudgetSummaryListWithChart.vue";
import TextAndLinkHeader from "@/components/shared/text/TextAndLinkHeader.vue";
import PotSummary from "@/components/features/pots/PotSummary.vue";
import DoughnutChart from "@/components/shared/charts/DoughnutChart.vue";

const dashboardService = useDashboard();
const budgetService = useBudgets();

onBeforeMount(async () => {
  await dashboardService.fetchData();
  await budgetService.fetchBudgetData();
});
</script>

<template>
  <AppNavigation />
  <main>
    <h1>Overview</h1>
    <section class="balance-section">
      <AmountCard
        text="Current Balance"
        :amount="dashboardService.state.value.balance"
      />
      <AmountCard
        text="Income"
        background-color="#FFF"
        header-text-color="#696868"
        text-color="#201F24"
        :amount="dashboardService.state.value.incomeSum"
      />
      <AmountCard
        text="Expenses"
        background-color="#FFF"
        header-text-color="#696868"
        text-color="#201F24"
        :amount="Math.abs(dashboardService.state.value.expenseSum).toString()"
      />
    </section>
    <div class="flex-wrapper">
      <div class="left-side-wrapper">
        <PotSummary
          class="pot-section"
          :pots="dashboardService.state.value.pots"
        />
        <section class="transactions-section">
          <TextAndLinkHeader
            text="Transactions"
            route-name="transactions"
            link-text="View All"
          />
          <TransactionSummaryList
            :transactions="dashboardService.state.value.transactions"
          />
        </section>
      </div>
      <div class="right-side-wrapper">
        <section class="budgets-section">
          <TextAndLinkHeader
            class="budget-link"
            text="Budgets"
            link-text="See Details"
            route-name="budgets"
          />
          <div class="wrapper">
            <BudgetSummaryListWithChart summary-list-text="">
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
        </section>
      </div>
    </div>
  </main>
</template>

<style scoped>
main {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-200);
}

.flex-wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-150);

  @media screen and (min-width: 1300px) {
    flex-direction: row;
  }
}

.balance-section {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-75);

  @media screen and (min-width: 768px) {
    flex-direction: row;
    justify-content: stretch;
    gap: var(--spacing-150);
  }
}

.transactions-section {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-200);
  padding: var(--spacing-150) var(--spacing-125);
  border-radius: var(--spacing-75);
  background-color: white;

  @media screen and (min-width: 768px) {
    padding: var(--spacing-200) var(--spacing-200);
  }
}

.budgets-section {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-100);
  background-color: var(--clr-white);
  padding: var(--spacing-150) var(--spacing-125);
  border-radius: var(--spacing-75);

  @media screen and (min-width: 768px) {
    padding: var(--spacing-200) var(--spacing-200);
  }
}

.wrapper {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: var(--spacing-250);

  @media screen and (min-width: 768px) {
    flex-direction: row;
  }

  @media screen and (min-width: 1300px) {
    flex-direction: row;
    min-width: 500px;
    height: fit-content;
  }
}

.left-side-wrapper {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-150);

  @media screen and (min-width: 1300px) {
    width: 100%;
  }
}

.right-side-wrapper {
  @media screen and (min-width: 1300px) {
    width: 80%;
  }
}
</style>
