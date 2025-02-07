<script setup>
import { computed, inject } from "vue";
import BaseSelect from "@/components/shared/forms/BaseSelect.vue";
import BaseField from "@/components/shared/forms/BaseField.vue";
import InputWithIcon from "@/components/shared/forms/InputWithIcon.vue";
import { useTransactions } from "@/composables/transactions.js";
import { useCategories } from "@/composables/categories.js";

const transactions = useTransactions();
const categories = useCategories();

const sortOptions = [
  { value: "latest", label: "Latest" },
  { value: "oldest", label: "Oldest" },
  { value: "atoz", label: "A to Z" },
  { value: "ztoa", label: "Z to A" },
  { value: "highest", label: "Highest" },
  { value: "lowest", label: "Lowest" },
];

const categoryOptions = computed(() => {
  return [
    {
      value: 0,
      label: "All Transactions",
    },
    ...categories.state.list,
  ];
});
</script>

<template>
  <div class="filter-section">
    <BaseField id="search">
      <InputWithIcon
        :model-value="transactions.state.filters.searchQuery"
        type="text"
        placeholder="Search transaction"
        @update:model-value="transactions.updateFilter('searchQuery', $event)"
      />
    </BaseField>
    <div class="filter-wrapper">
      <BaseSelect
        v-model="transactions.state.filters.orderSelected"
        class="sort"
        label="Sort By"
        :options="sortOptions"
      />
      <BaseSelect
        v-model="transactions.state.filters.categorySelected"
        class="category-sort"
        label="Category"
        :options="categoryOptions"
      />
    </div>
  </div>
</template>

<style scoped>
.filter-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: var(--spacing-150);
}

.filter-wrapper {
  display: flex;
  align-items: center;
  gap: var(--spacing-150);
}
</style>
