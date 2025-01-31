<script setup>
import {inject} from "vue";
import DoughnutChart from "@/components/shared/charts/DoughnutChart.vue";
import BudgetSummaryListItem from "@/components/features/budgets/BudgetSummaryListItem.vue";

const budgetService = inject('budgetService');

const props = defineProps({
  summaryListText: {
    type: String,
    default: "Spending Summary"
  },
})
</script>

<template>
  <DoughnutChart :budgets="budgetService.list.value"
                 :data="budgetService.getMonthlySpendings()"
                 :hexColors="budgetService.getHexColorThemes()"
                 :rgbColors="budgetService.getRGBColorThemes()"
                 :limitSum="budgetService.limitSum.value"
                 :expensesSum="budgetService.expensesSum.value"
  >
  </DoughnutChart>
  <BudgetSummaryListItem :budgets="budgetService.list.value">
    <slot><h2 v-if="props.summaryListText !== ''">{{ summaryListText }}</h2></slot>
  </BudgetSummaryListItem>
</template>

<style scoped>
h2 {
  color: var(--clr-grey-900);
}
</style>