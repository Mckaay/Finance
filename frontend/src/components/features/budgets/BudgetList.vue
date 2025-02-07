<script setup>
import BudgetListItem from "@/components/features/budgets/BudgetListItem.vue";
import { useBudgets } from "@/composables/budgets.js";

const budgetService = useBudgets();

defineProps({
  budgets: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(["openEditModal", "openDeleteModal"]);

const emitOpenEditModalEvent = (budget) => {
  if (budget.id === 0) {
    return;
  }

  budgetService.state.selectedForEditOrDelete = budget;
  emit("openEditModal");
};

const emitOpenDeleteModalEvent = (budget) => {
  if (budget.id === 0) {
    return;
  }

  budgetService.state.selectedForEditOrDelete = budget;
  emit("openDeleteModal");
};
</script>

<template>
  <section
    v-if="budgets.length > 0"
    class="budget-list"
  >
    <BudgetListItem
      v-for="budget in budgets"
      :key="budget.id"
      :budget="budget"
      @edit="emitOpenEditModalEvent"
      @delete="emitOpenDeleteModalEvent"
    />
  </section>
</template>

<style scoped>
.budget-list {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-150);

  @media screen and (min-width: 1280px) {
    grid-column: 2 / -1;
  }
}
</style>
