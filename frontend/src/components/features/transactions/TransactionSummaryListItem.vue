<script setup>
import {formatPrice} from "@/service/helpers.js";

const props = defineProps({
  transaction: {
    type: Object,
    default: {
      name: '',
      amount: "0",
      date: "2021-12-31",
    }
  },
});
</script>

<template>
  <li class="transaction-item">
    <div class="transaction-name">{{ transaction.name }}</div>
    <div class="transaction-amount"
         :class="{
      'positive': transaction.amount > 0
    }">
      {{ formatPrice(transaction.amount) }}
    </div>
    <div class="transaction-date">{{ transaction.date }}</div>
  </li>
</template>

<style scoped>
.transaction-item {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: repeat(2, 1fr);
  grid-row-gap: var(--spacing-25);
  font-size: var(--fs-87);
  color: var(--clr-grey-900);
  font-weight: var(--fw-400);
  align-items: center;

  & .transaction-name {
    font-weight: var(--fw-700);
    grid-column: 1 / span 2;
    grid-row: 1 / -1;
  }

  & .transaction-amount {
    font-weight: var(--fw-700);
    justify-self: flex-end;
  }

  & .transaction-amount.positive {
    color: var(--clr-green);
  }

  & .transaction-date {
    font-size: var(--fs-75);
    color: var(--clr-grey-500);
    justify-self: flex-end;
  }
}

.transaction-item:not(:last-child):after {
  content: '';
  height: 1px;
  width: 100%;
  background-color: var(--clr-grey-500);
  grid-column: 1 / -1;
  margin-top: calc(var(--spacing-100) - var(--spacing-25));
  opacity: 0.15;
}
</style>