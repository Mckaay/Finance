<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Doughnut } from "vue-chartjs";
import { computed } from "vue";

ChartJS.register(ArcElement, Tooltip, Legend);

defineProps({
  budgets: {
    type: Array,
    default: () => [],
  },
  data: {
    type: Array,
    default: () => [],
  },
  hexColors: {
    type: Array,
    default: () => [],
  },
  rgbColors: {
    type: Array,
    default: () => [],
  },
  limitSum: {
    type: [Number, String],
    default: "0",
  },
  expensesSum: {
    type: Number,
    default: () => 0,
  },
});

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
      },
    ],
  };
});

const chartOptions = {
  borderWidth: 0,
  cutout: "60%",
};
</script>

<template>
  <header>
    <section class="chart-section">
      <div class="summary-chart">
        <p class="spent">${{ Math.abs(expensesSum) }}</p>
        <p class="limit">of ${{ limitSum }} limit</p>
      </div>
      <Doughnut :data="chartData" :options="chartOptions" />
    </section>
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
    grid-template-columns: 1fr;
  }

  @media screen and (min-width: 1280px) {
    display: grid;
    grid-template-columns: 1fr;
  }
}

.chart-section {
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
