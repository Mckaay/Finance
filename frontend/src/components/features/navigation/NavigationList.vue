<script setup>
import ReceiptIcon from "@/components/shared/icons/ReceiptIcon.vue";
import ChartDonutIcon from "@/components/shared/icons/ChartDonutIcon.vue";
import HouseIcon from "@/components/shared/icons/HouseIcon.vue";
import JarFillIcon from "@/components/shared/icons/JarFillIcon.vue";
import ArrowsDownUpIcon from "@/components/shared/icons/ArrowsDownUpIcon.vue";
import NavigationListItem from "@/components/features/navigation/NavigationListItem.vue";
</script>

<template>
  <ul>
    <NavigationListItem
      text="Overview"
      route-name="dashboard"
    >
      <HouseIcon />
    </NavigationListItem>
    <NavigationListItem
      text="Transactions"
      route-name="transactions"
    >
      <ArrowsDownUpIcon />
    </NavigationListItem>
    <NavigationListItem
      text="Budgets"
      route-name="budgets"
    >
      <ChartDonutIcon />
    </NavigationListItem>
    <NavigationListItem
      text="Pots"
      route-name="pots"
    >
      <JarFillIcon />
    </NavigationListItem>
    <NavigationListItem
      class="disabled"
      text="Recurring bills"
      route-name="recurring"
    >
      <ReceiptIcon />
    </NavigationListItem>
  </ul>
</template>

<style scoped>
ul {
  display: flex;
  align-items: center;
  justify-content: space-between;
  list-style: none;
  padding: 0;

  @media screen and (min-width: 768px) {
    max-width: 800px;
    margin: auto;
  }

  @media screen and (min-width: 1280px) {
    max-width: unset;
    flex-direction: column;
    align-items: flex-start;
    gap: var(--spacing-25);
    padding-right: var(--spacing-150);
    margin: unset;
  }

  .disabled {
    opacity: 0.5;
    pointer-events: none;
    cursor: not-allowed;
  }
}
</style>
