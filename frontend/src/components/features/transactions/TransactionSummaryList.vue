<script setup>
import TransactionSummaryListItem from "@/components/features/transactions/TransactionSummaryListItem.vue";
import TextAndLinkHeader from "@/components/shared/text/TextAndLinkHeader.vue";

const props = defineProps({
  transactions: {
    type: Array,
    default: () => [],
  },
});
</script>

<template>
  <slot />
  <ul class="transaction-list">
    <TransactionSummaryListItem
      v-for="transaction in props.transactions"
      :key="transaction.id"
      :transaction="transaction"
    />
  </ul>
</template>

<style scoped>
.transaction-list {
  list-style: none;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: var(--spacing-75);
  overflow-x: auto;
}
</style>
