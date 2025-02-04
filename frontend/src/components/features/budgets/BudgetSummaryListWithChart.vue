<script setup>
import {inject} from "vue";
import DoughnutChart from "@/components/shared/charts/DoughnutChart.vue";
import BudgetSummaryListItem from "@/components/features/budgets/BudgetSummaryListItem.vue";
import {useBudgets} from "@/composables/budgets.js";

const budgetService = useBudgets()

const props = defineProps({
  summaryListText: {
    type: String,
    default: "Spending Summary"
  },
})
</script>

<template>
  <slot name="chart"></slot>
  <BudgetSummaryListItem :budgets="budgetService.state.list">
    <slot><h2 v-if="props.summaryListText !== ''">{{ summaryListText }}</h2></slot>
  </BudgetSummaryListItem>
</template>

<style scoped>
h2 {
  color: var(--clr-grey-900);
}
</style>