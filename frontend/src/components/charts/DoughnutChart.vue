<script setup>
import {Chart as ChartJS, ArcElement, Tooltip, Legend} from "chart.js";
import {Doughnut} from 'vue-chartjs'
import {computed, onMounted, reactive, ref} from "vue";
import BudgetSummaryItem from "@/components/models/budgets/BudgetSummaryItem.vue";

ChartJS.register(ArcElement, Tooltip, Legend)

const props = defineProps({
  budgets: {
    type: Array,
    default: [],
  },
  data: {
    type: Array,
    default: [],
  },
  hexColors: {
    type: Array,
    default: [],
  },
  rgbColors: {
    type: Array,
    default: [],
  },
})

const chartData = computed(() => {
  return {
    datasets: [
      {
        data: props.data,
        backgroundColor: props.hexColors,
      },
      {
        data: props.data,
        backgroundColor: props.rgbColors,
      }
    ],
  };
});

const chartOptions = {
  borderWidth: 0,
  cutout: "60%"
};

const limitSum = computed(() => {
  if (props.budgets.length === 0) {
    return 0;
  }

  let sum = 0;
  return props.budgets?.reduce((sum, budget) => {
    return sum + Math.abs(budget.limit);
  },sum)
});

const spendSum = computed(() => {
  if (props.budgets.length === 0) {
    return 0;
  }

  let sum = 0;
  return props.budgets?.reduce((sum, budget) => {
    return sum + Math.abs(budget.monthlySpendings);
  },sum)
});
</script>


<template>
  <header>
    <section class="chart-wrapper">
      <div class="summary-chart">
        <p class="spent">
          ${{ parseInt(spendSum) }}
        </p>
        <p class="limit">
          of ${{ limitSum }} limit
        </p>
      </div>
      <Doughnut :data="chartData" :options="chartOptions"></Doughnut>
    </section>
    <BudgetSummaryItem/>
  </header>
</template>
<style scoped>
header {
  display: flex;
  width: 100%;
  flex-direction: column;
  justify-content: center;
  gap: var(--spacing-200);

  @media screen and (min-width: 600px) {
    display: grid;
    grid-template-columns: 1fr 1fr;
  }

  @media screen and (min-width: 1280px) {
    display: grid;
    grid-template-columns: 1fr;
  }
}

.chart-wrapper {
  position: relative;
  max-width: 240px;
  display: flex;
  margin: auto;

  @media screen and (min-width: 600px) {
    min-width: 240px;
  }

  & .summary-chart {
    position: absolute;
    margin: auto;
    right: 50%;
    top: 50%;
    transform: translateX(50%) translateY(-40%);
    display: flex;
    flex-direction: column;
    gap: var(--spacing-50);
    text-align: center;

    & .spent {
      color: var(--clr-grey-900);
      font-weight: var(--fw-700);
      font-size: var(--fs-150);
    }

    & .limit {
      font-size: var(--fs-75);
      color: var(--clr-grey-500);
    }
  }
}
</style>