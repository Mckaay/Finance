<script setup>
const props = defineProps({
  budgets: {
    type: Array,
    default: [],
  }
})
</script>

<template>
  <section class="summary">
    <slot></slot>
    <div class="summary-items-wrapper">
      <div class="summary-item" v-for="budget in budgets">
        <div class="name" :style="{ '--background-color': budget?.theme.color }">{{ budget?.category?.label }}</div>
        <div class="cost-wrapper">
          <div class="spent">${{ Math.abs(budget.monthlySpendings) }}</div>
          <div class="limit">of ${{ Math.abs(budget.limit) }}</div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.summary {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: var(--spacing-150);
  width: 100%;

  & h2 {
    color: var(--clr-grey-900);
  }

  & .summary-items-wrapper {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-100);
  }

  & .summary-item {
    display: grid;
    align-items: center;
    grid-template-columns: repeat(5, 1fr);

    & .name {
      display: flex;
      align-items: center;
      height: 100%;
      gap: var(--spacing-100);
      font-size: var(--fs-87);
      color: var(--clr-grey-500);
      grid-column: 1 / span 2;
    }

    & .name::before {
      display: block;
      content: "";
      align-self: stretch;
      min-width: 4px;
      background-color: var(--background-color);
      border-radius: var(--spacing-50);
    }

    & .cost-wrapper {
      display: flex;
      align-items: center;
      gap: var(--spacing-50);
      justify-self: end;
      grid-column: 3 / -1;
    }

    & .spent {
      font-size: var(--fs-100);
      color: var(--clr-grey-900);
      font-weight: var(--fw-700);
    }

    & .limit {
      font-size: var(--fs-75);
      color: var(--clr-grey-500);
    }
  }

  & .summary-item:not(:last-child)::after {
    content: "";
    display: block;
    height: 1px;
    background-color: var(--clr-grey-100);
    grid-column: 1 / -1;
    margin-top: var(--spacing-100);
  }
}
</style>