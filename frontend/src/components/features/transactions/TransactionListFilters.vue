<script setup>
import {computed, inject} from 'vue';
import Select from "@/components/shared/forms/Select.vue";
import Field from "@/components/shared/forms/Field.vue";
import InputWithIcon from "@/components/shared/forms/InputWithIcon.vue";
import {useTransactions} from "@/composables/transactions.js";
import {useCategories} from "@/composables/categories.js";

const transactions = useTransactions();
const categories = useCategories();

const sortOptions = [
  { value: 'latest', label: 'Latest' },
  { value: 'oldest', label: 'Oldest' },
  { value: 'atoz', label: 'A to Z' },
  { value: 'ztoa', label: 'Z to A' },
  { value: 'highest', label: 'Highest' },
  { value: 'lowest', label: 'Lowest' }
];

const categoryOptions = computed(() => {
  return [
    {
      value: 0,
      label: 'All Transactions'
    },
    ...categories.state.list
  ]
});
</script>

<template>
  <div class="filter-section">
    <Field id="search">
      <InputWithIcon
          :model-value="transactions.state.filters.searchQuery"
          @update:modelValue="transactions.updateFilter('searchQuery', $event)"
          type="text"
          placeholder="Search transaction"
      />
    </Field>
    <div class="filter-wrapper">
      <Select
          class="sort"
          v-model="transactions.state.filters.orderSelected"
          label="Sort By"
          :options="sortOptions"
      />
      <Select
          class="category-sort"
          v-model="transactions.state.filters.categorySelected"
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