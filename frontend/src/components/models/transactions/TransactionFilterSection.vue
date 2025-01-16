<script setup>
import Select from "@/components/forms/Select.vue";
import Field from "@/components/forms/Field.vue";
import InputWithIcon from "@/components/forms/InputWithIcon.vue";
import {computed, inject, watch} from "vue";

const props = defineProps({
  categories: {
    type: Array,
    default: [],
  }
})

const filterParams = inject('filters');

const categoriesOptions = computed(() => {
  return [
    {
      value: '0',
      label: 'All Transactions'
    },
    ...props.categories
  ]
});

const sortOptions = [
  {value: 'latest', label: 'Latest'},
  {value: 'oldest', label: 'Oldest'},
  {value: 'atoz', label: 'A to Z'},
  {value: 'ztoa', label: 'Z to A'},
  {value: 'highest', label: 'Highest'},
  {value: 'lowest', label: 'Lowest'}
];
</script>

<template>
  <div class="filter-section">
    <Field id="search">
      <InputWithIcon
          v-model="filterParams.searchQuery"
          type="text"
          placeholder="Search transaction"
      />
    </Field>
    <div class="filter-wrapper">
      <Select class="sort"
              v-model="filterParams.orderSelected"
              label="Sort By"
              :options="sortOptions"
      />
      <Select
          class="category-sort"
          v-model="filterParams.categorySelected"
          label="Category"
          :options="categoriesOptions"
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