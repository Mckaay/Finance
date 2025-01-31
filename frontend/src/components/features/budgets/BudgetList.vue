<script setup>
import BudgetListItem from "@/components/features/budgets/BudgetListItem.vue";
import DeleteBudgetModal from "@/components/features/budgets/DeleteBudgetModal.vue";
import {inject, ref, useTemplateRef} from "vue";
import EditBudgetModal from "@/components/features/budgets/EditBudgetModal.vue";

const budgetService = inject("budgetService");

const props = defineProps({
  budgets: {
    type: Array,
    default: [],
  }
})

const editBudgetModalRef = useTemplateRef('editBudgetModal');
const deleteBudgetModalRef = useTemplateRef('deleteBudgetModal');

const openDeleteModal = (budget) => {
  if (budget.id == null) {
    return;
  }

  budgetService.currentlyClickedBudgetToBeEditedOrDeleted.value = budget;
  deleteBudgetModalRef?.value.openModal();
}

const openEditModal = (budget) => {
  if (budget.id == null) {
    return;
  }

  budgetService.currentlyClickedBudgetToBeEditedOrDeleted.value = budget;
  editBudgetModalRef?.value.openModal();
}
</script>

<template>
  <section v-if="budgets.length > 0" class="budget-list">
    <EditBudgetModal ref="editBudgetModal"/>
    <DeleteBudgetModal ref="deleteBudgetModal"/>
    <BudgetListItem v-for="budget in budgets"
                :key="budget.id"
                :budget="budget"
                @edit="openEditModal"
                @delete="openDeleteModal"
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